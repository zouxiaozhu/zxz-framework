<?php
/**
 * Created by PhpStorm.
 * User: zouxiaozhu
 * Date: 18-3-13
 * Time: 下午11:53
 */
namespace Framework\Handlers;
use Framework\App;
use Framework\Core\DB;
use Framework\Exceptions\ZxzHttpException;
use Framework\Interfaces\HandleInterface;

class Modelhandler implements HandleInterface{
    protected $group;
    public function __construct()
    {
        
    }

    public function register(App $app)
    {

        App::$container->setSingle('model', new DB($app));
    }

}
