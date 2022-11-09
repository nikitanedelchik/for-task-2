<?php

namespace app\core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class View
{
    private FilesystemLoader $loader;
    private Environment $view;

    public function __construct()
    {
        $this->loader = new FilesystemLoader('templates');
        $this->view = new Environment($this->loader);
    }

    public function renderView($page, $params = []) {
        $body = $this->view->render($page . '.twig', $params);
        return $body;
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
