<?php
require_once __DIR__ . '/../config/connection.php';

class MenuModel {
    private $conn;

    public function __construct() {
        $db = new Connection();
        $this->conn = $db->openConnection();
    }

    public function getMenus() {
        $sql = "SELECT id, menu_name, menu_image, description, price FROM menus";
        $result = $this->conn->query($sql);
        $menus = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $menus[] = $row;
            }
        }
        return $menus;
    }

    public function addMenu($menuName, $description, $price, $menuImage) {
        $sql = "INSERT INTO menus (menu_name, menu_image, description, price) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssd", $menuName, $menuImage, $description, $price);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteMenu($id) {
        $sql = "SELECT menu_image FROM menus WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($menuImage);
        $stmt->fetch();
        $stmt->close();
    
        $sql = "DELETE FROM menus WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
    
        if ($stmt->execute()) {
            $filePath = "../storage/images/" . $menuImage;
            if (file_exists($filePath)) {
                unlink($filePath); 
            }
            return true;
        } else {
            return false;
        }
    }       
}
?>
