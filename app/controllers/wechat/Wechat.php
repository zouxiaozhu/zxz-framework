<?php
/**
 * Created by PhpStorm.
 * User: zhanglong
 * Date: 2018/11/6
 * Time: 13:51
 */

namespace App\Controllers\WeChat;

use App\Model\UserModel;
use EasyWeChat\Factory;
use Framework\Core\Controller;
use Framework\Exceptions\ZxzApiException;

class Wechat extends Controller
{

    /**
     * @var UserModel $userModel
     */
    protected $userModel;

    /**
     * @return mixed
     */
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

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
     * @throws \EasyWeChat\Kernel\Exceptions\DecryptException
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
        $authSession = $app->auth->session($code);

    }

    public function modifyUser()
    {
        $update = collect([
            'long' => request('long'),
            'lati' => request('lati')
        ])->filter()->toArray();
        $where = [
            'id' => (int)request('user_id'),
        ];
    }

    public function a()
    {
    }

    public function updateUser(array $where, array $data)
    {
        return $this->userModel->updateOrCreate($where, $data);
    }

    public function access_token()
    {
        echo request('echostr');
        die();
    }

    public function userInfo()
    {
        $userInfo = $this->userModel->find(request('id'))->toArray();
        return $this->responseTrue($userInfo);
    }
}