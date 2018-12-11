<?php
/**
 * Created by PhpStorm.
 * User: zhanglong
 * Date: 2018/11/25
 * Time: 下午12:14
 */

namespace App\Console;

use App\Console\Command\Welcome;

class Kernel
{
    public static $commands = [
        'welcome' => Welcome::class
    ];
}