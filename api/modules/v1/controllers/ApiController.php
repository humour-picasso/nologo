<?php

namespace api\modules\v1\controllers;

use api\modules\v1\model\Customer;
use common\components\ApiResponse;
use common\components\ResponseCode;
use common\models\Qingchun;
use common\models\Tmp;
use common\models\Xinggan;
use FFMpeg\FFMpeg;
use GuzzleHttp\Client;

class ApiController extends BaseController
{
    public $modelClass = 'api\models\Test';
    private $appid = "wx65f5219f7c4e0132";
    private $secret = "6d65a43d105d4b15a4c19144a3b74cce";

    protected function verbs()
    {
        return [
            'wechat-login' => ['POST','OPTIONS'],
            'mv-login' => ['POST','OPTIONS'],
            'get-xinggan' => ['POST','OPTIONS'],
            'get-qingchun' => ['POST','OPTIONS'],
            'get-detail' => ['POST','OPTIONS'],
        ];
    }

    /**
     * 登录验证过滤器
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['only'] = [
            'video-conversion',
            'update',
            'get-xinggan',
            'get-qingchun',
            'get-detail'
        ];
        return $behaviors;
    }

    public function actionWechatLogin()
    {
        $code = \Yii::$app->request->post('code');
        $client = new Client();

        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=".$this->appid."&secret=".$this->secret."&js_code=".$code."&grant_type=authorization_code";
        $request = $client->request('GET',$url);
        $result = \GuzzleHttp\json_decode($request->getBody()->getContents());

        if (isset($result->errcode) && $result->errcode != 0){
            $data['code'] = ResponseCode::INVALID_PARAMS;
            return ApiResponse::fail($data);
        }else{
            //检查用户是否存在
            $check = Customer::find()->where(['openid'=>$result->openid])->one();
            if($check == null){
                $customer = new Customer();
                $customer->openid = $result->openid;
                $customer->access_token = md5(uniqid() .$result->openid);
                $customer->register_time = time();
                $customer->turn_times = 5;//默认转换次数

                if ($customer->save(false)){
                    $data['data']['access_token'] = $customer->access_token;
                    return ApiResponse::success($data);
                }
            }else{
                $data['data']['access_token'] = $check->access_token;
                return ApiResponse::success($data);
            }
        }

    }

    public function actionUpdate()
    {
        $userInfo = \Yii::$app->request->post('userInfo');

        $customer = \Yii::$app->getUser()->getIdentity();
        $customer->username = $userInfo['nickName'] ?? '';
        $customer->gender = $userInfo['gender'] ?? '';
        $customer->city = $userInfo['city'] ?? '';
        $customer->province = $userInfo['province'] ?? '';
        $customer->avatarUrl = $userInfo['avatarUrl'] ?? '';
        if($customer->save(false)){
            return ApiResponse::success();
        }else{
            return ApiResponse::fail();
        }

    }

    public function actionVideoConversion()
    {
        $requestUrl = \Yii::$app->request->post('videoUrl');
        $url = "https://www.tingsang.com/ajax/analyze.php";

        $headers = [

            'Content-Type' => 'application/json; charset=UTF-8',

//            'X-Requested-With' => 'XMLHttpRequest',
        ];

        $client = new Client(['headers'=>$headers]);

        //允许重定向获取html

        $res = $client->request('POST', $url,
            ['form_params' => [
                'link' => $requestUrl,
            ]
        ]);

        $response = json_decode($res->getBody()->getContents(),true);

        if ($response['code'] == 100){
            $result = [
                'code' => 100,
                'info' => '获取成功',
                'url'  => $response['data']['downurl'],
            ];
            $data['data'] = $result;
            return ApiResponse::success($data);
        }else{
            return ApiResponse::fail();
        }
    }

    /**
     * 下载解析视频到本地
     */
    public function actionDownload()
    {
        $url = base64_decode(\Yii::$app->request->get('url'));

        $client = new Client();

        $content = $client->get($url)->getBody()->getContents();

        $code = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $rand = $code[rand(0,25)]
            .strtoupper(dechex(date('m')))
            .date('d').substr(time(),-5)
            .substr(microtime(),2,5)
            .sprintf('%02d',rand(0,99));
        for(
            $a = md5( $rand, true ),
            $s = '0123456789ABCDEFGHIJKLMNOPQRSTUV',
            $d = '',
            $f = 0;
            $f < 8;
            $g = ord( $a[ $f ] ),
            $d .= $s[ ( $g ^ ord( $a[ $f + 8 ] ) ) - $g & 0x1F ],
            $f++
        );

        $filename = __DIR__ . "/../../../runtime/video/".$d.".mp4";

        $video = fopen($filename, "w") or die("Unable to open file!");

        fwrite($video, $content);
        fclose($video);

        $size = filesize($filename);
        header("Content-type: video/mp4");
        header("Accept-Ranges: bytes");
        if(isset($_SERVER['HTTP_RANGE'])){
            header("HTTP/1.1 206 Partial Content");
            list($name, $range) = explode("=", $_SERVER['HTTP_RANGE']);
            list($begin, $end) =explode("-", $range);
            if($end == 0){
                $end = $size - 1;
            }
        }else {
            $begin = 0; $end = $size - 1;
        }
        header("Content-Length: " . ($end - $begin + 1));
        header("Content-Disposition: filename=".$filename);
        header("Content-Range: bytes ".$begin."-".$end."/".$size);

        $response = file_get_contents($filename);
        echo $response;


    }


    public function actionMvLogin()
    {
        $code = \Yii::$app->request->post('code');
        $client = new Client();

        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=wx6deba7e9fd8804b8&secret=ff92cb04a0e393f5a6d5f524db6cfef2&js_code=".$code."&grant_type=authorization_code";
        $request = $client->request('GET',$url);
        $result = \GuzzleHttp\json_decode($request->getBody()->getContents());

        if (isset($result->errcode) && $result->errcode != 0){
            $data['code'] = ResponseCode::INVALID_PARAMS;
            return ApiResponse::fail($data);
        }else{
            //检查用户是否存在
            $check = Customer::find()->where(['openid'=>$result->openid])->one();
            if($check == null){
                $customer = new Customer();
                $customer->openid = $result->openid;
                $customer->access_token = md5(uniqid() .$result->openid);
                $customer->register_time = time();
                $customer->turn_times = 5;//默认转换次数

                if ($customer->save(false)){
                    $data['data']['access_token'] = $customer->access_token;
                    return ApiResponse::success($data);
                }
            }else{
                $data['data']['access_token'] = $check->access_token;
                return ApiResponse::success($data);
            }
        }
    }

    public function actionGetXinggan()
    {
        $page = \Yii::$app->request->post('page') ?? 1;

        $xinggan = Tmp::find()->offset(($page-1)*6)->limit(6)->groupBy('name')->all();

        if (empty($qingchun)){
            $xinggan = Tmp::find()->offset(($page-8)*6)->limit(6)->groupBy('name')->all();
        }
        $data['data'] = $xinggan;
        return ApiResponse::success($data);
    }

    public function actionGetQingchun()
    {
        $page = \Yii::$app->request->post('page') ?? 1;

        $qingchun = Tmp::find()->offset(($page-1)*6)->limit(6)->groupBy('name')->orderBy('id desc')->all();
        if (empty($qingchun)){
            $qingchun = Tmp::find()->offset(($page-8)*6)->limit(6)->groupBy('name')->orderBy('id desc')->all();
        }
        $data['data'] = $qingchun;
        return ApiResponse::success($data);
    }

    public function actionGetDetail()
    {
        $name = \Yii::$app->request->post('name') ?? '';
        $type = \Yii::$app->request->post('type') ?? 0;
        if ($type){
            $data = Tmp::find()->where(['name'=>$name])->all();
        }else{
            $data = Tmp::find()->where(['name'=>$name])->all();
        }

        $data['data'] = $data;
        return ApiResponse::success($data);
    }

}