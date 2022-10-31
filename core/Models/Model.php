<?php

namespace app\core\Models;

use app\core\Logs;
use app\core\Request;
use app\core\Validate;

class Model
{
    public array $errors = [];
    public array $files = [];
    public $success;
    public $size;
    public $type;
    public $name;
    public $tmpName;
    private Logs $log;

    public function __construct()
    {
        $this->log = new Logs();
    }

    public function uploadFile($data)
    {
        $this->files = $this->getFiles();
        if (Request::isPost()) {
            $canLoad = $this->loadData($data['file']);
            if ($canLoad !== true) {
                return $this;
            }

            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/uploads";
            @mkdir($uploadDir, 0755);
            move_uploaded_file($this->tmpName, $uploadDir . '/' .  $this->name);
            $this->success = 'The file is uploaded';

            $this->addLog();
        }
        return $this;
    }

    public function loadData($data)
    {
        if (empty($data['name'])) {
            $this->errors[] = 'Upload the file, please';
            $this->addLog();
            return $this->errors[0];
        }

        if ($data['error'] > 0) {
            $this->errors[] = 'We have an error. Try Again.';
            $this->addLog();
            return $this;
        }

        $this->name = $data['name'];
        $this->size = $data['size'];
        $this->type = $data['type'];
        $this->tmpName = $data['tmp_name'];

        return $this->isValid();
    }

    public function isValid(): bool
    {
        return empty($this->errors) && $this->validate();
    }

    private function validate(): bool
    {
        $valid = true;
        if (Validate::checkSize($this->size) !== true) {
            $this->errors[] = Validate::checkSize($this->size);
            $valid = false;
        }

        if (Validate::checkType($this->type) !== true) {
            $this->errors[] = Validate::checkType($this->type);
            $valid = false;
        }

        if (!$valid) {
            $this->addLog();
        }

        return $valid;
    }

    private function addLog()
    {
        return $this->log->createLog($this);
    }

    public function successMessage()
    {
        return $this->success;
    }

    private function getFiles()
    {
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/uploads";
        $handle = opendir($uploadDir);
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != "..") {
                $this->files[] = $file;
            }
        }

        return $this->files;
    }
}
