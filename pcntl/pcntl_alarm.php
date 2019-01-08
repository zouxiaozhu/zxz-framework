#!/usr/bin/php
<?php

/**
 * Created by PhpStorm.
 * User: zhanglong
 * Date: 2019/1/6
 * Time: 11:07 PM
 */

pcntl_signal(SIGALRM, function () {
    echo 'Received an alarm signal !' . PHP_EOL;
}, false);

pcntl_alarm(5);
while (true) {
    pcntl_signal_dispatch();
    sleep(1);
}

