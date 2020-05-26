<?php


$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '_K0o7oyhIj6GlOwKmtws66QjLw9fxkAM',
        ],
    ],
];

if (YII_ENV_DEV) {
    $config['timezone'] = 'Asia/Ho_Chi_Minh';
//     configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
//        'allowedIPs' => ['*'],
    ];
    $config['bootstrap'][] = 'gii';
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
    $config['as access'] = [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            '*',
            //'/site/forbidden',
//            'admin-manage/reset-password',
//            'debug/*',
//            'admin/*',
//            'site/login',//允许访问的节点，可自行添加
//            'site/agent-login',
//            'site/agent-logout',
//            'site/language',
//            'channel/*',
            //'site/index',//后期需要删除，在rbac逐个添加

            //'admin/*',//允许所有人访问admin节点及其子节点
            //此处的action列表，允许任何人（包括游客）访问
            //所以如果是正式环境（线上环境），不应该在这里配置任何东西，为空即可
            //但是为了在开发环境更简单的使用，可以在此处配置你所需要的任何权限
            //在开发完成之后，需要清空这里的配置，转而在系统里面通过RBAC配置权限
        ]
    ];
}

return $config;
