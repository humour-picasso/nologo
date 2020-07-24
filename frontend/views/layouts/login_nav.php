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
                    <ul class="nav navbar-nav navbar-right">
                        <li id="active"><a href="/">回到主页</a></li>
<!--                        <li id="why-us"><a href="javascript:;">如何使用</a></li>-->
<!--                        <li id="price"><a href="javascript:;">价格</a></li>-->
                    </ul>
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

