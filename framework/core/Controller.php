<?php
/**
 * Created by PhpStorm.
 * User: zouxiaozhu
 * Date: 18-4-26
 * Time: 下午11:23
 */
namespace Framework\Core;
use Framework\App;

class Controller{
    protected $app;
    protected $database_conn;

    public function model($database_conn = [])
    {
       
    }

    public function __construct(App $app)
    {

    }
//
//    public function callConstruct(){
//        parent::__construct();
//    }

    public function response($status = false, $msg = [], $data = [])
    {
        return ['status' => $status, 'msg' => $msg, 'data'=>$data];
    }
   
}