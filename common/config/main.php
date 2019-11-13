<?php

$components = require(__DIR__  . '/' . YII_ENV . '/components.php');
$params = require(__DIR__  . '/' . YII_ENV . '/params.php');

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'db' => $components['database'],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                'db' => [
                    'class' => 'yii\log\DbTarget','except' => [
                        'yii\debug\Module::checkAccess',
                        'yii\web\HttpException:401',
                        'yii\web\HttpException:404',

                    ],
                    'levels' => ['error', 'warning', 'info'],
                    // 'logVars' => [],
                    'categories' => [

                    ],
                ],
            ]
        ],
    ],
    'params' => $params

];
