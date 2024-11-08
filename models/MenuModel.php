<?php
require_once 'config/connection.php';

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
}
?>
