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
            $role = $_POST['role'] ?? 'user'; // Default role: user
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];
    
            // Validasi input
            if (empty($name) || empty($email) || empty($password)) {
                $_SESSION['message'] = 'Semua field wajib diisi';
                $_SESSION['message_type'] = 'error';
                header("Location: ../views/register.php");
                exit;
            }
    
            if ($password !== $confirmPassword) {
                $_SESSION['message'] = 'Password tidak cocok';
                $_SESSION['message_type'] = 'error';
                header("Location: ../views/register.php");
                exit;
            }
    
            // Panggil fungsi register dari model
            $result = $this->userModel->register($name, $email, $role, $password);
    
            if ($result === true) {
                $_SESSION['message'] = 'Registrasi berhasil';
                $_SESSION['message_type'] = 'success';
                header("Location: ../views/customer/home.php");
            } else {
                $_SESSION['message'] = 'Email sudah terdaftar';
                $_SESSION['message_type'] = 'error';
                header("Location: ../views/register.php");
            }
            exit;
        }
    }    
}

$controller = new RegisterController();
$controller->register();
?>
