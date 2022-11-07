<?php

namespace app\core\Models;

use app\core\GoRest;
use app\core\Request;
use app\core\Validate;

class Model
{
    public $errors = [];
    public $success;
    public $name;
    public $email;
    public $gender;
    public $status;
    public $users;
    private $gorest;
    public $id;

    public function __construct()
    {
        $this->gorest = new GoRest();
    }

    public function createUser(): Model
    {
        $params = Request::getRequestParams();
        if ($params['create'] === "go") {
            $this->name = $params['name'];
            $this->email = $params['email'];
            $this->gender = $params['gender'];
            $this->status = $params['status'];

            if ($this->isValid()) {
                $res = $this->gorest->createUser($this->name, $this->email, $this->gender, $this->status);
                if (isset($res[0]['message'])) {
                    $this->errors[$res[0]['field']] = $res[0]['message'];
                } else {
                    $this->success = 'User was created';
                }
            }
        }

        return $this;
    }

    public function getAllUsers()
    {
        $this->users = $this->gorest->getAll();
        return $this->users;
    }

    public function deleteUserById($id)
    {
       $this->gorest->deleteUser($id);

        return $this->getAllUsers();
    }

    public function editUser(): Model
    {
        $params = Request::getRequestParams();
        if (Request::isGet()) {
            $this->getUserById($params['id']);
        } elseif (Request::isPost()) {
            $this->name = $params['name'];
            $this->email = $params['email'];
            $this->gender = $params['gender'];
            $this->status = $params['status'];

            if ($this->isValid()) {
                $result = $this->gorest->editUser($this->id, $this->name, $this->email, $this->gender, $this->status);
                if (isset($result[0]['message'])) {
                    $this->errors[$result[0]['field']] = $result[0]['message'];
                } else {
                    $this->success = 'User was edited';
                }
            }
        }

       return $this;
    }

    public function getUserById($id)
    {
        $user = $this->gorest->getUser($id);
        $this->id = $user['id'];
        $this->name = $user['name'];
        $this->email = $user['email'];
        $this->gender = $user['gender'];
        $this->status = $user['status'];
    }

    public function getMessage($param)
    {
        return $this->errors[$param];
    }

    public function hasError($param): bool
    {
        return isset($this->errors[$param]);
    }

    public function isValid(): bool
    {
        return empty($this->errors) && $this->validate();
    }

    private function validate(): bool
    {
        $valid = true;
        if (!Validate::isNameValid($this->name)) {
            $this->errors['name'] = "The field name is invalid";
            $valid = false;
        }
        if (!Validate::isEmailValid($this->email)) {
            $this->errors['email'] = "The field email is invalid";
            $valid = false;
        }
        $this->name ?: $this->errors['name'] = "Field name is required";
        $this->email ?: $this->errors['email'] = "Field email is required";
        $this->gender ?: $this->errors['gender'] = "Field gender is required";
        $this->status ?: $this->errors['status'] = "Field status is required";

        return $valid;
    }

    public function successMessage()
    {
        return $this->success;
    }
}
