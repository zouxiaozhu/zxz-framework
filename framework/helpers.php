<?php
/**
 * Created by PhpStorm.
 * User: zouxiaozhu
 * Date: 18-3-17
 * Time: 下午4:13
 */

if (!function_exists('env')) {
    function env(string $name = '', $default = null)
    {
        if (!$name) return null;

        $envInstance = \Framework\App::$container->getSingle('env');
        $value = $envInstance->env($name);

        return $value ?? $default;
    }
}


if (!function_exists('zxzLog')) {
    function zxzLog($data = '', $file_name = '')
    {
        $file_name = date('Y-m-d') . '-' . $file_name;

        $dir = env('log_path') ?
            RESOURCE_PATH . DIRECTORY_SEPARATOR . '/logs/' . env('log_path') : RESOURCE_PATH . '/logs';

        if (!is_dir($dir)) {
            exec("mkdir -p $dir && chmod -R 755 $dir");
        }

        $path = $dir . DIRECTORY_SEPARATOR . $file_name . '.log';
        if (!file_exists($path)) {
            exec("touch $path && chmod 755 $path");
        }

        $uri = request()->server('REQUEST_URI');
        $method = request()->server('REQUEST_METHOD');
        $resq = json_encode(request()->all());

        if (!in_array($file_name, ['request', 'response', 'exception'])) {

            file_put_contents(
                $path,
                date('Y-m-d H:i:s') . '[~ ' . getmygid() . '~]' .
                (is_string($data) ? $data . PHP_EOL : json_encode($data)) . PHP_EOL,
                FILE_APPEND
            );
            return;
        }

        file_put_contents(
            $path,
            date('Y-m-d H:i:s') . " ----$method/$uri" . '[~ ' . getmygid() . '~]' .
            '----- resq ' . $resq . PHP_EOL .
            '----- resp -----' . (is_string($data) ? $data . PHP_EOL : json_encode($data)) . PHP_EOL,
            FILE_APPEND
        );
        return;
    }
}



