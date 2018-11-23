<?php
/**
 * Created by PhpStorm.
 * User: zhanglong
 * Date: 2018/11/19
 * Time: 下午5:13
 */

namespace Framework\Exceptions;
class ZxzApiException extends \Exception
{
    public function response()
    {
        $data = [
            'code' => $this->getCode(),
            'status' => false,
            'msg' => $this->getMessage(),
            'result' => [
                'error_line' => $this->getLine(),
                'trace' => $this->getTrace()
            ]
        ];

        echo json_encode($data);die;
    }


}