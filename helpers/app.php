<?php
/**
 * Created by PhpStorm.
 * User: zouxiaozhu
 * Date: 18-5-1
 * Time: 下午1:42
 */

use Framework\App;
use Framework\Exceptions\ZxzHttpException;

if (!function_exists('app')) {
    /**
     * @param string $alias
     * @return \Framework\Container|mixed
     */
    function app($alias = '')
    {
        if (!$alias) {
            return App::$container;
        }

        try {
            return App::$container->getSingle($alias);
        } catch (ZxzHttpException $e) {
            echo $e->response();
        }
    }
}

if (!function_exists('collect')) {
    function collect($iterator)
    {
        if (is_array($iterator)) {
            return new \Framework\Handlers\CollectionHandler($iterator);
        }
    }
}

if (!function_exists('config')) {
    /**
     * @param string $item
     *
     * @return \Framework\Handlers\ConfigHandler
     */
    function config(string $item = '')
    {
        if ($item) {
            return app('config')->get($item);
        }
        return app('config');
    }
}

if (!function_exists('request')) {
    /**
     * @param string $item
     *
     * @return \Framework\Request
     */
    function request(string $item = '')
    {
        if ($item) {
            return app('request')->get($item);
        }
        return app('request');
    }
}