<?php
/**
 * Created by PhpStorm.
 * User: zhanglong
 * Date: 2018/12/7
 * Time: 上午11:05
 */

return [
    'amqp' => [
        'default' => [
            'host' => 'localhost',
            'port' => '5672',
            'username' => 'frame',
            'password' => 'frame',
            'vhost' => 'frame',
        ],
        'normal' => [
            'host' => 'localhost',
            'port' => 5672,
//            'user' => 'frame',
            'login' => 'frame',
            'password' => 'frame',
            'vhost' => 'frame', //  /dev, /pre
            'read_timeout' => 0,
            'write_timeout' => 0,
            'connect_timeout' => 0,
            'heartbeat' => 0,
        ]
    ]
];