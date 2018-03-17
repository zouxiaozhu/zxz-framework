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
//        $this->loadHelper($app);
    }

    public function register(App $app)
    {
        $this->loadConfig($app);
        App::$container->setSingle('config', $this);
        $this->loadHelper($app);

    }

    protected function loadConfig(App $app){

        $configPath = $app->rootPath. DIRECTORY_SEPARATOR.'config/*.php';
        $configItems = [];
        foreach (glob($configPath.'/*.php')  as $file){
            $configItems =array_merge($configItems, include_once $file);
        }

        $this->configParams = $configItems;
    }

    protected function loadHelper(App $app){

        foreach (glob($app->rootPath.'/helpers/*.php')  as $file){
            require_once $file;
        }

        require_once FRAMEWORK_PATH.DIRECTORY_SEPARATOR.'helpers.php';
    }

    public function get()
    {
        echo 11;
    }
}