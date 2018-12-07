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
//        $userInfo = {"nickName":"你的坚持，终将美好","gender":1,"language":"zh_CN","city":"","province":"","country":"St.Kitts and Nevis","avatarUrl":"https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJLYoe9zBkOXwPibjNQg8juZjUiaeqVpeHsb5pJF48enIvOoR3Hh4iaRN7FDUxpVOrrrF8zrnHWgASqA/132"}';
        $code = request('code') ?? '';

        if (empty($code)) {
            throw new ZxzApiException('no code find from wechat', 400);
        }

        $weChatMiniConfig = config()->all()['wechat_mini'];
        $app = Factory::miniProgram($weChatMiniConfig);
        $authSession = $app->auth->session($code);

        if (!($authSession['openid'] ?? '')) {
            throw new ZxzApiException('code cant revert from wechat', 500);
        }
        $user = $this->initUser($authSession);
        if (empty($user->wechat_name) || empty($user->avatar)) {
            $decryptedData = $app->encryptor->decryptData($authSession['session_key'], request('iv'), request('encryptedData'));
            $this->updateUser([[
                'mini_open_id' , $decryptedData['openId'],
            ]],[
                'avatar' => $decryptedData['avatarUrl'],
                'wechat_name' => $decryptedData['nickName'],
            ]);
        }

        return $this->responseTrue($user->toArray());

    }

    public function modifyUser()
    {
        $update = collect([
            'long' => request('long'),
            'lati' => request('lati')
        ])->filter()->toArray();
        $where = [
            'id' => (int) request('user_id'),
        ];

        $ret = $this->updateUser($where, $update);
        return $this->responseTrue($ret->toArray());
    }

    /**
     * @param array $authSession
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function initUser($authSession = [])
    {
        return $this->userModel->updateOrCreate([
            'mini_open_id' => $authSession['openid'] ?? '',
        ], [
            'mini_open_id' => $authSession['openid'] ?? '',
            'session_key' => $authSession['session_key'] ?? '',
            'union_id' => $authSession['union_id'] ?? ''
        ]);

    }

    public function updateUser(array $where,array $data)
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