<?php
/**
 * 菜单列表
 */
use cszchen\alte\widgets\Sidebar;

$menu = [];
$callback = function ($item){
    $return = [
        'label' => $item['name'],
        'url' => [$item['route']],
        'icon'=>'fa '.json_decode($item['data'])->icon
    ];
    $item['children'] && $return['items'] = $item['children'];
    return $return;
};

$menu = \mdm\admin\components\MenuHelper::getAssignedMenu(Yii::$app->user->id,null,$callback,true);


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
