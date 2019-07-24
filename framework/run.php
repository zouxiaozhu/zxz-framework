<?php
/**
 * Created by PhpStorm.
 * User: zouxiaozhu
 * Date: 18-3-11
 * Time: 下午10:38
 */

// 引入框架文件
require_once(__DIR__ . DIRECTORY_SEPARATOR . 'App.php');
try {

    $app = new Framework\App(realpath(__DIR__ . '/..'), function () {
        return require(__DIR__ . '/Load.php');
    });

    $app->load(function () {
        return new \Framework\Handlers\EnvHandler();
    });

    $app->load(function () {
        return new \Framework\Handlers\ConfigHandler();
    });

    $app->load(function () {
        // 加载日志处理机制 Loading log handle
        return new \Framework\Handlers\LogHandler();
    });

    $app->load(function () {
        // 加载中间价
        return new \Framework\Handlers\MiddlewareHandler();
    });

    $app->load(function () {
        return new \Framework\Handlers\ModelHandler();

    });

    $app->load(function () {
        // 加载路由机制 Loading route handle

        return new \Framework\Handlers\ReportHandler();
    });

    $app->load(function () {
        // 加载路由机制 Loading route handle

        return new \Framework\Handlers\RouterHandler();
    });

    /**
     * 启动应用
     *
     * Start framework
     */
    $app->run(function () use ($app) {

        return new \Framework\Request($app);
    });

    //var_export(\Framework\App::$container);die;

    /**
     * 响应结果
     *
     * Reponse
     *
     * 应用生命周期结束
     *
     * End
     */

    $app->response(function () {
        return new \Framework\Response();
    });

} catch (\Framework\Exceptions\ZxzApiException $e) {
    zxzLogExp($e);
    $e->response();
} catch (\Framework\Exceptions\ZxzHttpException $e) {
    zxzLogExp($e);
    $e->response();
} catch (Exception $e) {
    $data = [
        'code' => $e->getCode(),
        'status' => false,
        'msg' => $e->getMessage(),
        'result' => [
            'error_line' => $e->getLine(),
            'trace' => $e->getTrace()
        ]
    ];

    echo json_encode($data);die;
}

