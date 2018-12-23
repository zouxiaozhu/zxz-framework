<?php
/**
 * Created by PhpStorm.
 * User: zhanglong
 * Date: 2018/12/11
 * Time: 2:32 PM
 */

namespace App\Console\Command;

use Framework\Core\Controller;
use Framework\Request;

//implements Commands
class Welcome extends Controller
{
    public function handle(Request $request, $user_id, $name, $age)
    {

        return $this->responseTrue([$request->all(), $user_id, $name, $age]);
    }
}