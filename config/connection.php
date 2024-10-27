<?php
class Connection {
    public function openConnection() {
        try {
            $conn = new mysqli('localhost', 'root', '', 'kenangan_senja');
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            return $conn;
        } catch (Exception $e) {
            die("Connection error: " . $e->getMessage());
        }
    }
}
?>
