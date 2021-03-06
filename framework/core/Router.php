<?php
/**
 * Created by PhpStorm.
 * User: zouxiaozhu
 * Date: 18-3-18
 * Time: 下午3:09
 */

namespace Framework\Core;

use Framework\App;
use Framework\Exceptions\CommandException;
use Framework\Exceptions\ZxzHttpException;
use function GuzzleHttp\Psr7\uri_for;

class Router
{
    private $routeStrategyMap = [
        'general' => 'Framework\Router\General',
        'pathinfo' => 'Framework\Router\Pathinfo',
        'user-defined' => 'Framework\Router\Userdefined',
        'micromonomer' => 'Framework\Router\Micromonomer',
        'job' => 'Framework\Router\Job'
    ];

    protected $routeStrategy;

    public function init(App $app)
    {
        $app::$container->setSingle('router', $this);

        $this->request = App::$container->getSingle('request');
        $this->config = App::$container->getSingle('config');
        $this->app = $app;
        $this->requestUri = $this->request->server('REQUEST_URI');
        $configParams = ($this->config->configParams);

        $this->module = $configParams['default_module'] ?: 'index';
        // 设置默认控制器 set default controller
        $this->controller = $configParams['default_controller'] ?: 'Index';
        // 设置默认操作 set default action
        $this->action = $configParams['default_action'] ?: 'index';

        $this->strategyJudge();

        (new $this->routeStrategyMap[$this->routeStrategy])->router($this);
        $this->start();

    }

    protected function classv()
    {

        $controller = ucfirst($this->controller);
        $folder = ucfirst($this->config->config['application_folder']);
        $this->classPath = "{$folder}\\{$this->module}\\{$controller}";
        $this->executeType = 'controller';
    }

    /**
     * @throws ZxzHttpException
     */
    protected function start()
    {
        if ($this->routeStrategy != 'job') {
            $module_dir = CONTROLLER_PATH . SEPARATOR . $this->module;

            if (!is_dir($module_dir) || !is_readable($module_dir)) {
                throw new ZxzHttpException(404,
                    sprintf('DIR %s NOT FOUND OR PERMISSION DENIED', $this->module));
            }

            $file_path = CONTROLLER_PATH . SEPARATOR . $this->module . SEPARATOR . ucfirst($this->controller) . PHP_FILE;

            $uc = explode('/', $this->module . SEPARATOR . ucfirst($this->controller));

            $uc = array_map(function ($va) {
                return ucfirst($va);
            }, $uc);

            $uc = implode('\\', $uc);
            $namespace_path = '\App\Controllers\\' . $uc;

            if (!file_exists($file_path)) {
                throw new ZxzHttpException(404,
                    sprintf('FILE %s NOT FOUND OR PERMISSION DENIED', $this->controller));
            }

            $obj = new $namespace_path($this->app);
            if (!method_exists($obj, $this->action)) {
                throw new ZxzHttpException(404,
                    sprintf('Class %s CALL TO UNDEFINED METHOD %s', $this->controller, $this->action));
            }
            $ret = $obj->{$this->action}();

        } else {
            $namespace_path = $this->controller;
            $obj = new $namespace_path();
            if (!method_exists($obj, $this->action)) {
                throw new ZxzHttpException(404,
                    sprintf('Class %s CALL TO UNDEFINED METHOD %s', $this->controller, $this->action));
            }
            try {
                $ret = $obj->{$this->action}(request(), ...$this->cli_params);
            } catch (\Exception $exception) {
                throw new CommandException($exception->getMessage() . '---' . $exception->getCode(), 499);
            }
        }

        $this->app->response_data = $ret;


    }

    public function strategyJudge()
    {
//        // 路由策略
//        if (! empty($this->routeStrategy)) {
//            return;
//        }
//
        // 任务路由
        if (php_sapi_name() == 'cli') {
            $this->routeStrategy = 'job';
            return;
        }
        // 普通路由
        if (strpos($this->requestUri, 'index.php')
//               || $this->app->runningMode === 'cli'
        ) {
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