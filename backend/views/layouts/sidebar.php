<?php
/**
 * 菜单列表
 */
use cszchen\alte\widgets\Sidebar;

$menu = [];
foreach (\mdm\admin\components\MenuHelper::getAssignedMenu(Yii::$app->user->id) as $key => $value){
    $menu[$key]['label'] = $value['label'];
    $menu[$key]['url'] = $value['url'][0];
    $menu[$key]['icon'] = 'fa fa-dashboard';

}
//echo "<pre>";
//print_r($menu);
//exit();
echo Sidebar::widget([
        'search' => false,
        'header' => '',
        'items' => $menu
//        [
//            ['label'=>'Dashboard', 'url' => '/', 'icon' => 'fa fa-dashboard'],
//            [
//                'label' => 'menu#2',
//                'items'=>[
//                    ['label'=>'child#2-1', 'url' => '#child2-1', 'items' => [
//                        ['label' => 'child\'s child#1'],
//                        ['label' => 'child\'s child#2'],
//                    ]],
//                ]
//            ]

//        ],
    ]);
