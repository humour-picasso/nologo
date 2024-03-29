<?php

namespace frontend\models;

use common\models\Order;
use Smalls\VideoTools\Exception\ErrorVideoException;
use Smalls\VideoTools\VideoManager;
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

        try {
            $config = [
                'Bili' => ['b23.tv', 'www.bilibili.com'],
                'DouYin' => ['douyin.com', 'iesdouyin.com'],
                'HuoShan' => ['huoshan.com'],
                'KuaiShou' => ['ziyang.m.kspkg.com', 'kuaishou.com', 'gifshow.com', 'chenzhongtech.com','kuaishouapp.com'],
                'LiVideo' => ['www.pearvideo.com'],
                'MeiPai' => ['www.meipai.com'],
                'MoMo' => ['immomo.com'],
                'PiPiGaoXiao' => ['ippzone.com'],
                'PiPiXia' => ['pipix.com'],
                'QuanMingGaoXiao' => ['longxia.music.xiaomi.com'],
                'ShuaBao' => ['shua8cn.com/video_share'],
                'TouTiao' => ['toutiaoimg.com', 'toutiaoimg.cn'],
                'WeiShi' => ['weishi.qq.com'],
                'XiaoKaXiu' => ['mobile.xiaokaxiu.com'],
                'XiGua' => ['xigua.com'],
                'ZuiYou' => ['izuiyou.com'],
                'WeiBo' => ['weibo.com','weibo.cn'],
                'MiaoPai' => ['miaopai.com'],
            ];
            $method = 'DouYin';
            foreach ($config as $key => $domains){
                foreach ($domains as $domain){
                    if (strpos($this->url,$domain)){
                        $method = $key;
                    }
                }
            }
            $response = VideoManager::$method()->start($this->url);
            //解析成功生成订单
            if (isset($response['video_url']) && !empty($response['video_url'])){
                $trans = Yii::$app->db->beginTransaction();
                try {
                    $user = Yii::$app->user->getIdentity();
                    $user_id = Yii::$app->user->getId();
                    $order = new Order();
                    $order->order_no = date('Ymd').time().$user_id;
                    $order->parse_url = $this->url;
                    $order->user_id = $user_id;
                    $order->status = 1;
                    $order->img_url = $response['img_url'];
                    $order->video_url = $response['video_url'];
                    $order->created_at = time();
                    $order->desc = $response['desc'];
                    $order->md5 = $response['md5'];
                    $order->user_name = $response['user_name'];
                    $order->user_head_img = $response['user_head_img'];
                    $order->save(false);
                    //todo:如果是次数会员减次数，包月包年会员不减 1次数 2包月 3包年
                    if ($user->user_type == 1){
                        $user->limit -= 1;
                        $user->save(false);
                    }
                    $trans->commit();
                } catch (\Exception $e) {
                    $trans->rollBack();
                    throw $e;
                }


            }


            return $response;
        } catch (ErrorVideoException $e) {
            \Yii::error($e->getTraceAsString());
        }
    }

}
