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
                $_SESSION['message'] = [
                    'type' => 'error',
                    'text' => 'Konfirmasi password tidak sama'
                ];
                header("Location: ../views/auth/register.php");
                exit;
            }
    
            $result = $this->userModel->register($name, $email, $role, $password);
    
            $result = $this->userModel->register($name, $email, $role, $password);

            if ($result !== true) {
                $_SESSION['message'] = [
                    'type' => 'error',
                    'text' => 'Email sudah terdaftar'
                ];
                header("Location: ../views/auth/register.php");
            } else {
                header("Location: ../views/customer/home.php");
            }
            exit;            
        }
    }    
}

$controller = new RegisterController();
$controller->register();
?>
