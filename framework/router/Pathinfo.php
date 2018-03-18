<?php
namespace Framework\Router;
use Framework\Core\Router;
class Pathinfo{

    public function router(Router $router)
    {
        $uri = $router->requestUri;

        if(strpos($uri, '?')){
            preg_match_all('/\/(.*)\?/', $uri,$matches);
        }else{
            preg_match_all('/\/(.*)/', $uri, $matches);
        }


        if(!isset($matches[1][0]) || empty($matches[1][0])){
            // CLI 模式不输出
//            if ($entrance->app->runningMode === 'cli') {
//                $entrance->app->notOutput = true;
//            }
//            return;
        }

        /* 自定义路由怕断 */
        $matches = explode('/', $matches[1][0]);

        switch (sizeof($matches)){
            case 3:
                $router->module = $matches[0];
                $router->controller = $matches[1];
                $router->action = $matches[2];
                break;
            case 2:
                $router->controller = $matches[0];
                $router->action = $matches[1];
                break;
            case 1:
                $router->action = $matches[0];
                break;
            default:
                break;
        }

    }
}