<?php

namespace app\core\controllers;

use app\core\models\Model;
use app\core\Request;
use app\core\View;

class Controller
{
	private $model;

	public function __construct()
	{
		$this->model = new Model();
	}

	public function create()
	{
        $this->model->loadData(Request::getBody());
        return View::render('create', [
            'model' => $this->model
        ]);
	}

    public function edit()
    {
        if (Request::isGet()) {
            $this->model->getUserById(Request::getBody()['id']);
        }
        if (Request::isPost()) {
            $this->model->loadData(Request::getBody());
        }
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
		$id = Request::getBody()['id'] ?? false;
		if ($id) {
			$this->model->deleteUserById($id);
		}
		return View::render('reload');
	}
}
