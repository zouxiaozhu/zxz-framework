<?php
/**
 * Created by PhpStorm.
 * User: zouxiaozhu
 * Date: 18-3-13
 * Time: 下午11:53
 */

namespace Framework\Handlers;

use Framework\App;
use Framework\Exceptions\ZxzHttpException;
use Framework\Interfaces\HandleInterface;

class EnvHandler implements HandleInterface
{

    private $envParams = [];

    public function __construct()
    {
        //
    }

    public function register(App $app)
    {

        $this->loadEnv($app);

        App::$container->setSingle('env', $this);
    }


    /**
     * 获取env环境变量
     * @param string $key
     * @return mixed|string
     */
    public function env($key = '')
    {
        if (!$key) return '';

        return array_key_exists($key, $this->envParams) ? $this->envParams[$key] : null;

    }

    /**
     * @param App $app
     * @throws ZxzHttpException
     */
    public function loadEnv(App $app)
    {
        $env_path = $app->rootPath . DIRECTORY_SEPARATOR . '.env';
        if (!realpath($env_path)) {
            throw new ZxzHttpException(500, 'env not exist');
        }

        $env = parse_ini_file($env_path, true);
        $this->envParams = array_merge($_ENV, $env);
    }
}