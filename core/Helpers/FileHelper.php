<?php

namespace app\core\Helpers;

use app\core\Logs;
use app\core\Models\Model;
use app\core\Request;
use app\core\Validate;

class FileHelper
{
    private Logs $log;
    private string $message;
    private Model $model;
    private array $files = [];
    const UPLOAD_DIR = "/uploads/";

    public function __construct()
    {
        $this->log = new Logs();
    }

    public function uploadFile(): array
    {
        $data = Request::getUploadedFileData();
        if (Request::isPost()) {

            $canLoad = $this->loadData($data['file']);
            if ($canLoad !== true) {
                return ['message' => $canLoad];
            }
            $name = $data['file']['name'];
            $type = $data['file']['type'];
            $size = $data['file']['size'];
            $tmpName = $data['file']['tmp_name'];
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . self::UPLOAD_DIR;
            @mkdir($uploadDir, 0777);
            move_uploaded_file($tmpName, $uploadDir . $this->setRandomName($type));

            $this->model = new Model($name, $size, $type);
            $this->message = 'The file is uploaded';
            $this->addLog();

        }

        return [
            'files' => $this->getFiles(),
            'file' => $this->model ?? ''
        ];
    }

    private function setRandomName($type): string
    {
        $addingType = explode('/', $type);
        $date = date('dmY_His');
        return uniqid($date . '_') . '.' . $addingType[1];
    }

    private function getFiles(): array
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

    private function loadData($data)
    {
        if (empty($data['name'])) {
            $this->message = 'Upload the file, please (file is not uploaded)';
            $this->addLog();
            return $this->message;
        }

        if ($data['error'] > 0) {
            $this->message = 'File is not uploaded. We have an error. Try Again.';
            $this->addLog();
            return $this->message;
        }

        return $this->isValid($data);
    }

    private function isValid($data)
    {
        return $this->validate($data);
    }

    private function validate($data)
    {
        if (Validate::checkSize($data['size']) !== true) {
            $this->message = Validate::checkSize($data['size']);
            $this->addLog();
            return $this->message;
        }

        if (Validate::checkType($data['type']) !== true) {
            $this->message = Validate::checkType($data['type']);
            $this->addLog();
            return $this->message;
        }

        return true;
    }

    private function addLog()
    {
        return $this->log->createLog($this->message);
    }
}
