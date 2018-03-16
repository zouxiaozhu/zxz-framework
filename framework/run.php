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



    /**
     * 启动应用
     *
     * Start framework
     */
    $app->run(function () use ($app) {
        return new Request($app);
    });
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
//    $app->response(function () {
//        return new Response();
//    });

}catch (\Framework\Exceptions\ZxzHttpException $e){
//    $e->reponse();
}