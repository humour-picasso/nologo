<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "nl_customer_limit".
 *
 * @property int $id
 * @property int $customer_id
 * @property int $click_cnt
 */
class CustomerLimit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nl_customer_limit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id'], 'required'],
            [['customer_id', 'click_cnt'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_id' => 'Customer ID',
            'click_cnt' => 'Click Cnt',
        ];
    }
}
