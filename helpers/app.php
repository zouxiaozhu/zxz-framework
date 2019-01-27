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
        } catch (Exception $e) {
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
        return app('config')->all();
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

if (!function_exists('get_class_name')) {
    /**
     * @param $namespace
     * @return mixed
     */
    function get_class_name($namespace)
    {
        $class = explode('\\', $namespace);
        return end($class);
    }
}

if (!function_exists('ds')) {
    /**
     * @param array $data
     * @return mixed
     */
    function ds($data)
    {
        if (is_array($data)) {
            echo json_encode($data);
        } else if (is_string($data)) {
            echo $data;
        } else if (is_bool($data)) {
            var_dump($data);
        } else {
            var_dump($data);
        }

        die(0);
    }
}

if (!function_exists('report')) {
    function report($type, $content)
    {
        /**
         * @var \Framework\Handlers\ReportHandler $report
         */
        $report = app('report');
        if (is_array($content)) {
            $content = json_encode($content, JSON_UNESCAPED_SLASHES);
        }

        $report->report($type, $content);
    }
}

if (!function_exists('zxz_path')) {
    function zxz_path($path = '/')
    {
        $real_path = rtrim(ROOT_PATH, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . trim($path, DIRECTORY_SEPARATOR);
        if (!realpath($real_path)) {
            throw new ZxzHttpException(404, 'FILE NOT FOUND');
        }
        return $real_path;
    }
}