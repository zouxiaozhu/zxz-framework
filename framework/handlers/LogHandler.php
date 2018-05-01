<?php
/**
 * Created by PhpStorm.
 * User: zouxiaozhu
 * Date: 18-3-17
 * Time: 下午4:57
 */
namespace Framework\Handlers;
use Framework\App;
use Framework\Interfaces\HandleInterface;

class LogHandler implements HandleInterface{

    public function register(App $app)
    {
        App::$container->setSingle('log', $this);
    }

    public function __construct()
    {
        $this->logDir = env('log_path') ?
            RESOURCE_PATH .DIRECTORY_SEPARATOR.'/log/'.env('log_path') : RESOURCE_PATH.'/log';
        if (!file_exists($this->logDir)){
            @mkdir($this->logDir, 0777, true);
        }


        $this->logFileName= 'log_'.date('Y-m-d');
    }

    public function write($data, $file_name= '')
    {
        zxzLog($data, $file_name ? : $this->logFileName);
    }
}