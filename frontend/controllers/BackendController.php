<?php
namespace frontend\controllers;

use common\components\ApiResponse;
use frontend\controllers\common\BaseController;
use frontend\models\ParseForm;
use GuzzleHttp\Client;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Response;

class BackendController extends BaseController
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'parse' => ['POST'],
                    'download' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionOrder()
    {
        return $this->render('order');
    }


    public function actionParse()
    {
        $form = new ParseForm();
        $post = Yii::$app->request->post();
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($form->validate($post) && $form->load(['ParseForm'=>$post])){
            $result = $form->parse();
            if (isset($result['video_url']) && !empty($result['video_url'])){
                $data['data'] = $result;
                return ApiResponse::success($data);
            }else{
                return ApiResponse::fail();
            }

        }else{
            return ApiResponse::fail();
        }

    }


    public function actionDownload()
    {
        $url = \Yii::$app->request->post('url');

        $client = new Client();

        $content = $client->get($url)->getBody()->getContents();

        $code = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $rand = $code[rand(0,25)]
            .strtoupper(dechex(date('m')))
            .date('d').substr(time(),-5)
            .substr(microtime(),2,5)
            .sprintf('%02d',rand(0,99));
        for(
            $a = md5( $rand, true ),
            $s = '0123456789ABCDEFGHIJKLMNOPQRSTUV',
            $d = '',
            $f = 0;
            $f < 8;
            $g = ord( $a[ $f ] ),
            $d .= $s[ ( $g ^ ord( $a[ $f + 8 ] ) ) - $g & 0x1F ],
            $f++
        );

        $filename = "video/".$d.".mp4";

        $video = fopen($filename, "w") or die("Unable to open file!");

        fwrite($video, $content);
        fclose($video);
        return $filename;
    }
    
    
}
