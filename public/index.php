<?php
/**
 * Created by PhpStorm.
 * User: zouxiaozhu
 * Date: 18-3-11
 * Time: 下午10:05
 */


// 载入框架运行文件
define('ROOT_PATH', dirname(dirname(__FILE__)));

// 文件间隔符
define('DIRECTORY_SEPARATOR', '/');

//公共文件入口
define('PUBLIC_PATH', dirname(__DIR__));

// 应用路径
define('APP_PATH', ROOT_PATH.DIRECTORY_SEPARATOR.'app');

require_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'framework/run.php');