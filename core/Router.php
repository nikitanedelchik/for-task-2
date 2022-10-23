<?php

namespace app\core;

use app\core\controllers\Controller;

class Router
{
	public static $list = [];

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
			return View::render('404');
		}
		if (is_string($init)) {
			return View::render($init);
		}
		return call_user_func($init);
	}

    private static function setRoutes()
    {
        Router::page('/', [new Controller(), 'home']);
        Router::page('/create', [new Controller(), 'create']);
        Router::page('/delete', [new Controller(), 'delete']);
        Router::page('/edit', [new Controller(), 'edit']);
    }
}
