<?php

namespace Framework;

use Framework\App;
use Framework\Exceptions\ZxzHttpException;

use Illuminate\Database\Capsule\Manager as Capsule;

class Load
{

    public static $map = [];
    public static $namespaceMap = [];

    public static function register(App $app)
    {
        self::$namespaceMap = [
            'Framework' => $app->rootPath
        ];

        spl_autoload_register(['Framework\Load', 'autoload']);
        include $app->rootPath . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

        realpath($app->rootPath . DIRECTORY_SEPARATOR . 'vendor/autoload.php') && require_once $app->rootPath . DIRECTORY_SEPARATOR . 'vendor/autoload.php';
//        $config = new Config();
}


    public static function autoload($class)
    {
        $class_info = explode('\\', $class);
        $class_name = array_pop($class_info);

        $class_info = array_map(function ($value) {
            return (strtolower($value));
        }, $class_info);

        $framework_path = self::$namespaceMap['Framework'];
        $class_path = $framework_path . DIRECTORY_SEPARATOR
            . join('/', $class_info) . DIRECTORY_SEPARATOR;

        $class_real_path = $class_path . $class_name . '.php';

        foreach (glob($class_path . '*') as $file) {
            if (strtolower($class_real_path) == strtolower($file)) {
                $class_real_path = $file;
            }
        }

        if(!file_exists($class_real_path)){
            throw new ZxzHttpException('400', $class_path.'not exist');
            return ;
        }

        self::$namespaceMap[$class] = $class_real_path;

        require $class_real_path;
    }

}
