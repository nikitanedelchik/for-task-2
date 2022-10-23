<?php

namespace app\core\models;

use app\core\GoRest;
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
    /**
     * @var mixed
     */
    public $id;

    public function __construct()
    {
        $this->gorest = new GoRest();
    }

    public function createUser()
	{
        $res = $this->gorest->createUser($this->name, $this->email, $this->gender, $this->status);
        if (isset($res[0]['message'])) {
            $this->errors[$res[0]['field']] = $res[0]['message'];
            $create = false;
        } else {
            $create = true;
            $this->success = 'User was created';
        }

		return $create;
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

	public function editUser()
	{
        $result = $this->gorest->editUser($this->id, $this->name, $this->email, $this->gender, $this->status);
        if (isset($result[0]['message'])) {
            $this->errors[$result[0]['field']] = $result[0]['message'];
            $edit = false;
        } else {
            $edit = true;
            $this->success = 'User was edited';
        }

		return $edit;
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

    public function loadData($data)
    {
        foreach ($data as $field => $value) {
            if (empty($value)) {
                $this->errors[$field] = "Field $field is required";
            }
            switch ($field) {
                case 'name':
                    $this->name = $value;
                    break;
                case 'email':
                    $this->email = $value;
                    break;
                case 'gender':
                    $this->gender = $value;
                    break;
                case 'status':
                    $this->status = $value;
                    break;
            }
        }

        if (isset($data['create']) && $this->isValid()) {
            $this->createUser();
        } elseif (isset($data['edit']) && $this->isValid()) {
            $this->editUser();
        }
    }

    public function getMessage($param)
    {
        return $this->errors[$param];
    }

    public function hasError($param)
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
        return $valid;
    }

    public function successMessage()
    {
        return $this->success;
    }
}
