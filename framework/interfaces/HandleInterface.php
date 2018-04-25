<?php
/**
 * Created by PhpStorm.
 * User: zouxiaozhu
 * Date: 18-3-13
 * Time: 下午11:51
 */
namespace Framework\Interfaces;
use Framework\App;

interface HandleInterface {
    public function register(App $app);
}