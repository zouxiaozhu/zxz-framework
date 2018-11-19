<?php
/**
 * Created by PhpStorm.
 * User: zouxiaozhu
 * Date: 18-3-17
 * Time: 上午1:10
 */

if(!function_exists('logMessage')){
    function logMessage($controller, $method, $message, $path){
        echo 111;
    }
}

if(!function_exists('toJson')){
    function toJson($item){
        echo json_encode($item);die;
    }
}