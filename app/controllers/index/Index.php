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

class Index extends Controller
{

    public function index()
    {
        $a = $this->test(1);
        return $this->responseTrue([Config::get('database.defaults'), $a]);
    }


    public function test($a)
    {
        return (boolean)$a;
    }

    public function collection()
    {
        $a = ['a', 'b', 'c'];
        var_dump(collect($a)->end());
        die;
    }
}