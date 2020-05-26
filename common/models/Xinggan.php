<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "nl_xinggan".
 *
 * @property int $id
 * @property string $name
 * @property string $img_url
 * @property int $created_at
 */
class Xinggan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nl_xinggan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'img_url', 'created_at'], 'required'],
            [['created_at'], 'integer'],
            [['name', 'img_url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'img_url' => 'Img Url',
            'created_at' => 'Created At',
        ];
    }
}
