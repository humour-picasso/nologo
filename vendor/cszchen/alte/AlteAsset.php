<?php

namespace cszchen\alte;

use yii\web\AssetBundle;

class AlteAsset extends AssetBundle
{
    public $js = [
        '//cdn.bootcss.com/jQuery-slimScroll/1.3.6/jquery.slimscroll.min.js',
        'js/app.js'
    ];
    
    public $css = [
        '//cdn.bootcss.com/font-awesome/4.4.0/css/font-awesome.min.css',
        'css/AdminLTE.min.css',
        'css/skins/_all-skins.min.css',
    ];
    
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
    
    public function init()
    {
        $this->sourcePath = __DIR__ . '/assets';
    }
}
