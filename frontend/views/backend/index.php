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
                <input type="email" class="form-control"  id="url" placeholder="请粘贴短视频地址">
            </div>
            <button type="button" class="btn btn-danger">解析</button>
        </div>

        <?php if ($dataProvider->count){ ?>
        <div class="order-table">
            <h5>订单记录</h5>
            <?php
            echo \yii\grid\GridView::widget([
                'dataProvider' => $dataProvider,
                'layout'=>"{items}\n{pager}",
                'pager'=>[
//                    'options'=>['class'=>'hidden'],//关闭自带分页
                    'firstPageLabel'=>"首页",
                    'prevPageLabel'=>'上一页',
                    'nextPageLabel'=>'下一页',
                    'lastPageLabel'=>'未页',
                ],
                'columns' => [
                    [
                        'label' => '订单号',
                        'value' =>'order_no'
                    ],
                    [
                        'label' => '解析地址',
                        'value' =>'parse_url'
                    ],
                    [
                        'label' => '创建时间',
                        'value' =>function($model){
                            return date('Y-m-d H:i:s',$model->created_at);
                        }
                    ],
                    ['label' => '无水印视频','value' =>'video_url' ],
                    ['label' => '视频封面','value' =>'img_url' ],
                    ['label' => '描述','value' =>'desc' ],
                    [
                        'label' => '状态',
                        'value' => function($model){
                            if ($model->status == 1){
                                return '成功';
                            }else{
                                return '失败';
                            }
                        },
                    ]
                ],
                'options' => [
                    'style' =>     'overflow:auto;margin-bottom:50px',
                    'id'    =>     'grid',
                ],
                'tableOptions' => [
                    'class' => 'table table-hover table-striped table-bordered table-responsive',
                    'style' => 'min-width:100em;'
                ],
                'headerRowOptions'=>['style'=>'color:#0e9ce5;'],
                'rowOptions'=>['style'=>'background-color:#fff;'],
                'footerRowOptions'=>['style'=>'color:#ddd;']
            ])?>
        </div>
        <?php }else{ ?>
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
        <?php } ?>
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
        }
    };
    var Ctor = Vue.extend(Main)
    new Ctor().$mount('#app')
</script>