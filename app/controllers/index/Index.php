<?php
/**
 * Created by PhpStorm.
 * User: zouxiaozhu
 * Date: 18-4-25
 * Time: 下午11:56
 */
namespace App\Controllers\Index;
use Framework\Core\Controller;
use Framework\Facades\Config;
use Framework\Facades\Env;

class Index extends Controller {

    public function index()
    {
        return Config::get('database.default');
    }

    public function collection()
    {
        $a = ['a', 'b', 'c'];
        var_dump(collect($a)->end());die;
    }
}