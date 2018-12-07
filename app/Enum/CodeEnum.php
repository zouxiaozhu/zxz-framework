<?php
/**
 * Created by PhpStorm.
 * User: zhanglong
 * Date: 2018/12/7
 * Time: 下午4:40
 */

namespace App\Enum;

class CodeEnum
{
     const AMQP_CONN_ERROR = 999;
    protected $a = 1;
    public $b = 2;

    public static function getEnum($alias)
    {

       ds(self::AMQP_CONN_ERROR);
    }

    public static function getConstants()
    {
        $class = get_called_class();
        $t = [];
        $reflect = new \ReflectionClass($class);
        $t[] = $reflect->getConstants();
        $t[] = $reflect->getProperties(null);
       ds($reflect->getConstants());
    }
}