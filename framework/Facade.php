<?php
/**
 * Created by PhpStorm.
 * User: zouxiaozhu
 * Date: 18-3-17
 * Time: 下午11:56
 */
namespace Framework;
use Framework\Exceptions\ZxzHttpException;

class Facade {

    public static function __callStatic($method, $args){

        $alias = static::getFacadeAccessor(); // config
        $instance =  static::getInstance($alias);

        switch (count($args)) {
            case 0:
                return $instance->$method();
            case 1:
                return $instance->$method($args[0]);
            case 2:
                return $instance->$method($args[0], $args[1]);
            default:
                return call_user_func_array([$instance, $method], $args);
        }
    }

    public static  function getInstance($alias){

        $instance_map = App::$container->instanceMap;

        if(!array_key_exists($alias, $instance_map)){
            throw new ZxzHttpException(400, $alias.' instance not exist');
        }
        return  $instance_map[$alias];
    }
}