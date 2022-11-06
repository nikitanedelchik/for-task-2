<?php

namespace app\core;

class Logs
{
    public function createLog(string $message)
    {
        $today = date('dmY');
        $logDate = date('d-m-Y H:i:s');
        $root = $_SERVER['DOCUMENT_ROOT'];
        @mkdir("$root/logs", 0777);
        $fileName = "upload_$today";
        $log = <<<LOG

        [$logDate] $message
        ----------------------------------------
        LOG;
        file_put_contents("$root/logs/" . $fileName . '.log', $log . PHP_EOL, FILE_APPEND);
    }
}
