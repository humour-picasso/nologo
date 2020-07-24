<?php

/* @var $this \yii\web\View */
/* @var $content string */

use frontend\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<?=$this->render('head')?>
<body>
<?=$this->render('login_nav')?>
<?php $this->beginBody() ?>
<?= $content ?>

<?=$this->render('footer')?>
<?php $this->endBody() ?>


</body>
</html>
<?php $this->endPage() ?>


