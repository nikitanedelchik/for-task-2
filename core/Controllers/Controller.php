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
        $this->model->createUser();
        return View::render('create', [
            'model' => $this->model
        ]);
    }

    public function edit()
    {
        $this->model->editUser();
        return View::render('edit', [
            'model' => $this->model
        ]);
    }

    public function home()
    {
       $this->model->getAllUsers();
       return View::render('home', [
            'model' => $this->model
        ]);
    }

    public function delete()
    {
       $id = Request::getRequestParams()['id'] ?? false;
       if ($id) {
           $this->model->deleteUserById($id);
       }
        return View::render('home', [
            'model' => $this->model
        ]);
    }
}
