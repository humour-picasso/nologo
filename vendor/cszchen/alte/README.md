# yii2-bootstrap-AdminLTE
The Bootstrap template AdminLTE widgets for yii2 framework. 
It make it easy to build a bootstrap admin panel.


Install
===

`composer require "cszchen/alte": ">=2.0.0"`

How to Use
===
layout sample file: `@vendor/cszchen/alte/views/main-layout.php`
 
example:
---
**controllers/SiteController.php**
```php
class SiteController extends \yii\web\Controller
 {
    public $layout = '@vendor/cszchen/alte/veiws/main-layout.php';
    
    public function actionIndex()
    {
        return $this->render('index');
    }
 }
```
  
**views/site/index.php**
```php
use cszchen\alte\widgets\Box;

$this->title = "Title here!";
Box::begin([
  'type' => 'primary',
  'title' => 'Box title',
  'refreshUrl' => '/userinfo',
  'tools' => ['refresh', 'collapse', 'remove'],
  'collapsed' => false
]);
echo "cszchen/alte";
Box::end();
```

**screen**
![](http://deeppic.b0.upaiyun.com/1605/Vkfl3MLQb.png)

NavBar
---
```php
NavBar::begin([
    'brandLabel' => 'cszchen/alte',
    'brandLabelSm' => 'Alte',
    'items' => [
        [
            'label' => 'Home', 
            'url' => ['/site/index'],
            'icon' => 'fa fa-dashboard test-green',
            'items'=>[
                ['label' => 'child#1', 'icon' => 'fa fa-user'],
                ['label' => 'child#2', 'url' => '#']
            ]
        ],
        ['label' => 'About', 'small' => 15, 'url' => ['/site/about']]
     ] 
]);
NavBar::end();
```

SideBar
---
```php
echo Sidebar::widget([
    //'search' => false,
    'items' => [
        [
            'label' => 'level1', 
            'url' => '#', 
            'small' => 1, 
            'icon' => 'fa fa-dashboard text-green',
            'items' => [
                ['label' => 'level2', 'url' => '#', 'icon' => 'fa fa-user text-red'],
                ['label' => 'level2', 'url' => '#', 'items' => [['label' => 'level3']]]
            ]
        ]
    ],
]);
```

Box
---

```php
Box::begin([
    'type' => 'primary',
    'title' => 'Box title',
    'refreshUrl' => '/userinfo',
    'tools' => ['refresh', 'collapse', 'remove'],
    'collapsed' => false
]);
echo "cszchen/alte";
Box::end();
```
