<?php

namespace frontend\models;

use common\models\Order;
use Yii;
use yii\base\Model;
/**
 * Login form
 */
class OrderForm extends Model
{

    public $url;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['url', 'url'],
        ];
    }

    /**
     * 解析记录
     */
    public function findOrder()
    {
        $user_id = Yii::$app->user->getId();
        $query = Order::find()->where(['user_id'=>$user_id])->andFilterWhere(['like','parse_url',$this->url]);

        return $query;

    }

}
