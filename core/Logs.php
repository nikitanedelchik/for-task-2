<?php

namespace app\core;

use app\core\models\Model;

class Logs
{
    public function createLog(Model $model)
    {
        $today = date('dmY');
        $logDate = date('d-m-Y H:i:s');
        $root = $_SERVER['DOCUMENT_ROOT'];
        $isUpload = $model->success ?: "File is not uploaded because " . $model->errors[0];
        @mkdir("$root/logs", 0777);
        $fileName = "upload_$today";
        $log = <<<LOG

        [$logDate] $isUpload
        ----------------------------------------
        LOG;
        file_put_contents("$root/logs/" . $fileName . '.log', $log . PHP_EOL, FILE_APPEND);
    }
}
