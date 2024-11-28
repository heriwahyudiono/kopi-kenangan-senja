<?php
require_once __DIR__ . '/../config/connection.php';

class OrderModel {
    private $conn;

    public function __construct() {
        $db = new Connection();
        $this->conn = $db->openConnection();
    }

    public function transaction($order_id) {
        $sql = "INSERT INTO transactions (order_id) VALUES (?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $order_id);
        
        return $stmt->execute();
    }    

    public function confirmOrder($order_id, $status) {
        $stmt = $this->conn->prepare("UPDATE orders SET status = ?, updated_at = NOW() WHERE id = ?");
        $stmt->bind_param("si", $status, $order_id);
        return $stmt->execute();
    }

    public function order($menu_id, $orderer_id, $orderer_name, $quantity, $table_number, $status) {
        $sql = "INSERT INTO orders (menu_id, orderer_id, orderer_name, quantity, table_number, status) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iissss", $menu_id, $orderer_id, $orderer_name, $quantity, $table_number, $status);

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
                orders.orderer_id,  -- Menambahkan orderer_id
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

    public function getOrderByUser($userId) {
        $sql = "
            SELECT 
                orders.id,
                orders.orderer_id,
                orders.orderer_name,
                orders.quantity,
                orders.table_number,
                orders.status,
                menus.menu_name,
                menus.price
            FROM orders
            JOIN menus ON orders.menu_id = menus.id
            WHERE orders.orderer_id = ?
            ORDER BY orders.created_at DESC
        ";
    
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userId); // Binding userId ke query
        $stmt->execute();
        $result = $stmt->get_result();
    
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
