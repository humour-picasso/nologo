<?php
/**
 * Created by PhpStorm.
 * User: guest1
 * Date: 2018/6/1
 * Time: 上午10:11
 */

namespace api\modules\v1\form;

use api\modules\v1\model\Customer;
use backend\components\Util;
use common\components\ApiResponse;
use common\components\QiyeWeiXin;
use common\components\ResponseCode;
use common\models\Channel;
use common\models\IosCustomer;
use common\models\LoginLog;
use GuzzleHttp\Client;
use Yii;
use yii\base\Model;

class LoginByAccountKitForm extends Model
{
    //todo phoneNo format
    public $platform;
    public $fAccessToken;
    public $accountKitId;
    public $pushClientId;
    public $phoneNo;
    public $channelId;
    public $channelCode;
    public $lastLoginIp;

    public function rules()
    {
        return [
            [['accountKitId', 'fAccessToken', 'phoneNo', 'platform'], 'required'],
            [['platform'], 'in', 'range' => [1, 2]],
            [['phoneNo'], 'match', 'pattern' => '/^\d+$/i'],
            [['channelId'], "integer"],
            [['fAccessToken'], 'validateFacebookAccessToken'],
            [['pushClientId', 'channelCode'], 'string']
        ];
    }

    public function validateFacebookAccessToken($attribute)
    {
        $httpclient = new Client();
        if (YII_ENV == "dev") {
            return;
        } else {
            try{
                $res = $httpclient->request('GET', "https://graph.accountkit.com/v1.3/me/?access_token=" . $this->fAccessToken);
            }catch (\Throwable $exception){
                Yii::error($exception->getMessage(),'ApiValidateFbToken');
            }
        }
        $jsonObj = json_decode($res->getBody());
        if ("0" . $jsonObj->phone->national_number != $this->phoneNo) {
            $this->addError($attribute, Yii::t('app', 'faccesstoken validate error'));
        }
    }

    public function processAccountKit()
    {
        $rowCount = Customer::find()->andWhere([
            'phone_no' => $this->phoneNo,
        ])->count();
        if ($rowCount > 0) {
            return $this->loginPhone();
        } else {
            return $this->registerPhone();
        }

    }

    private function loginPhone()
    {
        $map = [
            "0120" => "070",
            "0121" => "079",
            "0122" => "077",
            "0123" => "083",
            "0124" => "084",
            "0125" => "085",
            "0162" => "032",
            "0163" => "033",
            "0164" => "034",
            "0165" => "035",
            "0186" => "056",
            "0199" => "059",
            "0126" => "076",
            "0128" => "078",
            "0127" => "081",
            "0129" => "082",
            "0166" => "036",
            "0167" => "037",
            "0168" => "038",
            "0169" => "039",
            "0188" => "058"
        ];
        $subphone = substr($this->phoneNo, 0, 4);
        if (isset($map[$subphone])) {
            $data['code'] = ResponseCode::DEPRECA_PHONE;
            $data['msg'] = Yii::t("app", "Please use new phone number.");
            return ApiResponse::fail($data);
        }


        $cache = \Yii::$app->cache;

        $customer = Customer::find()->andWhere(['phone_no' => $this->phoneNo])->one();

        if ($customer) {
            $cache->delete($customer->access_token);
        }

        if ($customer->register_system == 3) {
            $customer->register_system = $this->platform;
        } elseif ($customer->register_system != $this->platform && $customer->status == 0) {
            $data['code'] = ResponseCode::LOGIN_ACROSS_PLATFORM_WITHOUT_AUTHRITION;
            $data['msg'] = Yii::t("app", "Please complete authorization with your first login device.");
            return ApiResponse::fail($data);
        }
        if ($this->pushClientId) {
            $customer->client_id = $this->pushClientId;
        }
        $customer->account_kit_id = $this->accountKitId;
        $customer->access_token = md5(uniqid() . $this->accountKitId);
        $customer->last_login_time = time();

        //更新最近登录ip地址
        $customer->last_login_ip = self::getRealIP();
        if ($this->channelCode != '') {
            //\backend\components\Util::DingDingMessage('facebook登陆以后channel_code是：' . $this->channelCode);
        }

        //推广channel code 优先判断
        if ($this->channelCode) {

            if ($this->channelCode == "tictic-facebook") {
                $this->channelId = 2;//hacked Facebook 广告不让更新，沿用的还是老链接 utm_source=tictic-facebook&utm_campaign=6fa03310ed2859cf65f4b2d691f5a8381543372832
            } else {

                //查找channelid
                $channel = Channel::find()->where(['channel_code' => $this->channelCode])->one();
                if ($channel) {
                    $this->channelId = $channel->id;
                }
            }
        }

        #渠道app
        if ($this->channelId) {
            #赋值当前app
            $customer->current_channel = $this->channelId;
        } elseif ($this->channelId == 0) {
            $customer->current_channel = 0;
        }


        //mark cross login
        if ($customer->cross_login == 0 && $customer->channel_id != $customer->current_channel) {
            $customer->cross_login = 1;
        }
        //log the login
        $login = new LoginLog();
        $login->customer_id = $customer->id;
        $login->create_time = time();
        $login->phone_no = $customer->phone_no;
        $login->login_channel = $this->channelId ?? 0;
        $login->save();

        if ($customer->save()) {
            $data['data'] = ['ACCESSTOKEN' => $customer->access_token];
            return ApiResponse::success($data);
        } else {
            $data['code'] = ResponseCode::DB_ERROR;
            $data['msg'] = json_encode($customer->getErrors());
            return ApiResponse::fail($data);
        }

    }

    private function registerPhone()
    {


        $map = [
            "0120" => "070",
            "0121" => "079",
            "0122" => "077",
            "0123" => "083",
            "0124" => "084",
            "0125" => "085",
            "0162" => "032",
            "0163" => "033",
            "0164" => "034",
            "0165" => "035",
            "0186" => "056",
            "0199" => "059",
            "0126" => "076",
            "0128" => "078",
            "0127" => "081",
            "0129" => "082",
            "0166" => "036",
            "0167" => "037",
            "0168" => "038",
            "0169" => "039",
            "0188" => "058"
        ];
        $subphone = substr($this->phoneNo, 0, 4);
        if (isset($map[$subphone])) {
            $data['code'] = ResponseCode::DEPRECA_PHONE;
            $data['msg'] = Yii::t("app", "Please use new phone number.");
            return ApiResponse::fail($data);
        }

        $customer = new Customer();
        $customer->phone_no = $this->phoneNo;
        $customer->status = 0;
        $customer->realname_status = 0;
        $customer->card_bind_status = 0;
        $customer->address_status = 0;
        $customer->mobile_status = 0;
        $customer->credit_status = 0;
        $customer->elinkman_status = 0;
        $customer->register_time = time();
        $customer->is_black = 0;
        if ($this->pushClientId) {
            $customer->client_id = $this->pushClientId;
        }
        $customer->account_kit_id = $this->accountKitId;
        $customer->faccess_token = !empty($this->fAccessToken) ? $this->fAccessToken : '';

        $customer->last_login_time = time();
        $customer->access_token = md5(uniqid() . $this->accountKitId);
        $customer->register_system = $this->platform;

        $customer->register_ip = self::getRealIP();
        if ($this->channelCode != '') {
           // \backend\components\Util::DingDingMessage('登陆以后channel_code是：' . $this->channelCode, false, 'chat4b8a6dda115f0dd05e20da11b4005703');
        }

        //推广channel code 优先判断
        if ($this->channelCode) {
            //查找channelid

            if ($this->channelCode == "tictic-facebook") {
                $this->channelId = 2;//hacked Facebook 广告不让更新，沿用的还是老链接 utm_source=tictic-facebook&utm_campaign=6fa03310ed2859cf65f4b2d691f5a8381543372832
            } else {
                $channel = Channel::find()->where(['channel_code' => $this->channelCode])->one();
                if ($channel) {
                    $this->channelId = $channel->id;
                }
            }
        }



        #渠道app
        if ($this->channelId) {
            $customer->channel_id = $this->channelId; #标记用户渠道来源
            $customer->current_channel = $this->channelId; #赋值当前app
        }
        //购买的ios用户信息,渠道ID为105
        $iosCustomer = IosCustomer::find()->where(['phone_no'=>$this->phoneNo])->one();
        if ($iosCustomer != null && $this->platform == 2){
            $customer->channel_id = 105;
        }

        if (Yii::$app->language == 'en-US') {
            $customer->language = 0;
        } elseif (Yii::$app->language == 'VN') {
            $customer->language = 2;
        } elseif (Yii::$app->language == 'zh-CN') {
            $customer->language = 1;
        }

        if ($customer->save()) {
            //todo agent_id
            //$data['data'] = $customer;
            $data['data'] = ['ACCESSTOKEN' => $customer->access_token];
            return ApiResponse::success($data);
        } else {
            $data['code'] = ResponseCode::DB_ERROR;
            $data['msg'] = json_encode($customer->getErrors());
            return ApiResponse::fail($data);
        }

    }

    public function getRealIP()
    {
        if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
           // Util::DingDingMessage('1');
        }else if(isset($_SERVER['HTTP_X_REAL_IP']) && !empty($_SERVER['HTTP_X_REAL_IP'])){
            $ip = $_SERVER['HTTP_X_REAL_IP'];
           // Util::DingDingMessage('2');
        }else if(isset($_SERVER['HTTP_X_TRUE_IP']) && !empty($_SERVER['HTTP_X_TRUE_IP'])){
            $ip = $_SERVER['HTTP_X_TRUE_IP'];
            //Util::DingDingMessage('3');
        }else{
            //Util::DingDingMessage('4');
            $ip = Yii::$app->request->getUserIP();
        }

        return ip2long($ip);
    }
}