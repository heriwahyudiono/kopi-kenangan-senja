<?php
require_once __DIR__ . '/../config/connection.php';

class UserModel {
    private $conn;

    public function __construct() {
        $this->conn = (new Connection())->openConnection();
    }

    public function login($email, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                return $user;
            } else {
                return false; 
            }
        }
        return null; 
    }

    public function register($name, $email, $role, $password) {
        // Cek apakah email sudah terdaftar
        $stmt = $this->conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
    
        if ($stmt->num_rows > 0) {
            return false; // Email sudah terdaftar
        }
    
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    
        // Masukkan data ke database
        $stmt = $this->conn->prepare("INSERT INTO users (name, email, role, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $role, $hashedPassword);
        $stmt->execute();
    
        return $stmt->affected_rows > 0;
    }    
}
?>
