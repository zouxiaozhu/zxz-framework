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
    public function publish()
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

    /**
     * @throws \Zl\Compose\Mq\Exp\ConnectExp
     */
    public function consumer()
    {
        $ex = 'ex_t121';
        $qu = 'qu_t121';
        $ro = 'ro_t121';

        $client = new Client(config('amqp.normal'));
        $client->channel()
            ->setExchange($ex)
            ->setQueue($qu, 2, [], 10000)
            ->bind($ro)
            ->consumerBlock(function ($msg) {
                zxzLog($msg);
                return false;
            }, false, 5);
    }

    public function insert($name)
    {
        $redis = new \Predis\Client(config('amqp.normal'));
        $redis->lpush("res", $name);
    }

    public function select()
    {
        $redis = new \Predis\Client(config('amqp.normal'));
        while ($value = $redis->lpop("res")) {
            // todo
            // 处理注册逻辑
        }

    }
}