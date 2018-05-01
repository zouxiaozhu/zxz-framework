<?php
/**
 * Created by PhpStorm.
 * User: zouxiaozhu
 * Date: 18-5-1
 * Time: 下午1:42
 */
use Framework\App;
use Framework\Exceptions\ZxzHttpException;

if ( !function_exists('app')){
    /**
     * @param string $alias
     * @return \Framework\Container|mixed
     */
    function app($alias = ''){
        if ( !$alias ) {
            return App::$container;
        }

        try {
            return App::$container->getSingle($alias);
        } catch (ZxzHttpException $e) {
            echo $e->response();
        }
    }
}

