<?php
/**
 * Created by PhpStorm.
 * User: zhanglong
 * Date: 2018/11/5
 * Time: 19:51
 */

namespace Framework\Handlers;


use Framework\App;
use Framework\Exceptions\ZxzApiException;
use Framework\Exceptions\ZxzHttpException;
use Framework\Interfaces\HandleInterface;
use GuzzleHttp\Client;

class ReportHandler implements HandleInterface
{
    protected $items;

    public function register(App $app)
    {
        App::$container->setSingle('report', $this);
    }

    public function __construct()
    {

    }

    public function report($type = 'text', $content = "我就是我, 是不一样的烟火")
    {
        $func = sprintf('%sReport', $type);
        if (!method_exists($this, $func)) {
            throw new ZxzApiException(__CLASS__ ."不存在方法" . $func, 500);
        }

        $report_content = (new Client())->request('post',
            'https://oapi.dingtalk.com/robot/send?access_token=a6b155f1881059b00737eabeb1f5cda4238ba16a19c11d25125076c65a8f843a',
            call_user_func([$this, $func], $type, $content)
        )->getBody()->getContents();


        zxzLog($report_content, 'report');
        zxzLog($content, 'report');
    }


    public function textReport($type = 'text', $content = "我就是我, 是不一样的烟火")
    {
        return [
            'headers' => ['Content-Type' => 'application/json;charset=utf-8'],
            'body' =>
                json_encode([
                    "msgtype" => $type,
                    "text" => [
                        "content" => $content
                    ],
                    "at" => [
                        "isAtAll" => false,
                        'atMobiles'=> [17551066277]
                    ]
                ])

        ];
    }

}