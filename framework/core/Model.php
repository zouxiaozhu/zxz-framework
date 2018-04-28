<?php
/**
 * Created by PhpStorm.
 * User: zouxiaozhu
 * Date: 18-4-27
 * Time: 下午13:53
 */
namespace Framework\Core;
use App;
class Model{
    protected $app;
    protected $database_group;
    protected $table;

    public function __construct(App $app)
    {
        static::__construct();
    }


}
