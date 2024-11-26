<?php
require_once __DIR__ . '/../config/connection.php';

class OrderModel {
    private $conn;

    public function __construct() {
        $db = new Connection();
        $this->conn = $db->openConnection();
    }

    public function order($menu_id, $orderer_name, $quantity, $table_number, $status) {
        $sql = "INSERT INTO orders (menu_id, orderer_name, quantity, table_number, status) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("issss", $menu_id, $orderer_name, $quantity, $table_number, $status);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getOrders() {
        $sql = "
            SELECT 
                orders.id,
                orders.orderer_name,
                orders.quantity,
                orders.table_number,
                orders.status,
                menus.menu_name,
                menus.price
            FROM orders
            JOIN menus ON orders.menu_id = menus.id
            ORDER BY orders.created_at DESC
        ";

        $result = $this->conn->query($sql);
        $orders = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $orders[] = $row;
            }
        }

        return $orders;
    }
}
?>
