<div class="navigation">
    <nav class="navbar navbar-navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navigation" aria-expanded="false">
                    <span class="sr-only"></span>
                    <i class="fa fa-bars"></i>
                </button>
                <a href="/" class="navbar-brand">
                    <img src="/images/logo.png" style="width: 60px;margin-top: -10px;float: left" alt="">
                    <div style="float: left;margin: 10px 11px;font-size: 30px;">小云解析</div>
                </a>
            </div>
            <div class="collapse navbar-collapse" id="navigation">
                <?php if(Yii::$app->user->isGuest){?>
                <ul class="nav navbar-nav navbar-right">
                    <li id="active"><a href="javascript:;">Home</a></li>
                    <li id="why-us"><a href="javascript:;">如何使用</a></li>
                    <li id="price"><a href="javascript:;">价格</a></li>
                </ul>
                <?php }else{ ?>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="/backend/index">视频解析</a></li>
                        <li><a href="/backend/order">解析记录</a></li>
                        <li class="dropdown">
                            <a id="dLabel" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="javascript:;">
                                <span>充值服务</span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dLabel">
                                <li><a href="<?=\yii\helpers\Url::to('/backend/shop')?>"><i class="ion-edit"></i>选购套餐</a></li>
                                <li><a href="<?=\yii\helpers\Url::to('/backend/pay-log')?>" ><i class="ion-log-out"></i> 购买记录 </a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a id="dLabel" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="javascript:;">
                                <i class="fa fa-user" style="font-size: 20px"></i>
                                <span><?=Yii::$app->getUser()->getIdentity()->username?></span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dLabel">
                                <li><a href="<?=\yii\helpers\Url::to('/site/reset-password')?>"><i class="ion-edit"></i> 修改密码 </a></li>
                                <li><a href="javascript:;" class="logout"><i class="ion-log-out"></i> 退出登录 </a></li>
                            </ul>
                        </li>
                    </ul>
                <?}?>
            </div>
        </div>
    </nav>
</div>
<?php
    $csrf = Yii::$app->request->csrfParam;
    $csrfToken = Yii::$app->request->csrfToken;
    $script = <<<JS
    $(document).ready(function(){
        $('.logout').click(function () {
            $.post('/site/logout',{"{$csrf}":"{$csrfToken}"});
        });
    });

JS;
$this->registerJS($script);
?>

