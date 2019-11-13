<?php
/**
 * Created by PhpStorm.
 * User: guest1
 * Date: 2018/4/8
 * Time: 下午5:25
 */

namespace common\components;


class ApiResponse
{

    public static function success($data = null)
    {
        if(isset($data['data'])) {
            $data = [
                'code' => isset($data['code']) ? intval($data['code']) : ResponseCode::SUCCESS,
                'msg' => isset($data['msg']) ? (string)$data['msg'] : "success",
                'data' => !empty($data['data']) ? $data['data'] : (is_array($data['data']) ? [] : null),

            ];
        }else{
            $data = [
                'code' => isset($data['code']) ? intval($data['code']) : ResponseCode::SUCCESS,
                'msg' => isset($data['msg']) ? (string)$data['msg'] : "success",
                'data' => null,

            ];
        }
        return $data;
    }

    public static function fail($data=null)
    {
        $data = [
            'code' => isset($data['code']) ? intval($data['code']) : ResponseCode::GENERAL_ERROR,
            'msg' => isset($data['msg']) ? (string)$data['msg'] : "failed",
            'data' => isset($data['data']) ? $data['data'] : null,
        ];
        return $data;
    }

    public static function inValidParams($data)
    {
        $data = [
            'code' => isset($data['code']) ? intval($data['code']) : ResponseCode::INVALID_PARAMS,
            'msg' => isset($data['msg']) ? (string)$data['msg'] : "invalid params",
            'data' => !empty($data['data']) ? $data['data'] : null,

        ];
        return $data;
    }

}