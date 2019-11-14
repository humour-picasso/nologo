<?php

namespace api\modules\v1\controllers;

use Codeception\Template\Api;
use common\components\ApiResponse;
use common\components\ResponseCode;
use GuzzleHttp\Client;

class ApiController extends BaseController
{
    public $modelClass = 'api\models\Test';
    private $appid = "wx65f5219f7c4e0132";
    private $secret = "aaa";
//    private $secret = "6d65a43d105d4b15a4c19144a3b74cce";

    protected function verbs()
    {
        return [
            'wechat-login' => ['POST','OPTIONS'],
        ];
    }

    public function actionWechatLogin()
    {
        $code = \Yii::$app->request->post('code');
        $client = new Client();

        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=".$this->appid."&secret=".$this->secret."&js_code=".$code."&grant_type=authorization_code";
        $request = $client->request('GET',$url);
        $result = \GuzzleHttp\json_decode($request->getBody()->getContents());
        if (isset($result['errcode']) && $result['errcode'] != 0){
            $data['code'] = ResponseCode::INVALID_TOKEN;
            return ApiResponse::fail($data);
        }else{
            //检查用户是否存在



            return ApiResponse::success();
        }


    }

}