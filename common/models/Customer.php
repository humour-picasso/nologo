<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\filters\RateLimitInterface;
use yii\web\IdentityInterface;
/**
 * This is the model class for table "nl_customer".
 *
 * @property int $id
 * @property string $openid
 * @property string $access_token 登录token
 * @property int $register_time 注册时间
 * @property int $turn_times 剩余转换次数
 * @property string $username 微信名
 * @property string $avatarUrl 头像
 * @property int $gender 性别 0：未知、1：男、2：女
 * @property string $province 省份
 * @property string $city 城市
 * @property string $country 国家
 */
class Customer extends ActiveRecord implements IdentityInterface,RateLimitInterface
{


    /**
     * Customer constructor.
     */
    public function __construct()
    {
        $this->on(parent::EVENT_BEFORE_UPDATE,["common\components\CustomerFunc","deleteToken"]);
    }


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nl_customer';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $customer = static::find()
            ->where(['access_token' => $token])
            ->one();
        return $customer;
//        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    # 速度控制  6秒内访问3次，注意，数组的第一个不要设置1，设置1会出问题，一定要
    # 大于2，譬如下面  6秒内只能访问三次
    # 文档标注：返回允许的请求的最大数目及时间，例如，[100, 600] 表示在600秒内最多100次的API调用。
    public function getRateLimit($request, $action)
    {

        return [200, 300]; // $rateLimit requests per second
    }

    public function loadAllowance($request, $action)
    {
        return [$this->allowance, $this->allowance_updated_at];
    }

    public function saveAllowance($request, $action, $allowance, $timestamp)
    {
        $this->allowance = $allowance;
        $this->allowance_updated_at = $timestamp;
        if (!$this->save())
        {
            print_r($this->getErrors());exit;
        }
    }
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

}
