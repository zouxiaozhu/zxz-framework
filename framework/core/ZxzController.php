<?php
/**
 * Created by PhpStorm.
 * User: zouxiaozhu
 * Date: 18-4-26
 * Time: 下午11:23
 */
namespace Framework\Core;
use App;
class ZxzController{
    protected $app;

    public function load()
    {
        
    }

    public function test($a = 1)
    {
        return [
            'a' => $a,
            'data' => date("Y-m-d")
        ];
    }
}