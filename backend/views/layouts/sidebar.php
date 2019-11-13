<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">

        <?php
        $controllerName = Yii::$app->controller->id;
        $actionName = Yii::$app->controller->action->id;
        $moduleName = Yii::$app->controller->module->id;

        $menu = [
            [
                'url' => '/home',
                'label' => '首页',
                'icon' => 'fa fa-dashboard',
            ],
            [
                'url' => '/money',
                'label' => '财务管理',
                'icon' => 'fa fa-money',
                'options' => ['class' => $controllerName == 'money' ? 'active' : ''],
            ],
            [
                'url' => '#',
                'label' => '项目管理',
                'icon' => 'fa fa-cubes',
                'items' => [
                    [
                        'url' => '/project/default',
                        'label' => '项目列表',
                        'options' => ['class' => $controllerName == 'default' && $moduleName == 'project' ? 'active' : ''],
                    ],
                    [
                        'url' => '/project/create',
                        'label' => '新增项目',
                        'options' => ['class' => $controllerName == 'create' && $moduleName == 'project' ? 'active' : ''],
                    ],
                ],
                'options' => ['class' => $moduleName == 'project' ? 'active' : ''],
            ],
        ];
//            if(isset($this->context->menu))
//                $menu = array_merge([['label' => \Yii::$app->name, 'options' => ['class' => 'nav-header']]], $this->context->menu);

        ?>
        <?= lkk\inspinia\widgets\Menu::widget(
            [
                'options' => ['class' => 'nav metismenu', 'id'=>'side-menu'],
                'submenuTemplate' => "\n<ul class='nav nav-second-level collapse' {show}>\n{items}\n</ul>\n",
                'items' => $menu,
            ]
        ) ?>
    </div>
</nav>