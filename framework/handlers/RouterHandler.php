<?php
namespace Framework\Handlers;

use Framework\App;
use Framework\Core\Router;
use Framework\Interfaces\HandleInterface;

class RouterHandler implements HandleInterface {

    public function __construct()
    {

    }

    public function register(App $app){
        // 初始化路由模块入口类
        $router = new Router();
        $router->init($app);
    }
}