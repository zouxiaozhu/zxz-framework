<?php
/**
 * Created by PhpStorm.
 * User: zouxiaozhu
 * Date: 18-3-18
 * Time: 下午3:09
 */
namespace Framework\Core;

use Framework\App;
use Framework\Exceptions\ZxzHttpException;

class Router{
    private $routeStrategyMap = [
        'general'      => 'Framework\Router\General',
        'pathinfo'     => 'Framework\Router\Pathinfo',
        'user-defined' => 'Framework\Router\Userdefined',
        'micromonomer' => 'Framework\Router\Micromonomer',
        'job'          => 'Framework\Router\Job'
    ];
    public function init(App $app){

        $app::$container->setSingle('router', $this);

        $this->request = App::$container->getSingle('request');
        $this->config = App::$container->getSingle('config');

        $this->app            = $app;
        $this->requestUri = $this->request->server('REQUEST_URI');
        $configParams = ($this->config->configParams);

        $this->module     = $configParams['default_module'] ? : 'index';
        // 设置默认控制器 set default controller
        $this->controller = $configParams['default_controller'] ? : 'Index';
        // 设置默认操作 set default action
        $this->action     = $configParams['default_action'] ? : 'index';

        $this->strategyJudge();

        (new $this->routeStrategyMap[$this->routeStrategy])->router($this);
        $this->start();

    }
    protected function classv(){

        $controller = ucfirst($this->controller);
        $folder = ucfirst($this->config->config['application_folder']);
        $this->classPath = "{$folder}\\{$this->module}\\{$controller}";
        $this->executeType = 'controller';
    }

    protected function start()
    {

        $moudle_dir = CONTROLLER_PATH.SEPARATOR.$this->module;

        if(!is_dir($moudle_dir) || !is_readable($moudle_dir)){
            throw new ZxzHttpException(404,
                sprintf('DIR %s NOT FOUND OR PERMISSION DENIED', $this->module));
        }

        $file_path = CONTROLLER_PATH.SEPARATOR.$this->module.SEPARATOR.ucfirst($this->controller).PHP_FILE;

        $uc = explode('/',$this->module.SEPARATOR.ucfirst($this->controller));

        $uc = array_map(function($va){
            return ucfirst($va);
        }, $uc);

        $uc = implode('\\', $uc);
        $namespace_path = '\App\Controllers\\'.$uc ;

        if(!file_exists($file_path))
       {
            throw new ZxzHttpException(404,
                sprintf('FILE %s NOT FOUND OR PERMISSION DENIED', $this->controller));
        }

        $obj = new $namespace_path();

        if(!method_exists($obj, $this->action)){
            throw new ZxzHttpException(404,
                sprintf('Class %s CALL TO UNDEFINED METHOD %s', $this->controller, $this->action));
        }
        $ret = $obj->{$this->action}($this->app);
        $this->app->response_data = $ret;
    }

    public function strategyJudge()
    {
//        // 路由策略
//        if (! empty($this->routeStrategy)) {
//            return;
//        }
//
//        // 任务路由
//        if ($this->app->runningMode === 'cli' && $this->request->get('router_mode') === 'job') {
//            $this->routeStrategy = 'job';
//            return;
//        }

        // 普通路由
        if (strpos($this->requestUri, 'index.php')
//               || $this->app->runningMode === 'cli'
        )
        {
            $this->routeStrategy = 'general';
            return;
        }

        $this->routeStrategy = 'pathinfo';
    }

    public function __get($name = '')
    {
        return $this->$name;
    }

    public function __set($name = '', $value = '')
    {

        $this->$name = $value;
    }
}