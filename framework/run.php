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

    $app->load(function ({
        return new \Framework\Handlers\EnvHandler();
    }));



}catch (\Framework\Exceptions\ZxzHttpException $e){

}