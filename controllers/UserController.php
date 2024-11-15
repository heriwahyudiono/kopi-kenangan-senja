<?php
session_start();
require_once __DIR__ . '/../models/UserModel.php';

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->userModel->login($email, $password);

            if ($user === null) {
                $_SESSION['message'] = 'Email tidak terdaftar';
                $_SESSION['message_type'] = 'error';
                header("Location: ../index.php");
                exit;
            } elseif ($user === false) {
                $_SESSION['message'] = 'Password salah';
                $_SESSION['message_type'] = 'error';
                header("Location: ../index.php");
                exit;
            } else {
                $_SESSION['user'] = $user; 
                header("Location: ../views/home.php"); 
                exit;
            }
        }
    }
}

$controller = new UserController();
$controller->login();
?>
