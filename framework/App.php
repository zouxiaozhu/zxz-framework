<?php
/**
 * Created by PhpStorm.
 * User: zouxiaozhu
 * Date: 18-3-11
 * Time: 下午11:00
 */

namespace Framework;
use Closure;
class App {


    private $runningMode = 'fpm';
    private $rootPath;              // 需要用魔术方法获取
    private $handlesList = [];      //框架加载流程一系列处理类集合
    public static $app;
    public static $container;
    public $notOutput = false;
    public function __construct($root, $loader)    {


        $this->runningMode = php_sapi_name();
         // 根目录

         // echo getenv('EASY_MODE');die;
        $this->rootPath = $root;

        is_callable($loader) ? $loader() : require_once $loader;
        Load::register($this); // 引入框架路径 加载自动加载文件

        self::$app = $this;

        self::$container = new Container();
    }

    public function run(Closure $request){
        self::$container->setSingle('request',$request);

        foreach ($this->handlesList as $handle){

            $handle()->register($this);
        }

    }

    public function __get($name = '')
    {

        return $this->$name;
    }

    public function __set($name = '', $value = '')
    {
        $this->$name = $value;
    }

    public function load(Closure $handle)
    {
        $this->handlesList[] = $handle;
    }

    public function response(Closure $closure)
    {
        if ($this->notOutput === true) {
            return;
        }
        $this->response_data =　1;
        $closure()->success($this->response_data);
    }
}