<?php

ini_set('error_log', 'errors');

require_once 'vendor/autoload.php';

use app\core\Application;

$app = new Application();

$app->run();


$id = '3734';
$url = 'https://gorest.co.in/public/v2/users';

$headers = [
//    "Accept: application/json",
    "Content-type: application/json",
    'Authorization: Bearer edb2763e46d2200c373588b0d0a39fb5b56c164c2c4ca95c93a24db0c9f1c9b2'
]; // создаем заголовки

$curl = curl_init(); // создаем экземпляр curl
$post_data = [
    'name' => 'Nikioss',
    'email' => 'nedelka999@gmail.com',
    'gender' => 'female',
    'status' => 'inactive'
];
$data_json = json_encode($post_data);
$ch = curl_init($url . '/' . $id);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($post_data));

$response = curl_exec($ch);

curl_close($ch);
var_dump($response);