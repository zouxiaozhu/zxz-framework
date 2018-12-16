<?php
/**
 * Created by PhpStorm.
 * User: zouxiaozhu
 * Date: 18-3-11
 * Time: 下午10:05
 */

// 载入框架运行文件
define('ROOT_PATH', dirname(dirname(__FILE__)));
//define('ROOT_PATH', getcwd().'/../');
define('DEBUG_MODE', true);

if (DEBUG_MODE) {
    ini_set('display_errors', 'on');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 'off');
    error_reporting(0);
}

// 文件间隔符
!defined('DIRECTORY_SEPARATOR') && define('DIRECTORY_SEPARATOR', '/');
!defined('SEPARATOR') && define('SEPARATOR', '/');
!defined('PHP_FILE') && define('PHP_FILE', '.php');

//公共文件入口
define('PUBLIC_PATH', dirname(__DIR__));
//
define('RESOURCE_PATH', ROOT_PATH . DIRECTORY_SEPARATOR . 'resource');
define('LOG_PATH', RESOURCE_PATH . DIRECTORY_SEPARATOR . 'log');
define('FRAMEWORK_PATH', ROOT_PATH . DIRECTORY_SEPARATOR . 'framework');
// 应用路径
define('APP_PATH', ROOT_PATH . DIRECTORY_SEPARATOR . 'app');
define('CONTROLLER_PATH', APP_PATH . SEPARATOR . 'controllers');
ini_set('date.timezone', 'Asia/Shanghai');
require_once(FRAMEWORK_PATH . DIRECTORY_SEPARATOR . 'run.php');