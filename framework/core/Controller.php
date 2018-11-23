<?php
/**
 * Created by PhpStorm.
 * User: zouxiaozhu
 * Date: 18-4-26
 * Time: 下午11:23
 */

namespace Framework\Core;

use Framework\App;

class Controller
{
    protected $app;
    protected $database_conn;

    public function model($database_conn = [])
    {

    }

    public function __construct()
    {
        $this->app = App::$container;
        static::__construct();
    }
//
//    public function callConstruct(){
//        parent::__construct();

//    }

    public function responseFalse($data = [], $msg = 'undefined error')
    {
        return ['status' => false, 'msg' => $msg, 'data' => $data, 'code' => 500];
    }

    public function responseTrue($data = [], $msg = 'success', $code = 200)
    {
        return ['status' => true, 'msg' => $msg, 'data' => $data,  'code' => $code];
    }

}