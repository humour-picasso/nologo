<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'language' => 'en-US',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module',
            'layout' => 'left-menu',//yii2-admin的导航菜
        ],
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
        ]
    ],

    'components' => [
        'view' => [
//            'theme' => [
//                'pathMap' => [
//                    '@app/views' => '@vendor/lkk/yii2-inspinia/views'
//                ],
//            ],
        ],
        'assetManager' => [
            'bundles' => [
                'dmstr\web\AdminLteAsset' => [
                    'skin' => 'skin-black',
                ],
            ],
        ],
        'JsonFormat' => [
            'class' => 'backend\components\JsonFormat',
        ],

        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],

        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],

        'authManager' => [
            'class' => 'yii\rbac\DbManager', // 使用数据库管理配置文件
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [

            ],
        ],
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            '*',
//            'gii'
            //'admin/*',//允许所有人访问admin节点及其子节点
            //此处的action列表，允许任何人（包括游客）访问
            //所以如果是正式环境（线上环境），不应该在这里配置任何东西，为空即可
            //但是为了在开发环境更简单的使用，可以在此处配置你所需要的任何权限
            //在开发完成之后，需要清空这里的配置，转而在系统里面通过RBAC配置权限
        ]
    ],
    'params' => $params,

];
