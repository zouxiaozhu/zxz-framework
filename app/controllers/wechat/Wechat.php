<?php
/**
 * Created by PhpStorm.
 * User: zhanglong
 * Date: 2018/11/6
 * Time: 13:51
 */

namespace App\Controllers\WeChat;

use Framework\Core\Controller;

class Wechat extends Controller
{
    /**
     *
     */
    public function log()
    {
        zxzLog("111", "testlog");
    }

    public function access_token()
    {

        $request = $this->app->getSingle('request')->all();
        echo $request["echostr"];
        die();
    }
}