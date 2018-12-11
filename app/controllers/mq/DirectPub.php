<?php
/**
 * Created by PhpStorm.
 * User: zhanglong
 * Date: 2018/12/6
 * Time: 下午5:23
 */

namespace App\controllers\mq;

use Framework\Core\Controller;
use Zl\Compose\Mq\AMQP\Client;

class DirectPub extends Controller
{

    /**
     * @return array
     * @throws \Zl\Compose\Mq\Exp\ConnectExp
     */
    public function index()
    {
        $ex = 'ex_t121';
        $qu = 'qu_t121';
        $ro = 'ro_t121';
        $arr = [
            'name' => time(),
            'age' => uniqid()
        ];

        $client = new Client(config('amqp.normal'));
        $client->channel()
            ->setExchange($ex)
            ->setQueue($qu, 2, [], 10000)
            ->bind($ro)
            ->publish($arr);

        return $this->responseTrue();
    }
}