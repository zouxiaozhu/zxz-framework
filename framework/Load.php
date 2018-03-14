<?php

namespace Framework;
use Framework\App;
use Framework\Exceptions\ZxzHttpException;


class Load {

    public static $map = [];
    public static $namespaceMap = [];

    public static function register(App $app)
    {

        self::$namespaceMap = [
            'Framework' => $app->rootPath
        ];

        spl_autoload_register(['Framework\Load', 'autoload']);
        require_once $app->rootPath . DIRECTORY_SEPARATOR .'autoload.php' ;
//        $config = new Config();


    }

    public function autoload($class)
    {
        echo $class;die;
    }




}
