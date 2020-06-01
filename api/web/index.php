<?php
$prod_List = [
    "api.littlecloud.fun"
];

$dev_List = [
    'nologo-api.local.com',
];


if (in_array($_SERVER['HTTP_HOST'], $prod_List)) {

    error_reporting(0);
    ini_set('display_errors', 1);
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    defined('YII_ENV') or define('YII_ENV', 'prod');
} elseif (in_array($_SERVER['HTTP_HOST'], $dev_List)) {

    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    defined('YII_ENV') or define('YII_ENV', 'dev');

} else {
    exit('domain miss');
}

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/../../common/config/bootstrap.php';
require __DIR__ . '/../config/bootstrap.php';

$config = yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/../../common/config/main.php',
    require __DIR__ . '/../../common/config/main-local.php',
    require __DIR__ . '/../config/main.php',
    require __DIR__ . '/../config/main-local.php'
);
(new yii\web\Application($config))->run();
