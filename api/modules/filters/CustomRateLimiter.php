<?php
namespace frontend\controllers\filters;

use yii\filters\RateLimiter;
class CustomRateLimiter  extends RateLimiter
{

    public $rateLimit;
    public $timePeriod;
    # 速度控制  6秒内访问3次，注意，数组的第一个不要设置1，设置1会出问题，一定要
    # 大于2，譬如下面  6秒内只能访问三次
    # 文档标注：返回允许的请求的最大数目及时间，例如，[100, 600] 表示在600秒内最多100次的API调用。
    public function getRateLimit($request, $action)
    {
        return [$this->rateLimit, $this->timePeriod]; // $rateLimit requests per second
    }

    public function loadAllowance($request, $action)
    {
        return [$this->allowance, $this->allowance_updated_at];
    }

    public function saveAllowance($request, $action, $allowance, $timestamp)
    {
        $this->allowance = $allowance;
        $this->allowance_updated_at = $timestamp;
        $this->save();
    }
}

?>