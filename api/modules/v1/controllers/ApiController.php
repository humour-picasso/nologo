<?php

namespace api\modules\v1\controllers;

use common\components\ApiResponse;

class ApiController extends BaseController
{
    public $modelClass = 'api\models\Test';


    protected function verbs()
    {
        return [
            'index' => ['GET'],
            'test' => ['GET'],
        ];
    }

//    public function behaviors()
//    {
//        $behaviors = parent::behaviors();
//        $behaviors['authenticator']['only'] = [
//            ''
//        ];
//
//        return $behaviors;
//
//    }

    public function actionIndex()
    {
        return ApiResponse::success();
    }

}