<?php
use \cszchen\alte\widgets\NavBar;

NavBar::begin([
    'brandLabel' => 'Nologo',
    'items' => [
        ['label'=>'Dashboard', 'url' => '#', 'icon' => 'fa fa-dashboard'],
        ['label'=>'注销', 'url' => '/site/logout', 'icon' => 'fa fa-logout'],
    ],
]);
NavBar::end();