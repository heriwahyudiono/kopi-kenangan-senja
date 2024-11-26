<?php
// session_start();
require_once __DIR__ . '/../models/OrderModel.php';

class OrderController {
    private $orderModel;

    public function __construct() {
        $this->orderModel = new OrderModel();
    }

    public function order() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $menu_id = $_POST['menu_id'];
            $orderer_name = $_POST['orderer_name'];
            $quantity = $_POST['quantity'];
            $table_number = $_POST['table_number'];
            $status = "waiting confirmation";

            if ($this->orderModel->order($menu_id, $orderer_name, $quantity, $table_number, $status)) {
                $_SESSION['message'] = ['type' => 'success', 'text' => 'Pesanan kamu lagi proses, ditunggu ya!'];
            }

            header("Location: ../orders.php");
            exit();
        }
    }

    public function getOrders() {
        return $this->orderModel->getOrders();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new OrderController();
    $controller->order();
}
