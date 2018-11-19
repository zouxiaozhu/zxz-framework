<?php
/**
 * Created by PhpStorm.
 * User: zhanglong
 * Date: 2018/11/19
 * Time: 下午4:09
 */

namespace Framework\Support;
class Arr
{
    public static function only(array $arr, array $keys):array
    {
        return array_intersect_key($arr, array_flip($keys));
    }

    public static function isAssoc(array $arr):bool
    {
        return array_keys($arr) != array_keys(array_keys($arr));
    }
}