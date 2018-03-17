<?php
/**
 * Created by PhpStorm.
 * User: zouxiaozhu
 * Date: 18-3-17
 * Time: 下午10:37
 */
namespace Framework;
class Response{
    public function __construct()
    {
        // code ...
    }

    public function success($response = '22', $code = 200, $message = 'success')
    {
        header('Content-Type:Application/json; Charset=utf-8');
        die(json_encode([
            'code'    => $code,
            'message' => $message,
            'result'  => $response
        ],JSON_UNESCAPED_UNICODE)
        );
    }

    public function error($response = [], $code = 500, $message = 'error')
    {
        header('Content-Type:Application/json; Charset=utf-8');
        $ret = json_encode([
            'code'    => $code,
            'message' => $message,
            'result'  => $response
        ],JSON_UNESCAPED_UNICODE);

        echo $ret;die;
    }

    public function __get($name = '')
    {
        return $this->$name;
    }

    public function __set($name = '', $value = '')
    {
        $this->$name = $value;
    }
}