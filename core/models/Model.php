<?php

namespace app\core\models;

use app\core\Database;

use app\core\Validate;

class Model
{
	private $connection;
    public $errors = [];
    public $success;
    public $name;
    public $email;
    public $gender;
    public $status;
    public $users;

    public function __construct()
	{
        $this->connection = Database::getConnection();
	}

    private function isSetEmail(): bool
    {
        $isSet = false;
        $sql = "SELECT email FROM `users`";
        $sth = $this->connection->prepare($sql);
        $sth->execute();
        $array = $sth->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($array as $email) {
            if ($email['email'] === $this->email) {
                $this->errors['email'] = 'User with this email is already exist!';
                $isSet = true;
            }
        }
        return $isSet;
    }

	public function createUser()
	{
        try {
            // проверка на существование пользователя с такой почтой
            if ($this->isSetEmail()) {
                return $this;
            }
            $sql = "INSERT INTO users (name, email, gender, status) VALUES (:name, :email, :gender, :status)";
			$statm = $this->connection->prepare($sql);
			$statm->bindParam(":name", $this->name);
			$statm->bindParam(":email", $this->email);
			$statm->bindParam(":gender", $this->gender);
			$statm->bindParam(":status", $this->status);
			$isOkey = $statm->execute();
			if ($isOkey > 0) {
				$create = true;
                $this->success = 'User was created';
			} else {
                $create = false;
			}
		} catch (\PDOException $e) {
			echo "DBError: " . $e->getMessage();
		}
		return $create;
	}

	public function getAllUsers()
	{
		try {
			$sql = "SELECT * FROM `users`";
			$sth = $this->connection->prepare($sql);
			$sth->execute();
			$array = $sth->fetchAll(\PDO::FETCH_ASSOC);
		} catch (\PDOException $exception) {
			echo '<div class="alert alert-danger">Something wrong</div>';
		}
		return $this->users = $array;
	}

	public function deleteUserById($id)
	{
		try {
			$sql = "DELETE FROM `users` WHERE id = $id";
			$stmt = $this->connection->exec($sql);
			if ($stmt) {
				$res = true;
			} else {
				$res = false;
			}
		} catch (\PDOException $e) {
			echo "Database error: " . $e->getMessage();
		}
		return $res;
	}

	public function editUserByEmail()
	{
		try {
			$sql = "UPDATE `users` SET name = :name, email = :email, gender = :gender, status = :status  WHERE email = :email";
			$stmt = $this->connection->prepare($sql);
			$stmt->bindParam(":name", $this->name);
			$stmt->bindParam(":email", $this->email);
			$stmt->bindParam(":gender", $this->gender);
			$stmt->bindParam(":status", $this->status);
			$isOkey = $stmt->execute();
            if ($isOkey) {
                $edit = true;
                $this->success = 'User was edited';
            } else {
                $edit = false;
            }
		} catch (\PDOException $e) {
			echo "Database error: " . $e->getMessage();
		}
		return $edit;
	}

	public function getUserById($id)
	{
		try {
			$sql = "SELECT * FROM `users` WHERE id = $id";
			$sth = $this->connection->prepare($sql);
			$isOkey = $sth->execute();
			$array = $sth->fetch(\PDO::FETCH_ASSOC);
            if ($isOkey) {
                $this->name = $array['name'];
                $this->email = $array['email'];
                $this->gender = $array['gender'];
                $this->status = $array['status'];
            }
		} catch (\PDOException $e) {
			echo "Database error: " . $e->getMessage();
		}
		return $isOkey;
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
            $this->editUserByEmail();
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
