<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
/**
 * Login form
 */
class ParseForm extends Model
{
    public $url;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['url', 'required'],
            ['url', 'url'],
        ];
    }

    /**
     * 视频解析
     */
    public function parse()
    {

    }
}
