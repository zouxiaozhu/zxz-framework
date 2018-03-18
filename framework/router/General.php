<?php

namespace Framework\Router;

use Framework\Core\Router;

class General{
    public function router(Router $router)
    {
        $app = $router->app;
        $request = $app::$container->getSingle('request');

        $moduleName = $request->request('module');
        var_export($moduleName);die;
    }
}