<?php
namespace frontend\models;

use common\models\WebCustomer;
use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $passwordRepeat;
    public $verifyCode;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required','message' => '请输入用户名'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => '这个用户名已被使用'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required','message' => '请输入邮箱地址'],
            ['email', 'email','message' => '邮箱格式错误，请重新输入'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => '邮箱已被使用'],

            [['password','passwordRepeat'],'required','message' => '请输入密码'],
            ['password','string', 'min' => 6],
            ['passwordRepeat', 'compare', 'compareAttribute' => 'password', 'skipOnEmpty' => false, 'message' => "两次密码不不一致"],
            ['verifyCode', 'required','message' => "请输入验证码"],
            ['verifyCode', 'captcha','message' => "验证码错误"],
        ];
    }
//    public function attributeLabels()
//    {
//        return [
//            'verifyCode' => 'dwadadaw',//在官网的教程里是加上了英文字母，我这里先给去掉了,这里去 掉会不会产生影响因为我还没做接收验证，只做了验证码显示的功能，你们可以自己测试下
//        ];
//    }
    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        if ($user->save()) {
            return $user;
        }
        return null;

    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
