<?php
/**
 * Created by PhpStorm.
 * User: zhanglong
 * Date: 2019/1/22
 * Time: 11:52 PM
 */

namespace App\controllers\pass;

use Framework\Core\Controller;

class pass extends Controller
{
    /**
     * https://www.jianshu.com/p/901be4dd9a3d
     */
    public function en()
    {
        $privateKey = openssl_pkey_new();
        openssl_pkey_export($privateKey, $out); //private

        // publickey 是从private中取出来的
        $publicKey = openssl_pkey_get_details($privateKey)['key'];
        // start end 格式则是pem格式的直接可以 file_put_contents 公私钥不可以直接使用
        // 否则         openssl_pkey_export_to_file($privateKey, 'private.key');
        file_put_contents('public.key', $publicKey);
        file_put_contents('private.key', $out);
        echo $publicKey;
        echo PHP_EOL;
        echo $out;
      echo die;
    }

    public function decrypt()
    {
        openssl_public_encrypt('我是世界上最喜111111欢你的人',$crypted, openssl_pkey_get_public(file_get_contents('public.key')));
        openssl_private_decrypt($crypted,$decrypted, openssl_pkey_get_private(file_get_contents('private.key')));

        echo $decrypted;
        echo die;
    }

    public function hash()
    {
        $str = 'xxxx';
        $salt = '';
        $options = [
            'cost' => 11,

        ];
        $pass = password_hash($str,PASSWORD_BCRYPT, $options);
       $a =  password_verify($str ,$pass );
       var_dump($a);die;
    }
}