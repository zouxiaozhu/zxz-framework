<?php
/********************************************
 *                ZXZ PHP                   *
 *                                          *
 * A clone PHP framework for studying       *
 *                                          *
 *                 ZXZ                      *
 *      <https://github.com/ZXZ>            *
 *                                          *
 ********************************************/

namespace Framework\Exceptions;
use Exception;
use Framework\App;
class ZxzHttpException extends Exception{


    /**
     * 响应异常code
     *
     * @var array
     */
    private $httpCode = [
        // 缺少参数或者必传参数为空
        400 => 'Bad Request',
        // 没有访问权限
        403 => 'Forbidden',
        // 访问的资源不存在
        404 => 'Not Found',
        // 代码错误
        500 => 'Internet Server Error',
        // Remote Service error
        503 => 'Service Unavailable'
    ];

    /**
     * 构造函数
     *
     * @param int $code excption code
     * @param string $extra 错误信息补充
     */
    public function __construct($code = 200, $extra = '')
    {
        $this->code = $code;
        if (empty($extra)) {
            $this->message = $this->httpCode[$code];
            return;
        }
        $this->message = $extra . ' ' . $this->httpCode[$code];
    }

    /**
     * rest 风格http响应
     * @return json
     */
    public function response()
    {
        $data = [
            '__coreError' => [
                'code'    => $this->getCode(),
                'message' => $this->getMessage(),
                'infomations'  => [
                    'file'  => $this->getFile(),
                    'line'  => $this->getLine(),
                    'trace' => $this->getTrace(),
                ]
            ]
        ];

        // log
        App::$container->getSingle('log')->write($data);

        // response
        header('Content-Type:Application/json; Charset=utf-8');
        die(json_encode($data, JSON_UNESCAPED_UNICODE));
    }

    public static function error($e)
    {
        $data = [
            '__coreError' => [
                'code' => 500,
                'message' => $e,
                'infomations' => [
                    'file' => $e['file'],
                    'line' => $e['line'],
                ]
            ]
        ];

        // log
        App::$container->getSingle('log')->write($data);

        header('Content-Type:Application/json; Charset=utf-8');
        die(json_encode($data));
    }
}
