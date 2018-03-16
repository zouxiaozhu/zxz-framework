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
!defined('DIRECTORY_SEPARATOR') && define('DIRECTORY_SEPARATOR', '/');

//公共文件入口
define('PUBLIC_PATH', dirname(__DIR__));
//
define('FRAMEWORK_PATH', ROOT_PATH.DIRECTORY_SEPARATOR.'framework');
// 应用路径
define('APP_PATH', ROOT_PATH.DIRECTORY_SEPARATOR.'app');

require_once(FRAMEWORK_PATH.DIRECTORY_SEPARATOR.'run.php');