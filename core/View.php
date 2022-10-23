<?php

namespace app\core;

class View
{
	public static function render($init, $params = [])
	{
		$main = self::getMainView();
		$need = self::getNeedView($init, $params);
		return str_replace('{{content}}', $need, $main);
	}

	private static function getMainView()
	{
		ob_start();
		include_once 'project/layouts/main.php';
		return ob_get_clean();
	}

	private static function getNeedView($view, $params)
	{
		foreach ($params as $key => $value) {
			$$key = $value;
		}
		ob_start();
		include_once "project/views/$view.php";
		return ob_get_clean();
	}
}
