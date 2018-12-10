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
        $client = new Client(config('amqp.normal'));
        $client->channel()
            ->setExchange('ex_t')
            ->setQueue('qx_t')
            ->bind('ro_t', [
                'durable' => true
            ])
            ->publish([
                'name' => time(),
                'age' => uniqid()
            ]);

        return $this->responseTrue();
    }
}