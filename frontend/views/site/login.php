<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '欢迎回来';
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

                    <?= $form->field($model, 'username')->textInput(['placeholder'=>'请输入用户名或邮箱','style'=>'box-shadow:5px 5px 2px #ccc;'])->label(false) ?>


                    <?= $form->field($model, 'password')->passwordInput(['placeholder'=>'请输入密码','style'=>'box-shadow:5px 5px 2px #ccc;'])->label(false)  ?>

                    <div class="form-group">
                        <?= Html::submitButton('登录', ['class' => 'btn btn-primary col-lg-12', 'name' => 'signup-button']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                    <?= Html::a('忘记密码？找回密码',\yii\helpers\Url::to('/site/login')) ?>
                </div>
            </div>
        </div>
    </div>
</div>





