<?php

namespace cszchen\alte\widgets;

use yii\bootstrap\Html;

class NavBar extends \yii\bootstrap\NavBar
{
    /**
     * @var array list of items in the nav widget. Each array element represents a single
     * menu item which can be either a string or an array with the following structure:
     *
     * - label: string, required, the nav item label.
     * - url: optional, the item's URL. Defaults to "#".
     * - visible: boolean, optional, whether this menu item is visible. Defaults to true.
     * - linkOptions: array, optional, the HTML attributes of the item's link.
     * - options: array, optional, the HTML attributes of the item container (LI).
     * - active: boolean, optional, whether the item should be on active state or not.
     * - dropDownOptions: array, optional, the HTML options that will passed to the [[Dropdown]] widget.
     * - items: array|string, optional, the configuration array for creating a [[Dropdown]] widget,
     *   or a string representing the dropdown menu. Note that Bootstrap does not support sub-dropdown menus.
     *
     * If a menu item is a string, it will be rendered directly without HTML encoding.
     */
    public $items = [];
    /**
     * 
     * @var array 
     * @see yii\bootstrap\Widget::options;
     */
    public $navOptions = [];
    
    public $brandLabelSm = false;
    
    public function init()
    {
        echo Html::beginTag("header", ["class"=>"main-header"]);
        echo $this->renderBrand();
        if (empty($this->options['class'])) {
            Html::addCssClass($this->options, ['navbar', 'navbar-static-top']);
        }
        if (empty($this->options['role'])) {
            $this->options['role'] = 'navigation';
        }
        echo Html::beginTag("nav", $this->options);
        echo $this->renderToggleButton();
        echo Html::beginTag("div", ["class"=>"navbar-custom-menu"]);
        if ($this->items) {
            echo $this->renderItems();
        }
    }
    
    public function run()
    {
        echo Html::endTag("div");
        echo Html::endTag("nav");
        echo Html::endTag("header");
    }
    
    protected function renderBrand()
    {
        if ($this->brandLabel === false) {
            return null;
        }
        $label = '';
        $label .= Html::tag("span",$this->brandLabel, ["class" => "logo-lg"]);
        $label .= Html::tag("span",$this->brandLabelSm, ["class" => "logo-sm"]);
        return Html::a($label, $this->brandUrl, ["class" => "logo"]);
    }
    
    protected function renderToggleButton()
    {
        return Html::tag(
            "a",
            Html::tag("span", "Toggle navigation", ["class"=>"sr-only"]),
            [
                "href" => "#",
                "class" => "sidebar-toggle",
                "data-toggle" => "offcanvas",
                "role" => "button"
            ]
        );
    }
    
    protected function renderItems()
    {
        Html::addCssClass($this->navOptions, "navbar-nav");
        return Nav::widget([
            'items' => $this->items,
            'options' => $this->navOptions,
            'activateParents' => true,
        ]);
    }
}
