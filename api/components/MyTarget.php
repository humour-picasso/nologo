<?php
namespace api\components;

use common\components\DesCrypt;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

/**
 * Created by PhpStorm.
 * User: yuhao
 * Date: 2018/11/27
 * Time: 17:01
 */
class MyTarget extends \yii\log\DbTarget{

    protected function getContextMessage()
    {
        $context = ArrayHelper::filter($GLOBALS, $this->logVars);
        try{
            $context['_PARAM'] =  DesCrypt::decrypt(file_get_contents('php://input'));
        }catch (\Throwable $e){

        }

        $result = [];
        foreach ($context as $key => $value) {
            $result[] = "\${$key} = " . VarDumper::dumpAsString($value);
        }

        return implode("\n\n", $result);
    }

}