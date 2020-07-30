<div class="container-box">
    <div id="app" class="clearfix">
        <el-card class="box-card">
            <div slot="header" class="clearfix">
                <span>我的余额</span>
                <el-button style="float: right; padding: 3px 0" type="text">充值</el-button>
            </div>
            <div class="text item">
                ¥ 100.00
            </div>
        </el-card>

        <el-card class="box-card">
            <div slot="header" class="clearfix">
                <span>到期时间</span>
            </div>
            <div class="text item">
                2020-10-01
            </div>
        </el-card>

        <el-card class="box-card">
            <div slot="header" class="clearfix">
                <span>剩余次数</span>
            </div>
            <div class="text item">
                包月无限次
            </div>
        </el-card>

        <el-card class="box-card">
            <div slot="header" class="clearfix">
                <span>联系客服</span>
            </div>
            <div class="text item">
                QQ：1641970153
            </div>
        </el-card>

        <div class="parse-box clearfix">
            <div class="form-group">
                <input type="text" class="form-control"  id="url" placeholder="请粘贴短视频地址">
            </div>
            <button type="button" class="btn btn-danger" id="parse-btn">解析</button>
        </div>
        <div class="parse-box clearfix">
            <a href="javascript:;" class="btn btn-success hidden" style="margin-left: 5px" id="download-btn">下载视频</a>
            <a href="javascript:;" class="btn btn-warning hidden" style="margin-left: 5px" id="copy-btn">复制链接</a>

        </div>
            <div class="order-table">
                <el-timeline :reverse="reverse">
                    <el-timeline-item
                            v-for="(activity, index) in activities"
                            :key="index">
                        <li><b style="font-size: large">{{activity.step}}</b></li>
                        <li><b>{{activity.content}}</b></li>
                    </el-timeline-item>
                </el-timeline>
            </div>
        <input id="copy-text" value="" style="background-color: rgba(0,0,0,0);border: none;color: rgba(0,0,0,0);width: 5px">
    </div>
</div>

<script>
    var Main = {
        data() {
            return {
                reverse: false,
                activities: [{
                    step: 'step 1',
                    content: '打开短视频APP，点开某个视频，点击右下角分享按钮，在分享弹框中点击复制链接或通过分享到微信QQ等获取分享链接',
                }, {
                    step: 'step 2',
                    content: '将刚才复制的链接粘贴到下面的输入框，例如：抖音：https://v.douyin.com/JJTDEKL/ 快手：https://v.kuaishou.com/8CU76w',
                }, {
                    step: 'step 3',
                    content: '点击解析按钮，即可获得无水印短视频',
                }]
            };
        },
        methods: {
            invalidAlert(message) {
                this.$message({
                    showClose: true,
                    message: message,
                    type: 'warning',
                    offset:50
                });
            },
            failAlert(message) {
                this.$message({
                    showClose: true,
                    message: message,
                    type: 'error',
                    offset:50
                });
            },
            successAlert(message) {
                this.$message({
                    showClose: true,
                    message: message,
                    type: 'success',
                    offset:50
                });
            },
        }
    };
    var Ctor = Vue.extend(Main)
    var app = new Ctor().$mount('#app')
</script>
<?php
$csrf = Yii::$app->request->csrfParam;
$csrfToken = Yii::$app->request->csrfToken;

$script = <<<JS
    $(document).ready(function(){
        $('#parse-btn').click(function () {
            var url = $('#url').val();
            if (url == ''){
                app.invalidAlert('请粘贴要解析的视频地址');
                return;
            } 
            $.post('/backend/parse',{"{$csrf}":"{$csrfToken}",'url':url},function(data) {
                if (data.code == 0){
                    $('#download-btn').removeClass('hidden');
                    $('#copy-btn').removeClass('hidden');
                    $('#video-img').removeClass('hidden');
                    $('#title').removeClass('hidden');
                    $('#title').text(data.data.desc);
                    $('#video-img').attr('src',data.data.video_url);
                    $('#download-btn').attr('data-url',data.data.video_url); 
                    $('#copy-text').val(data.data.video_url);
                    app.successAlert('解析成功');

                }else{
                    app.failAlert('解析失败');
                }
            });
        });
        
        
        $('#download-btn').click(function() {
            var url = $(this).data('url');
            $.post('/backend/download',{"{$csrf}":"{$csrfToken}",'url':url},function(data) {
                console.log(data);
                download("/" + data)
            });
            
        });
        
        $("#copy-btn").on('click',function(){
        var e = document.getElementById("copy-text");//对象是content
            e.select(); //选择对象
            document.execCommand("Copy"); //执行浏览器复制命令
            app.successAlert('复制成功');
        });
        
    });

JS;
$this->registerJS($script);
?>