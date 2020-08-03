<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="container-box">
    <div class="order-table" id="app">
        <h5><i class="el-icon-s-order"></i>订单记录</h5>
        <div style="background-color: #ffffff; padding: 20px 10px 10px 10px;border-radius: 5px;margin-bottom: 8px">
            <?php $searchForm = ActiveForm::begin(['action' => '/backend/order','method' => 'get']); ?>

            <?php //---------- datapick --------------- ?>
            <div class="row">
                <div class="col-md-1" style="padding-right: 0px">
                    <span class="input-group-addon" style="border-left:1px solid #cccccc;font-size: 14px;padding-top: 9px;padding-bottom: 9px;border-radius: 4px 0px 0px 4px;">解析地址</span>
                </div>
                <div class="col-md-6" style="padding-left: 0px">
                    <?=$searchForm->field($searchModel,'url')->textInput(['style'=>'border-left:0px;border-radius:0px 4px 4px 0px;'])->label(false)?>
                </div>
                <div class="col-md-4" style="padding-left: 0px;" >
                    <?= Html::submitButton('搜索', ['style' => 'width:40%;','class'=> 'btn btn-w-m btn-primary']); ?>
                    <?= Html::a('重置','/backend/order',['style' => 'width:40%;', 'class'=> 'btn btn-w-m btn-danger'])?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="clean-padding row"  style="background-color: white; padding: 10px;border-radius: 5px;margin-bottom: 8px">
            <?php \yii\widgets\Pjax::begin(['id' => 'auditor_info']); ?>
            <?php
            echo \yii\grid\GridView::widget([
                'dataProvider' => $dataProvider,
                'layout'=>"{items}\n{pager}",
                'columns' => [
                    [
                        'label' => '订单号',
                        'value' =>function($model){
                            return '<span style="color: #606266;font-weight: bolder">'.$model->order_no.'</span>';
                        },
                        'contentOptions' => ['style'=>'min-width:100px;max-width:200px;'],
                        'format' => 'raw'
                    ],
                    [
                        'label' => '解析地址',
                        'value' =>function($model){
                            return "<a href='$model->parse_url' target='_blank'>$model->parse_url</a>";
                        },
                        'contentOptions' => ['style'=>'min-width:100px;max-width:200px; white-space: nowrap;overflow: hidden;text-overflow:ellipsis;'],
                        'format' => 'raw'
                    ],
                    [
                        'label' => '创建时间',
                        'value' =>function($model){
                            return '<span style="color: #606266;font-weight: bolder">'.date('Y-m-d H:i:s',$model->created_at).'</span>';
                        },
                        'contentOptions' => ['style'=>'min-width:100px;max-width:200px;'],
                        'format' => 'raw'
                    ],
                    [
                        'label' => '无水印视频',
                        'value' =>function($model){
                            return "<a href='$model->video_url' target='_blank'>$model->video_url</a>";
                        },
                        'contentOptions' => ['style'=>'min-width:100px;max-width:200px; white-space: nowrap;overflow: hidden;text-overflow:ellipsis;'],
                        'format' => 'raw'
                    ],
                    [
                        'label' => '视频封面',
                        'value' =>function($model){
                            return "<a href='$model->img_url'>$model->img_url</a>";
                        },
                        'contentOptions' => ['style'=>'min-width:100px;max-width:200px; white-space: nowrap;overflow: hidden;text-overflow:ellipsis;'],
                        'format' => 'raw'
                    ],
                    [
                        'label' => '作者',
                        'value' =>function($model){
                            return '<span style="color: #606266;font-weight: bolder">'.$model->user_name.'</span>';
                        },
                        'contentOptions' => ['style'=>'min-width:100px;max-width:200px;'],
                        'format' => 'raw'
                    ],
                    [
                        'label' => '状态',
                        'value' => function($model){
                            if ($model->status == 1){
                                return '<span style="color: #67C23A;font-weight: bolder">成功</span>';
                            }else{
                                return '失败';
                            }
                        },
                        'format' => 'raw'
                    ]
                ],
                'options' => [
                    'style' =>'overflow:auto;margin:10px;',
                ],
                'tableOptions' => [
                    'class' => 'table table-hover table-striped table-bordered table-responsive',
                ],
                'headerRowOptions'=>['style'=>'color:#606266;'],
                'rowOptions'=>['style'=>'background-color:#fff;'],
                'footerRowOptions'=>['style'=>'color:#ddd;']
            ])?>
            <?php \yii\widgets\Pjax::end(); ?>
        </div>
    </div>
</div>
<script>
    new Vue().$mount('#app')
</script>
