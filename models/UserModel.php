<?php
require_once __DIR__ . '/../config/connection.php';

class UserModel {
    private $conn;

    public function __construct() {
        $this->conn = (new Connection())->openConnection();
    }

    public function login($email) {
        $sql = "SELECT id, name, email, password, role FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc(); 
    }

    public function register($name, $email, $role, $password) {
        $stmt = $this->conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
    
        if ($stmt->num_rows > 0) {
            return false; 
        }
    
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    
        $stmt = $this->conn->prepare("INSERT INTO users (name, email, role, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $role, $hashedPassword);
        $stmt->execute();
    
        return $stmt->affected_rows > 0;
    }    
}
?>
