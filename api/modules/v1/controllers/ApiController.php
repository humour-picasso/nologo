<?php

namespace api\modules\v1\controllers;

use api\modules\v1\model\Customer;
use common\components\ApiResponse;
use common\components\ResponseCode;
use FFMpeg\FFMpeg;
use GuzzleHttp\Client;

class ApiController extends BaseController
{
    public $modelClass = 'api\models\Test';
    private $appid = "wx65f5219f7c4e0132";
//    private $secret = "aaa";
    private $secret = "6d65a43d105d4b15a4c19144a3b74cce";

    protected function verbs()
    {
        return [
            'wechat-login' => ['POST','OPTIONS'],
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
        $url = "http://qsy.weikan.club/index.php/index/jiexi.html";

        $headers = [

            'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8',

            'X-Requested-With' => 'XMLHttpRequest',
        ];

        $client = new Client(['headers'=>$headers]);

        //允许重定向获取html

        $res = $client->request('POST', $url,
            ['form_params' => [
                'url' => $requestUrl,
            ]
        ]);


        $data['data'] = \GuzzleHttp\json_decode($res->getBody()->getContents());
        return ApiResponse::success($data);
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

}