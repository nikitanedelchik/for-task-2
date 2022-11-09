<?php

namespace app\core;

use app\core\Controllers\Controller;

class Router
{
    public static array $list = [];

    public static function page($uri, $viewName)
    {
        self::$list[$uri] = $viewName;
    }

    public static function enable()
    {
        self::setRoutes();
        $path = Request::getPath();
        $init = self::$list[$path] ?? false;
        if ($init === false) {
            $view = new View();
            return $view->renderView('404');
        }
        if (is_string($init)) {
            return View::render($init);
        }
        return call_user_func($init);
    }

    private static function setRoutes()
    {
        Router::page('/', [new Controller(), 'upload']);
    }
}
