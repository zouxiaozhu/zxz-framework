<?php
/**
 * Created by PhpStorm.
 * User: zhanglong
 * Date: 2019/2/20
 * Time: 11:38 AM
 */
declare(strict_types=1);

namespace App\controllers\Kafka;

use Framework\Core\Controller;
use Kafka\ProducerConfig;
use Monolog\Handler\StdoutHandler;

class Kafkas extends Controller
{

    public function test()
    {

        $config = ProducerConfig::getInstance();
        $config->setMetadataRefreshIntervalMs(10000);
        $config->setMetadataBrokerList('127.0.0.1:9092');
        $config->setBrokerVersion('1.0.0');
        $config->setRequiredAck(-1);
        $config->setIsAsyn(false);
        $config->setProduceInterval(500);
        $producer = new \Kafka\Producer(
            function () {
                return [
                    [
                        'topic' => 'test',
                        'value' => 'test....message.' . mt_rand(0, 100000),
                        'key' => 'testkey',
                    ],
                ];
            }
        );

        $producer->success(function ($result) {
            var_export(1);
        });
        $producer->error(function ($errorCode) {
            var_export(2);
        });
        $producer->send(true);
    }

    public function consume()
    {
        $config = \Kafka\ConsumerConfig::getInstance();
        $config->setMetadataRefreshIntervalMs(10000);
        $config->setMetadataBrokerList('127.0.0.1:9092');
        $config->setGroupId('test');
        $config->setBrokerVersion('1.0.0');
        $config->setTopics(['test']);
//$config->setOffsetReset('earliest');
        $consumer = new \Kafka\Consumer();
        $consumer->start(function($topic, $part, $message) {
            var_dump($message);
        });
    }
}