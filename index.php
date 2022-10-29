<?php

ini_set('error_log', 'errors');

require_once 'vendor/autoload.php';

use app\core\Application;

$app = new Application();

$app->run();
