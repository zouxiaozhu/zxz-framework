<?php
/**
 * Created by PhpStorm.
 * User: zhanglong
 * Date: 2018/12/11
 * Time: 2:15 PM
 */

namespace Framework\Router;

use App\Console\Kernel;
use Framework\Core\Router;

class Job
{
    public function router(Router $router)
    {
        $app = $router->app;
        $args = request()->server('argv');
        $router->action ='handle';
        $router->cli_params = array_slice($args, 2, sizeof($args) - 2);

        switch (sizeof($args)) {
            case 0:
//                $router->controller = Kernel::$commands[$args[1]];
                break;
            case 1:
                $router->controller = Kernel::$commands[$args[1] ?? 'welcome'] ?? '';
                break;
            default:
                $router->controller = Kernel::$commands[$args[1] ?? 'welcome'] ?? '';
                break;

        }

        if (!class_exists($router->controller)) {
            echo "class not exist"; die;
        }

    }
}