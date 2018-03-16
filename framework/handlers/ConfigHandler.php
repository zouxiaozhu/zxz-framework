<?php
/**
 * Created by PhpStorm.
 * User: zouxiaozhu
 * Date: 18-3-17
 * Time: 上午1:15
 */
namespace Framework\Handlers;
use \Framework\App;
use Framework\Interfaces\HandleInterface;

class ConfigHandler implements HandleInterface {
    public function __construct(App $app)
    {
        foreach (glob($app->rootPath.'/helpers/*.php')  as $file){
            require_once $file;
        }
    }

    public function register(App $app)
    {
        $this->loadConfig($app);
        App::$container->setSingle('config', $this);
    }

    protected function loadConfig(App $app){

        $configPath = $app->rootPath. DIRECTORY_SEPARATOR.'config/*.php';
        $configItems = [];
        foreach (glob($configPath) as $configFile){
            $configItems[rtrim(basename($configFile),'.php')] =
                include "$configFile";
        }
//        var_export($configItems);die;
        $this->configParams = $configItems;
    }

}