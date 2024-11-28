<?php
session_start();
require_once __DIR__ . '/../models/UserModel.php';

class RegisterController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $role = $_POST['role'] ?? 'customer'; 
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];
    
            if ($password !== $confirmPassword) {
                $_SESSION['message'] = 'Konfirmasi password tidak sama';
                $_SESSION['message_type'] = 'error';
                header("Location: ../views/auth/register.php");
                exit;
            }
    
            $result = $this->userModel->register($name, $email, $role, $password);
    
            if ($result === true) {
                $_SESSION['message'] = 'Registrasi berhasil';
                $_SESSION['message_type'] = 'success';
                header("Location: ../views/customer/home.php");
            } else {
                $_SESSION['message'] = 'Email sudah terdaftar';
                $_SESSION['message_type'] = 'error';
                header("Location: ../views/auth/register.php");
            }
            exit;
        }
    }    
}

$controller = new RegisterController();
$controller->register();
?>
