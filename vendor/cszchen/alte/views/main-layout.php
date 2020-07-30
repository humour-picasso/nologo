<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use cszchen\alte\AlteAsset;
use cszchen\alte\widgets\NavBar;
use \cszchen\alte\widgets\Sidebar;

AlteAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php $this->head() ?>
</head>
<body class="fixed skin-blue">
<?php $this->beginBody();?>
<div class="wrapper">
    <!-- header -->
    <?php
    NavBar::begin([
        'brandLabel' => 'cszchen/alte',
        'brandLabelSm' => 'alte',
        'items' => [
            ['label'=>'Dashboard', 'url' => '#', 'icon' => 'fa fa-dashboard'],
            [
                'label' => 'menu#2',
                'items'=>[
                    ['label'=>'child#2-1', 'url' => '#child2-1'],
                    ['label'=>'child#2-2', 'url' => '#child2-2']
                ]
            ],
            [
                'label' => 'menu#3',
                'items'=>[
                    ['label'=>'child#3-1', 'url' => '#child3-1'],
                    ['label'=>'child#3-2', 'url' => '#child3-2']
                ]
            ],
        ],

    ]);

    NavBar::end();
    echo Sidebar::widget([
        'items' => [
            ['label'=>'Dashboard', 'url' => '#', 'icon' => 'fa fa-dashboard'],
            [
                'label' => 'menu#2',
                'items'=>[
                    ['label'=>'child#2-1', 'url' => '#child2-1', 'items' => [
                        ['label' => 'child\'s child#1'],
                        ['label' => 'child\'s child#2'],
                    ]],
                ]
            ]
        ],
    ])
    ?>

    <div class="content-wrapper">
        <section class="content-header">
            <?php
            if ($this->title) {
                echo Html::tag("h1", $this->title);
            }
            /*
            if (!empty($this->params['breadcrumbs'])) {
                echo Breadcrumbs::widget([
                    'links' => $this->params['breadcrumbs'],
                ]);
            }
            */
            ?>
        </section>
        <section class="content">
            <?php echo $content;?>
        </section>

    </div>

    <footer class="main-footer">This is footer.</footer>
</div>
<?php $this->endBody();?>
</body>
</html>
<?php $this->endPage() ?>
