<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Welcome';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="login-box">
        <div class="login-left">
            <img src="/images/jumbotron-bg.jpg">
        </div>
        <div class="site-signup">
            <div class="login-form">
                <h4 class="col-lg-10" style="color: #1196ff;text-align: center"><?= Html::encode($this->title) ?></h4>
                <div class="row">
                    <div class="col-lg-10">
                        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                        <?= $form->field($model, 'username')->textInput(['placeholder'=>'请输入用户名','style'=>'box-shadow:5px 5px 2px #ccc;'])->label(false)?>
                        <?= $form->field($model, 'email')->textInput(['placeholder'=>'请输入邮箱','style'=>'box-shadow:5px 5px 2px #ccc;'])->label(false)?>
                        <?= $form->field($model, 'password')->passwordInput(['placeholder'=>'请输入密码','style'=>'box-shadow:5px 5px 2px #ccc;'])->label(false)?>
                        <?= $form->field($model, 'passwordRepeat')->passwordInput(['placeholder'=>'请确认密码','style'=>'box-shadow:5px 5px 2px #ccc;'])->label(false)?>
                        <?= $form->field($model, 'verifyCode')->textInput(['placeholder'=>'验证码','style'=>'box-shadow:5px 5px 2px #ccc;border-radius:4px 0px 0px 4px;'])->label(false)?>
                        <?=\yii\captcha\Captcha::widget(['name'=>'captchaimg','imageOptions'=>['id'=>'captchaimg', 'title'=>'换一个', 'alt'=>'换一个', 'style'=>'border-radius:0px 4px 4px 0px ;box-shadow:5px 5px 2px #ccc;width:50%;height:34px;float:left;'],'template'=>'{image}'])?>
                        <div class="form-group" style="margin-top: 60px">
                            <?= Html::submitButton('立即注册', ['class' => 'btn btn-danger col-lg-12', 'name' => 'signup-button']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                        <?= Html::a('已有账号？立即登陆',\yii\helpers\Url::to('/site/login')) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>





