<?php
/**
 * Created by PhpStorm.
 * User: guest1
 * Date: 2018/4/10
 * Time: 上午10:37
 */
namespace common\components;
class ResponseCode{

    //成功
    const SUCCESS = 0;

    //业务code 100-
    const EXCEEDS_LIMIT = 101;


    //系统code
    const INVALID_PARAMS = 301; // 参数验证失败
    const DB_ERROR = 302;   //数据库错误
    const GENERAL_ERROR = 303; // 通用错误 默认错误码
    const INVALID_TOKEN = 304; //无效的token

    //通用code
    const GENERAL_EXCEPTION_CODE = 500; //服务端发生异常错误码
    const NOT_FOUND = 404;
    const TOO_FREQUENT = 432; //请求太频繁 锁被争用



    //系统正在维护
    const SYSTEM_IS_CLOSED = 900;
    //系统正在维护

    //url找不到

    //未知用户
    const UNDEFINED_CUSTOMER = 140;

    //没有可用
    const NO_TIPS = 150;


}