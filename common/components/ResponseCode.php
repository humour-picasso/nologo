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
    const BLACKED = 101;//黑名单

    const ALREADY_HAVE_LOAN=102;//用户已经拥有一笔贷款


    const HANDLE_FEE_ERROR=104;//手续费计算错误
    const ADD_ELINKMAN_NOADDRESS_ERROR =103;//上传紧急联系人接口错误：上传紧急联系人但未上传通讯录
    const EXCEPTION_ERROR = 105;
    const BANKCARD_OUT_OF_LIMIT = 106;  // 银行卡上传接口错误： 超出银行卡上传数量
    const DUPLICATION_BANKCARD_NUMBER = 107; // 银行卡上传接口错误：银行卡号重复
    const BANK_VALIDATION_INVALID = 109;//用户银行卡验证失败
    const CUSTOMER_STATUS_INVALID = 108;//用户状态不正确
    const BANK_VALIDATION_TIMES_LIMIT = 110;//用户银行卡验证失败
    const CREDIT_STATUS_ERR = 111 ; //重新提交资质认证接口：资质认证状态不是打回状态
    const REALNAME_STATUS_ERR = 112 ; //|重新提交实名认证接口：实名认证状态不是打回状态
    const DUPLICATION_IDCARDNO = 113; // 提交实名认证接口|重新提交实名认证接口  : 身份证号重复
    const REALNAME_INFO_HAS_EXIST = 114; //提交实名认证接口：实名认证信息已存在
    const LOAN_NOT_FIND = 115;//找不到订单
    const CREDIT_INFO_HAS_EXISTED = 116; // 提交资质认证接口：资质信息已经存在
    const BANK_CARD_NOT_EXIST = 117; // 重新提交银行卡接口：银行卡id不存在
    const WRONG_BANK_CARD_STATUS = 118;// 重新提交银行卡接口：银行卡不是重新提交状态
    const LOGIN_ACROSS_PLATFORM_WITHOUT_AUTHRITION = 119 ; // 登录接口 : 请以第一次登录的设备完成贷款资质认证
    const NOT_ENOUGH_APPID = 120; //获取appid接口 没有足够的appid
    const WRONG_REGISTER_SYSTEM = 121;// ios专用 获取appid接口|解绑appleid接口 ：错误的操作系统
    const NOT_BIND= 122; // 解绑appleid接口 : 未绑定
    const WRONG_APPLE_ID_STATUS = 123 ; //获取appid接口 appleid status 不是 0或4
    const NOT_AT_APPLY_OR_UNBINDED = 124; //customer confirm appleid接口 不符合状态机
    const ACTIVE_LOAN_NOT_FINISH = 125 ; // 解绑appleid接口 有活跃的订单未结束 不能申请解绑
    const BLACK = 126 ; // 用户为黑名单，无法进行此操作
    const ALREADY_ADDED_ELINKMAN = 127; // 提交紧急联系人接口 : 紧急联系人数据已经提交
    const REPAYMENT_NOT_FOUND = 128; // 无法找到核销单
    const VERIFY_SMS_EXIST = 129 ; //身份验证短信已经存在 无须再上传

    const VIMO_REQUEST_ERR =130 ; // 调用vimo支付http请求失败
    const VIMO_CREATE_CHECKOUT_ERR = 131 ; //  调用create checkout 失败
    const CANCEL_FAILED = 132; //在线支付取消失败
    const REPAYMENT_EXPIRED = 133; //repayment 失效了

    const WRONG_BANK_CARD_TYPE = 134;//不支持的银行卡
    const DUPLICATION_REPAYMENT = 135; //repayment



    const DEPRECA_PHONE = 136; //repayment





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