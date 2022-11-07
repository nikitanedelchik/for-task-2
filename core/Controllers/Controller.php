<?php

namespace app\core\Controllers;

use app\core\Models\Model;
use app\core\Request;
use app\core\View;

class Controller
{
    private Model $model;

    public function __construct()
    {
        $this->model = new Model();
    }

    public function create()
    {
        $model = $this->model->createUser();
        return View::render('create', [
            'model' => $model
        ]);
    }

    public function edit()
    {
        $model = $this->model->editUser();
        return View::render('edit', [
            'model' => $model
        ]);
    }

    public function home()
    {
       $model = $this->model->getAllUsers();
       return View::render('home', [
            'model' => $model
        ]);
    }

    public function delete()
    {
       $id = Request::getRequestParams()['id'] ?? false;
       if ($id) {
           $model = $this->model->deleteUserById($id);
       }
        return View::render('home', [
            'model' => $model
        ]);
    }
}
