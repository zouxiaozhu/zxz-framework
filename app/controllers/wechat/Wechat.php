<?php
/**
 * Created by PhpStorm.
 * User: zhanglong
 * Date: 2018/11/6
 * Time: 13:51
 */

namespace App\Controllers\WeChat;

use EasyWeChat\Factory;
use Framework\Core\Controller;
use Framework\Exceptions\ZxzApiException;
use Framework\Exceptions\ZxzHttpException;

class Wechat extends Controller
{
    /**
     *
     */
    public function log()
    {
        zxzLog("111", "testlog");
    }

    /**
     * @return array
     * @throws ZxzApiException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function wxLogin()
    {
        $code = request('code') ?? '';
        if (empty($code)) {
            throw new ZxzApiException('no code find from wechat', 400);
        }

        $weChatMiniConfig = config()->all()['wechat_mini'];
        $app = Factory::miniProgram($weChatMiniConfig);
        $authSession = $app->auth->session();
//        $user = $app->user->get($authSession['open_id']);'
//        "session_key": "lWDJr+cQ3hvHEdYFnnAO+w==",
//        "openid": "oWRoZ401EXQDKKGy6zBgP1vGAHG0"
        return $this->responseTrue($authSession);

    }


    public function a()
    {
    }


    public function access_token()
    {
//        $request = $this->app->getSingle('request')->all();
        echo $_REQUEST["echostr"];
        die();
    }
}