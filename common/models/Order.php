<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "nl_order".
 *
 * @property int $id
 * @property string $order_no 订单号
 * @property string $parse_url 解析视频地址
 * @property int $status 状态 默认0 解析成功1 解析失败2
 * @property int $created_at 创建时间
 * @property int $user_id 用户id
 * @property string|null $video_url 解析结果视频地址
 * @property string|null $img_url 视频封面图
 * @property string|null $md5
 * @property string|null $user_name 视频用户名
 * @property string|null $user_head_img 视频用户头像
 * @property string|null $desc 视频描述文案
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nl_order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_no', 'parse_url', 'user_id'], 'required'],
            [['status', 'created_at', 'user_id'], 'integer'],
            [['order_no', 'parse_url', 'video_url', 'img_url', 'md5', 'user_name', 'user_head_img', 'desc'], 'string', 'max' => 255],
            [['order_no'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_no' => 'Order No',
            'parse_url' => 'Parse Url',
            'status' => 'Status',
            'created_at' => 'Created At',
            'user_id' => 'User ID',
            'video_url' => 'Video Url',
            'img_url' => 'Img Url',
            'md5' => 'Md5',
            'user_name' => 'User Name',
            'user_head_img' => 'User Head Img',
            'desc' => 'Desc',
        ];
    }
}
