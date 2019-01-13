<?php
/**
 * Created by PhpStorm.
 * User: zouxiaozhu
 * Date: 18-4-25
 * Time: 上午12:08
 */

namespace App\Controllers\Aa;
class Bb
{
    public function __construct()
    {

        collect([])->pop()->shift()->toJson();

    }

    public function index()
    {

    }
}