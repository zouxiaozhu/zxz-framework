<?php
/**
 * Created by PhpStorm.
 * User: zouxiaozhu
 * Date: 18-5-1
 * Time: 下午1:38
 */
namespace App\Controllers\Githook;
use Framework\App;
use Framework\Core\Controller;
class Hook extends Controller{
    protected $token;
    protected $git_token;

    /**
     * Hook constructor.
     */
    public function __construct()
    {
        $envHandler = app('env');
        $request = app('request');
        $this->git_token = trim($request->all('token') ? : '');
        $this->token = trim($envHandler->env('GITHOOK_TOKEN'));
    }

    public function pull(){

        if ( $this->git_token !== $this->token){
            return $this->response(false, 'GIT TOKEN 校验失败');
        }

        $git_bin = exec('which git');
        if ( !$git_bin ) {
            zxzLog(date("Y-m-d H:i:s" ,time())." git not exist", 'git');
        }
        exec(" cd ". ROOT_PATH ." &&git checkout -- . &&  git pull");
        $now_time = date("Y-m-d");
        zxzLog(date("Y-m-d H:i:s" ,time())." git pull end", "git-{$now_time}.log");
        return true;

    }
}