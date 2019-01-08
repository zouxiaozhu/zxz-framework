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

class Fanout extends Controller
{

    /**
     * @return array
     * @throws \Zl\Compose\Mq\Exp\ConnectExp
     */
    public function publish()
    {
        $ex = 'ex_fa21';
        $qu = 'qu_fa21';
        $ro = 'ro_fa21';
        $arr = [
            'name' => 'fa' . time(),
            'age' => 'fa' . uniqid()
        ];
        $qu_type = AMQP_EX_TYPE_FANOUT;
        $client = new Client(config('amqp.normal'));
        $client->channel()
            ->setExchange($ex, $qu_type)
            ->setQueue($qu, [], 10000)
            ->bind($ro)
            ->publish($arr);

        return $this->responseTrue();
    }


    /**
     * @throws \Zl\Compose\Mq\Exp\ConnectExp
     * @throws \Zl\Compose\Mq\Exp\RabbitMqExp
     */
    public function consumer()
    {
        $ex = 'ex_fa21';
        $qu = 'qu_fa21';
        $ro = 'ro_fa21';
        $qu_type = AMQP_EX_TYPE_FANOUT;

        $client = new Client(config('amqp.normal'));
        $client->channel()
            ->setExchange($ex, $qu_type)
            ->setQueue($qu, [], 10000)
            ->bind($ro)
            ->consumerBlock(function ($body) {
                if ($body['name'] == 'fa1545030472') {
                    return false;
                } else {
                    return true;
                }
            }, false, 5, 5);
    }
}