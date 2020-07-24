<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'OVCg0LYiQRR7nchr_2VrGX_FNLG5MDSM',
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [
            'crud' => [
                'class' => 'yii\gii\generators\crud\Generator',
                'templates' => [
                    'ajax-modal' => '@vendor/dchaofei/yii2-ajaxmodal/gii-template/curd/default',
                ],

            ],
        ],
        'allowedIPs' => ['*'],
    ];
}

return $config;
