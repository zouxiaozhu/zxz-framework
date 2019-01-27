<?php
/**
 * Created by PhpStorm.
 * User: zhanglong
 * Date: 2018/12/6
 * Time: 下午5:23
 */

namespace App\Console\Command;

use Framework\Core\Controller;
use Framework\Request;
use Zl\Compose\Mq\AMQP\Client;

class DirectPub extends Controller
{
    public function handle(Request $request)
    {
        return $this->consumer();
    }
    /**
     * @return array
     * @throws \Zl\Compose\Mq\Exp\ConnectExp
     */
    public function publish()
    {
        $ex = 'ex_t121';
        $qu = 'qu_t121';
        $ro = 'ro_t121';
        $qu_type = AMQP_EX_TYPE_DIRECT;
        $arr = [
            'name' => time(),
            'age' => uniqid()
        ];

        $client = new Client(config('amqp.normal'));
        $client->channel()
            ->setExchange($ex, $qu_type)
            ->setQueue($qu, [], 10000)
            ->bind($ro)
            ->publish($arr);

        return $this->responseTrue();
    }

    /**
     * @throws \ErrorException
     * @throws \Zl\Compose\Mq\Exp\ConnectExp
     * @throws \Zl\Compose\Mq\Exp\RabbitMqExp
     */
    public function consumer()
    {
        $ex = 'ex_t121';
        $qu = 'qu_t121';
        $ro = 'ro_t121';
        $qu_type = AMQP_EX_TYPE_DIRECT;

        $client = new Client(config('amqp.normal'));
        $client->channel()
            ->setExchange($ex, $qu_type)
            ->setQueue($qu, [], 10000)
            ->bind($ro)
            ->consumerBlock(function ($msg) {
                zxzLog($msg, 'trest');
                return true;
            }, false, 5, 0);
    }
}