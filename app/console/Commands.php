<?php
/**
 * Created by PhpStorm.
 * User: zhanglong
 * Date: 2018/12/11
 * Time: 2:54 PM
 */

namespace App\console\command;


interface Commands
{
    public function handle(\Framework\Request $request);
}