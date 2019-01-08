<?php
// kill -l 查看进程信号量
function shutdown()
{
    sleep(5);
    echo PHP_EOL . 'shutdown' . PHP_EOL;
}

register_shutdown_function('shutdown');

//使用ticks需要PHP 4.3.0以上版本
declare(ticks=1);

//信号处理函数
function sig_handler($signo)
{
    switch ($signo) {
        case SIGTERM:
            // 处理kill
            echo PHP_EOL . 'kill';
            exit;
            break;
        case SIGHUP:
            //处理SIGHUP信号
            break;
        case SIGINT:
            //处理ctrl+c
            echo PHP_EOL . 'ctrl+c';
            exit;
            break;
        default:
            // 处理所有其他信号
    }
}

//安装信号处理器
pcntl_signal(SIGTERM, "sig_handler");
pcntl_signal(SIGHUP, "sig_handler");
pcntl_signal(SIGINT, "sig_handler");

while (true) {
    echo getmypid() . PHP_EOL;
    sleep(1);
}
