<?php

namespace app\core\Controllers;

use app\core\Models\Model;
use app\core\Request;
use app\core\View;

class Controller
{
    private Model $model;
    private View $view;

    public function __construct()
    {
        $this->model = new Model();
        $this->view = new View();
    }

    public function upload()
    {
        $this->model->uploadFile(Request::getRequestParams());

        return $this->view->renderView('home', [
            'message' => $this->model->success ?: $this->model->errors[0],
            'size' => $this->model->size,
            'name' => $this->model->name,
            'type' => $this->model->type,
            'files' => $this->model->files
        ]);
    }
}
