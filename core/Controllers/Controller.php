<?php

namespace app\core\Controllers;

use app\core\Helpers\FileHelper;
use app\core\View;

class Controller
{
    private FileHelper $helper;
    private View $view;

    public function __construct()
    {
        $this->helper = new FileHelper();
        $this->view = new View();
    }

    public function upload(): string
    {
        $data = $this->helper->uploadFile();
        return $this->view->renderView('home', [
            'file' => $data['file'],
            'files' => $data['files'],
            'message' => $data['message']
        ]);
    }
}
