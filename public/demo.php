<?php
/**
 * Created by PhpStorm.
 * User: zhanglong
 * Date: 2018/12/1
 * Time: 下午7:18
 */


function gt($a, $b) {
    return $a > $b;
}

$a = 1;
$b = 2;
$bool = (gt($a, $b));
var_dump($bool);