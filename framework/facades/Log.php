<?php
/**
 * Created by PhpStorm.
 * User: zouxiaozhu
 * Date: 18-3-18
 * Time: 下午2:51
 */
namespace Framework\Facades;
use Framework\Facade;

class Log extends Facade{
    protected static function getFacadeAccessor()
    {
        return 'log';
    }
}