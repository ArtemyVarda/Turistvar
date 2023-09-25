<?php

namespace app\models;


use BaseModel as GlobalBaseModel;

class UserModel extends GlobalBaseModel
{
    public function addNewUser($name, $password, $username)
    {
        $password = password_hash($password, PASSWORD_DEFAULT);
        return $this->insert(
            "INSERT INTO users (name, password, username ) VALUES (:name,  :password, :username)",
            [
                'name' => $name,
                'password' => $password,
                'username' => $username

            ]
        );
    }
}
