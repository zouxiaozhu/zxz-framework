<?php
/**
 * Created by PhpStorm.
 * User: zouxiaozhu
 * Date: 18-3-17
 * Time: 下午4:13
 */

if (!function_exists('env')){
    function env(string $name ='', $default = null){
        if(!$name) return null;

        $envInstance = \Framework\App::$container->getSingle('env');
        $value = $envInstance->env($name);

        return $value ?? $default;
    }
}


if(!function_exists('zxzLog')){
    function zxzLog($data = '', $file_name = ''){
        if (!file_exists($file_name)){
            exec("touch $file_name");
        }

        file_put_contents(
            LOG_PATH.SEPARATOR .$file_name,
            is_string($data) ? $data.PHP_EOL : var_export($data, 1),
            FILE_APPEND
            );
    }
}



