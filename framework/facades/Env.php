<?php
/**
 * Created by PhpStorm.
 * User: zouxiaozhu
 * Date: 18-3-17
 * Time: 下午11:21
 */

namespace Framework\Facades;
use Framework\Facade;

class Env extends Facade {
    protected static function getFacadeAccessor()
    {
        return 'env';
    }
}