<?php
/**
 * Created by PhpStorm.
 * User: guest1
 * Date: 2018/6/7
 * Time: 下午3:32
 */

namespace common\components;


use Yii;

class CustomerFunc
{
    public static function deleteToken ($event){
        Yii::$app->cache->delete($event->sender->access_token);
    }
}