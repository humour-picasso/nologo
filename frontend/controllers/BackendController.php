<?php
namespace frontend\controllers;

use common\models\Order;
use common\models\Tmp;
use frontend\controllers\common\BaseController;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;

class BackendController extends BaseController
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'parse' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Order::find()->where(['user_id'=>Yii::$app->user->getId()])->orderBy('id DESC'),
            'pagination' => [
                'pageSize' => 5
            ]
        ]);

        return $this->render('index',['dataProvider'=>$dataProvider]);
    }


    public function actionParse()
    {

    }


    public function actionPay()
    {
        return $this->render('index');
    }
}
