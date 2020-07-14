<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use cszchen\alte\AlteAsset;

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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <![endif]-->
    <?php $this->head() ?>
</head>
<body class="fixed skin-blue">
<?php $this->beginBody();?>
<div class="wrapper">
    <!-- header -->
    <?=$this->render('header')?>
    <?=$this->render('sidebar')?>

    <div class="content-wrapper">
        <section class="content-header">
            <?php
            if ($this->title) {
                echo Html::tag("h1", $this->title);
            }

//            if (!empty($this->params['breadcrumbs'])) {
//                echo \yii\widgets\Breadcrumbs::widget([
//                    'links' => $this->params['breadcrumbs'],
//                ]);
//            }

            ?>
        </section>
        <section class="content">
            <?php echo $content;?>
        </section>

    </div>

    <footer class="main-footer"><b>Copyright</b> humourpicasso © 2020 </footer>
</div>
<?php $this->endBody();?>
</body>
</html>
<?php $this->endPage() ?>
