<?php

namespace cszchen\alte\widgets;

use yii\helpers\ArrayHelper;
use yii\bootstrap\Html;
use yii\helpers\Url;

class Sidebar extends \yii\widgets\Menu
{
    public $search = [];
    
    public $header = "MAIN NAVIGATION";
    
    public $defaultIcon = "fa fa-circle-o text-aqua";
    
    public $submenuTemplate = "\n<ul class=\"treeview-menu\">\n{items}\n</ul>\n";
    
    public $itemOptions = ['class' => 'treeview'];
    
    public $options = ["class" => "sidebar-menu"];
    
    public $linkTemplate = '<a href="{url}">{icon}{label}{small}</a>';
    
    public function run()
    {
        echo Html::beginTag("aside", ["class"=>"main-sidebar"]);
        echo Html::beginTag("section", ["class"=>"sidebar"]);
        echo $this->renderSearch();
        parent::run();
        echo Html::endTag("section");
        echo Html::endTag("aside");
    }
    
    
    
    protected function renderSearch()
    {
        if ($this->search === false) {
            return null;
        }
        $html = '';
        $defaultFormOptions = ['class' => 'sidebar-form'];
        $defaultInputOptions = ['name' => 'search', 'value' => '', 'placeholder' => 'Search...', 'class' => 'form-control'];
        $formOptions = ArrayHelper::merge(ArrayHelper::getValue($this->search, 'form', []), $defaultFormOptions);
        $inputOptions = ArrayHelper::merge(ArrayHelper::getValue($this->search, 'input', []), $defaultInputOptions);
        $action = ArrayHelper::remove($formOptions, 'action', '');
        $method = ArrayHelper::remove($formOptions, 'method', 'get');
        $html .= Html::beginForm($action, $method, $formOptions);
        $html .= Html::beginTag("div", ['class' => 'input-group']);
        $html .= Html::tag("input", "", $inputOptions);
        $html .= Html::tag(
            "span", 
            Html::button(Html::tag("i", "", ['class'=>'fa fa-search']), ['type'=>'submit', 'name'=>'search', 'class'=>'btn btn-flat']), 
            ['class' => 'input-group-btn']
        );
        $html .= Html::endTag("div");
        $html .= Html::endTag("form");
        return $html;
    }
    
    protected function renderItems($items)
    {
        static $setHeader = false;
        
        $header = !$setHeader && $this->header ? Html::tag("li", $this->header, ["class" => "header"]) : '';
        if (!$setHeader)
            $setHeader = true;
        return $header . parent::renderItems($items);
    }
    
    protected function renderItem($item)
    {
        $template = ArrayHelper::getValue($item, 'template', $this->linkTemplate);
        
        if (isset($item['small'])) {
            $small = $item['small'];
            $small = is_array($small) ? $small : ['label' => $small];
            $class = isset($small['class']) ? $small['class'] : "label pull-right bg-yellow";
            $smallLabel = Html::tag("small", ArrayHelper::remove($small, 'label'), ["class" => $class]);
        } else if (!empty($item['items'])) {
            $smallLabel = Html::tag("i", "", ["class" => "fa fa-angle-left pull-right"]);
        } else {
            $smallLabel = null;
        }
        
        if (!isset($item['url'])) {
            $item['url'] = '#';
        }
        if (!isset($item['icon'])) {
            $item['icon'] = $this->defaultIcon;
        }
        return strtr($template, [
            '{url}' => Html::encode(Url::to($item['url'])),
            '{icon}' => !empty($item["icon"]) ? Html::tag("i", "", ['class' => $item["icon"]]) : null,
            '{label}' => Html::tag("span", $item['label']),
            '{small}' => $smallLabel,
        ]);
    }
    
}
