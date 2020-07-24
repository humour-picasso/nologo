
<div class="slider jumbotron">
    <div class="container">
        <div class="col-md-12">
            <div>
                <div><img src="/images/index.png" style="width: 96%;border-radius: 15px"></div>
                <h3>支持抖音、火山、头条、快手、梨视频、美拍、陌陌、皮皮搞笑、皮皮虾、全民搞笑、刷宝、微视、小咖秀、最右、微博、秒拍等视频解析。</h3>
                <h4>仅支持学习交流,勿用非法用途!</h4>
                <div style="text-align: center">
                    <a href="<?=\yii\helpers\Url::to('/site/signup')?>"><button class="btn btn-default" style="margin: 5px">注册</button></a>
                    <a href="<?=\yii\helpers\Url::to('/site/login')?>"><button class="btn btn-login" style="margin: 5px">登陆</button></a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="why-us" id="div-why-us">
    <div class="container">
        <h2 class="text-center">如何使用</h2>
        <div class="row">
            <div class="col-md-4 text-center">
                <div class="single-service active">
                    <img src="images/notification.png" alt="">
                    <h4>第一步</h4>
                    <p>打开短视频APP，点开某个视频，<br>点击右下角分享按钮，在分享弹框中点击复制链接或通过分享到微信QQ等获取分享链接</p>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="single-service">
                    <img src="images/compass.png" alt="">
                    <h4>第二步</h4>
                    <p>将刚才复制的链接粘贴到下面的输入框，例如：<br>
                        抖音：https://v.douyin.com/JJTDEKL/ <br>
                        快手：https://v.kuaishou.com/8CU76w
                    </p>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="single-service">
                    <img src="images/open-book.png" alt="">
                    <h4>大功告成</h4>
                    <p>点击解析按钮，即可获得无水印短视频，<br>点击下载到本地</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="pricing" id="div-price">
    <div class="container text-center">
        <h2>关于售价</h2>
        <div class="pricing-box">
            <div class="row">
                <div class="col-md-4">
                    <div class="single-price-block">
                        <h2 class="title">按次数</h2>
                        <div class="price">¥1.0 <small>/100次</small></div>
                        <ul>
                            <li><span>平均单次0.01元</span></li>
                            <li><span>适合低频次使用用户</span></li>
                        </ul>
                        <a href="<?=\yii\helpers\Url::to('/site/signup');?>"><button class="btn btn-default">Join!</button></a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="single-price-block">
                        <h2 class="title">包月</h2>
                        <div class="price">¥9.9 <small>/月</small></div>
                        <ul>
                            <li><span>包月不限次</span></li>
                            <li><span>适合短期高频用户</span></li>
                        </ul>
                        <a href="<?=\yii\helpers\Url::to('/site/signup');?>"><button class="btn btn-default">Join!</button></a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="single-price-block active">
                        <h2 class="title">包年</h2>
                        <div class="price">¥99 <small>/年</small></div>
                        <ul>
                            <li><span>包年畅享不限次</span></li>
                            <li><span>适合长期高频用户</span></li>
                        </ul>
                        <a href="<?=\yii\helpers\Url::to('/site/signup');?>"><button class="btn btn-default">Join!</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript">
    $('#active').click(function () {
        $('html , body').animate({scrollTop: 0},'normal');
    });
    $('#why-us').click(function () {
        document.getElementById('div-why-us').scrollIntoView({behavior:'smooth'});
    });
    $('#price').click(function () {
        document.getElementById('div-price').scrollIntoView({behavior:'smooth'});
    });
</script>