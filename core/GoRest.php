<?php

namespace app\core;

class GoRest
{
    private $url = 'https://gorest.co.in/public/v2/users';
    private $headers = ["Accept: application/json", "Authorization: Bearer edb2763e46d2200c373588b0d0a39fb5b56c164c2c4ca95c93a24db0c9f1c9b2"];
    public function getAll()
    {
        $curl = curl_init(); // создаем экземпляр curl

        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt($curl, CURLOPT_POST, false); //
        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl,  CURLOPT_CUSTOMREQUEST, 'GET');
        $result = curl_exec($curl);
        curl_close($curl);
        return json_decode($result, true);
    }

    public function createUser($name, $email, $gender, $status)
    {
        $curl = curl_init(); // создаем экземпляр curl
        $post_data = [
            'name' => $name,
            'email' => $email,
            'gender' => $gender,
            'status' => $status
        ];
        $data_json = json_encode($post_data);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($curl, CURLOPT_POST, true); //
        curl_setopt($curl, CURLOPT_URL, $this->url);
        $result = curl_exec($curl);
        curl_close($curl);
        return json_decode($result, true);
    }

    public function deleteUser($id)
    {
        $curl = curl_init(); // создаем экземпляр curl

        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt($curl, CURLOPT_POST, false); //
        curl_setopt($curl, CURLOPT_URL, $this->url . '/' . $id);
        curl_setopt($curl,  CURLOPT_CUSTOMREQUEST, 'DELETE');
        $result = curl_exec($curl);
        curl_close($curl);
        return json_decode($result, true);
    }

    public function getUser($id)
    {
        $curl = curl_init(); // создаем экземпляр curl

        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt($curl, CURLOPT_POST, false); //
        curl_setopt($curl, CURLOPT_URL, $this->url . '/' . $id);
        curl_setopt($curl,  CURLOPT_CUSTOMREQUEST, 'GET');
        $result = curl_exec($curl);
        curl_close($curl);
        return json_decode($result, true);
    }

    public function editUser($id, $name, $email, $gender, $status)
    {
        $post_data = [
            'name' => $name,
            'email' => $email,
            'gender' => $gender,
            'status' => $status
        ];

        $curl = curl_init($this->url . '/' . $id);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post_data));
        $result = curl_exec($curl);
        curl_close($curl);
        return json_decode($result, true);
    }
}