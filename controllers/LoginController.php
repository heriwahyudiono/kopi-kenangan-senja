<?php
session_start();
require_once __DIR__ . '/../models/UserModel.php';

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            $user = $this->userModel->login($email);

            if (!$user) {
                $_SESSION['message'] = [
                    'type' => 'error',
                    'text' => 'Email tidak terdaftar'
                ];
                header("Location: ../index.php");
                exit;
            }

            if (!password_verify($password, $user['password'])) {
                $_SESSION['message'] = [
                    'type' => 'error',
                    'text' => 'Password salah'
                ];
                header("Location: ../index.php");
                exit;
            }

            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role'] 
            ];

            if ($user['role'] === 'admin') {
                header("Location: ../views/admin/home.php");
            } elseif ($user['role'] === 'customer') {
                header("Location: ../views/customer/home.php");
            } else {
                header("Location: ../index.php");
            }

            exit;
        }
    }
}

$controller = new UserController();
$controller->login();
