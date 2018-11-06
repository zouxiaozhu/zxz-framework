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
    function zxzLog($data = '', $file_name = '', $dir = ''){
        $dir = env('log_path') ?
            RESOURCE_PATH .DIRECTORY_SEPARATOR.'/log/'.env('log_path') : RESOURCE_PATH.'/log';

        if (!file_exists($file_name)){
            exec("touch $file_name && chmod 755 $file_name");
        }

        file_put_contents(
            $dir.SEPARATOR .$file_name,
            date('Y-m-d H:i:s') . '  ----  ' . (is_string($data) ? $data.PHP_EOL : var_export($data, 1)),
            FILE_APPEND
            );
    }
}



