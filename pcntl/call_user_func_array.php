<?php
/**
 * Created by PhpStorm.
 * User: zhanglong
 * Date: 2019/1/8
 * Time: 2:35 PM
 */


class Obj
{
    public  function aaa($a)
    {
        return $a;
    }
}

error_reporting(0);
$t = call_user_func_array('Obj::aaa', [122]);

var_dump($t);die;
