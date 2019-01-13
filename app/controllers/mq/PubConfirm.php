<?php
/**
 * Created by PhpStorm.
 * User: zhanglong
 * Date: 2018/12/6
 * Time: 下午5:23
 */

namespace App\controllers\mq;

use Framework\Core\Controller;
use Framework\Request;
use Zl\Compose\Mq\AMQP\Client;

class PubConfirm extends Controller
{

    /**
     * @return array
     * @throws \Zl\Compose\Mq\Exp\ConnectExp
     */
    public function handle(Request $request)
    {
        $ex = 'ci1_confirm';
        $qu = 'qu1_confirm';
        $ro = 'ro1_confirm';
        $qu_type = AMQP_EX_TYPE_DIRECT;
        $arr = [
            'name' => time(),
            'age' => uniqid()
        ];

        $client = new Client(config('amqp.normal'));

        $client->channel()
            ->setExchange($ex, $qu_type)
            ->setQueue($qu, [], 10)
            ->bind($ro)
            ->publishWithConfirm($arr);

        return $this->responseTrue();
    }

    /**
     * @return array
     * @throws \Zl\Compose\Mq\Exp\ConnectExp
     */
    public function count()
    {

        $qu = 'qu1_confirm';
        $client = new Client(config('amqp.normal'));

        $client->channel()
            ->setQueue($qu, [], 10)
            ->getQueueCount();

        return $this->responseTrue();
    }

}