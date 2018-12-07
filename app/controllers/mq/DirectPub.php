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
    public function index()
    {
        $client = new Client();
        $client->channel(config('amqp.default'))->publish('q_frame', 'r_frame', "----------------");
        ds($client->getConfigKey());
        return $this->responseTrue();
    }
}