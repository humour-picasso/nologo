<?php
use cszchen\alte\widgets\Box;

$this->title = "Nologo";
Box::begin([
'type' => 'primary',
'title' => 'Welcome',
'refreshUrl' => '/userinfo',
'tools' => ['refresh', 'collapse', 'remove'],
'collapsed' => false
]);
echo "Welcome";
Box::end();