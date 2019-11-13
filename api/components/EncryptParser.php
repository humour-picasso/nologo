<?php
/**
 * Created by PhpStorm.
 * User: guest1
 * Date: 2018/5/28
 * Time: 下午3:01
 */

namespace api\components;

use common\components\DesCrypt;
use yii\base\InvalidParamException;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;

class EncryptParser extends \yii\web\JsonParser
{
    //override
    public function parse($rawBody, $contentType)
    {
        try {
            if( \Yii::$app->params['isEncrypt']) {
                $rawBody = DesCrypt::decrypt($rawBody);
            }
            $parameters = Json::decode($rawBody, $this->asArray);
            return $parameters === null ? [] : $parameters;
        } catch (InvalidParamException $e) {
            if ($this->throwException) {
                throw new BadRequestHttpException('Invalid Encrypt Data in request body: ' . $e->getMessage());
            }

            return [];
        }
    }
}