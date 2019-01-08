<?php
/**
 * Created by PhpStorm.
 * User: zhanglong
 * Date: 2019/1/6
 * Time: 11:55 PM
 */

pcntl_signal(SIGKILL, function($signal){
    echo '信号旗启动啦';
});

pcntl_signal_dispatch();

sleep(111);

