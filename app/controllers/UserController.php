<?php

namespace app\controller;

use app\core\InitController;
use app\lib\UserOperation;
use app\models\UserModel;

class UserController extends InitController
{
    public function behaviors()
    {
        return [
            'access' => [
                'rules' => [
                    [
                        'actions' => ['login', 'registration'],
                        'roles' => [UserOperation::RoleGuest],
                        'matchCallback' => function () {
                            $this->redirect('/user/auth');
                        }
                    ],
                    [
                        'actions' => ['profile'],
                        'roles' => [UserOperation::RoleUser, UserOperation::RoleAdmin],
                        'matchCallback' => function () {
                            $this->redirect('/user/auth');
                        }
                    ],
                    [
                        'action' => [],
                        'roles' => [UserOperation::RoleAdmin],
                        'matchCallback' => function () {
                            $this->redirect('/user/profile');
                        }
                    ]
                ]
            ]
        ];
    }

    public function actionRegistration()
    {
        $this->view->title = 'Регистрация';
        $error_message = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['btn_reg'])) {
            $username = !empty($_POST['name']) ? $_POST['name'] : null;
            $password = !empty($_POST['password']) ? $_POST['password'] : null;
            $login = !empty($_POST['username']) ? $_POST['username'] : null;
            $repite_password = !empty($_POST['repite_password']) ? $_POST['repite_password'] : null;
            if (empty($username)) {
                $error_message .= 'Введите ваше имя<br>';
            }
            if (empty($login)) {
                $error_message .= 'Введите ваше логин<br>';
            }
            if (empty($password)) {
                $error_message .= 'Введите  пароль<br>';
            }
            if (empty($confirm_password)) {
                $error_message .= 'Введите повторно пароль <br>';
            }
            if ($password != $repite_password) {
                $error_message .= 'пароли не совподают<br>';
            }
            if (empty($error_message)) {
                $userModel = new UserModel();
                $user_id = $userModel->addNewUser($username, $login, $password);
                if (!empty($user_id)) {
                    $this->redirect('/user/profile');
                }
            }
        }
    }
}
