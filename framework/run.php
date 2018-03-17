<?php


/**
 * Created by PhpStorm.
 * User: zouxiaozhu
 * Date: 18-3-11
 * Time: 下午10:38
 */

// 引入框架文件
require_once(__DIR__. DIRECTORY_SEPARATOR . 'App.php');
try{

    $app = new Framework\App(realpath(__DIR__ . '/..'), function () {
        return require(__DIR__ . '/Load.php');
    });


    $app->load(function(){
        return new \Framework\Handlers\EnvHandler();
    });

    $app->load(function() use($app ){
        return new \Framework\Handlers\ConfigHandler($app);
    });

    $app->load(function () {
        // 加载日志处理机制 Loading log handle
        return new \Framework\Handlers\LogHandler();
    });

//    $app->load(function () {
//        // 加载路由机制 Loading route handle
//        return new RouterHandle();
//    });

    /**
     * 启动应用
     *
     * Start framework
     */
    $app->run(function () use ($app) {
        return new Request($app);
    });
//    \Framework\Facades\Config::get();
    //var_export(\Framework\App::$container);die;

    /**
     * 响应结果
     *
     * Reponse
     *
     * 应用生命周期结束
     *
     * End
     */
    $ret = \Framework\Facades\Config::get();

    $app->response(function () {
        return new \Framework\Response();
    });



}catch (\Framework\Exceptions\ZxzHttpException $e){
    $e->response();
}