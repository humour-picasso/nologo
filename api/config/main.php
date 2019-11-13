<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'layout' => false,

    'components' => [
        'user' => [
            'identityClass' => 'common\models\Customer',
            'enableAutoLogin' => true
        ],
        'response'=>[

            'class' => 'yii\web\Response',
            'format' => 'json',
            'charset' => 'UTF-8',
            'formatters' => [
                'json' => [
                    'class' => 'yii\web\JsonResponseFormatter',
                    'prettyPrint' => true, // use "pretty" output in debug mode
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ],
            ],
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                /**
                 * $response->isSuccessful 表示是否会抛出异常
                 * 值为 true, 代表返回数据正常，没有抛出异常
                 */
                if (!$response->isSuccessful) {
                    $exception = Yii::$app->getErrorHandler()->exception;

                    if ($exception instanceof \yii\web\UnauthorizedHttpException) {
                        // \yii::error($exception->getMessage(), 'SYSTEM_ERROR');
                        $response->statusCode = 200;

                        $ary = [
                            'code' => \common\components\ResponseCode::INVALID_TOKEN,
                            'msg' => 'ACCESS_TOKEN is invalid',
                            'data' => null
                        ];
                    }  elseif ($exception instanceof \yii\web\NotFoundHttpException) {
                        $response->statusCode = 200;
                        $ary = [
                            'code' => \common\components\ResponseCode::NOT_FOUND,
                            'msg' => 'Page not Fount',
                            'data' => null
                        ];
                    } else {
                        $response->statusCode = 200;
                        \yii::error($exception->getMessage() . "-" . $exception->getFile() . "-" . $exception->getLine(), 'SYSTEM_ERROR');
                        $msg = "Internal Error: , Err: " . $exception->getMessage() . " " .
                            $exception->getFile() . " " . $exception->getLine() . $exception->getTraceAsString();

                        $ary = [
                            'code' => \common\components\ResponseCode::GENERAL_EXCEPTION_CODE,
                            'msg' => $msg,
                            'data' => null
                        ];
                    }
                    $response->data = $ary;
                }
                return true;
            },
        ],
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'text/json' => 'yii\web\JsonParser',
            ],
            'cookieValidationKey' => 'M_TCjSkHfOWGqPR2m-nNmLsV_xUfnn6R',
            'enableCsrfValidation' => false,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ]
    ],
    'modules' => [
        // 添加模块v1
        'v1' => [
            'class' => 'api\modules\v1\Module'
        ],
    ],
    'params' => $params,
];
