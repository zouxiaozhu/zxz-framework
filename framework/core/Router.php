<?php
/**
 * Created by PhpStorm.
 * User: zouxiaozhu
 * Date: 18-3-18
 * Time: 下午3:09
 */
namespace Framework\Core;

use Framework\App;

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
        $this->controller = $configParams['default_controller'] ? : 'IndexController';
        // 设置默认操作 set default action
        $this->action     = $configParams['default_action'] ? : 'index';



        $this->strategyJudge();

        (new $this->routeStrategyMap[$this->routeStrategy])->router($this);
        $this->start();
//        $this->start();
    }
    protected function class(){

        $controller = ucfirst($this->controller);
        $folder = ucfirst($this->config->config['application_folder']);
        $this->classPath = "{$folder}\\{$this->module}\\{$controller}";
        $this->executeType = 'controller';
    }

    protected function start()
    {
        $this->class();
        var_export($this->classPath);die;
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