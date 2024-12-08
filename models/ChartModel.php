<?php
require_once __DIR__ . '/../config/connection.php';

class ChartModel {
    private $conn;

    public function __construct() {
        $db = new Connection();
        $this->conn = $db->openConnection(); 
    }

    public function addChart($menu_id) {
        $checkSql = "SELECT COUNT(*) AS count FROM charts WHERE menu_id = ?";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->bind_param("i", $menu_id);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        $row = $result->fetch_assoc();

        if ($row['count'] > 0) {
            return false; 
        }

        $sql = "INSERT INTO charts (menu_id) VALUES (?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $menu_id);
        
        return $stmt->execute();
    }  

    public function getCharts() {
        $sql = "SELECT charts.id AS chart_id, 
                       menus.id AS menu_id, 
                       menus.menu_name, 
                       menus.menu_image, 
                       menus.description, 
                       menus.price 
                FROM charts
                INNER JOIN menus ON charts.menu_id = menus.id";

        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function deleteChart($chartId) {
        $sql = "DELETE FROM charts WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $chartId);
    
        return $stmt->execute();
    }    
}
?>
