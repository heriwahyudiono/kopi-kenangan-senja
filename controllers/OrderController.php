<?php
// session_start();
require_once __DIR__ . '/../models/OrderModel.php';

class OrderController
{
    private $orderModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
    }

    public function order()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $menu_id = $_POST['menu_id'];
            $orderer_id = $_POST['orderer_id'];
            $orderer_name = $_POST['orderer_name'];
            $quantity = $_POST['quantity'];
            $table_number = $_POST['table_number'];
            $status = "waiting confirmation";

            if ($this->orderModel->order($menu_id, $orderer_id, $orderer_name, $quantity, $table_number, $status)) {
                $_SESSION['message'] = ['type' => 'success', 'text' => 'Pesanan kamu lagi proses, ditunggu ya!'];
            }

            header("Location: ../orders.php");
            exit();
        }
    }

    public function confirmOrder()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $order_id = $_POST['order_id'];
            $status = $_POST['status'];

            if ($status === "process") {
                $this->orderModel->transaction($order_id);
            }

            if ($this->orderModel->confirmOrder($order_id, $status)) {
                $_SESSION['message'] = ['type' => 'success', 'text' => 'Status pesanan diperbarui'];
            } else {
                $_SESSION['message'] = ['type' => 'error', 'text' => 'Gagal memperbarui status pesanan'];
            }

            header("Location: ../views/orders.php");
            exit();
        }
    }

    public function getOrders()
    {
        return $this->orderModel->getOrders();
    }

    public function getOrderByUser() {
        // Mengambil ID user yang sedang login
        if (isset($_SESSION['user'])) {
            $userId = $_SESSION['user']['id'];
            // Memanggil fungsi getOrders dari model dan mengirimkan userId
            $orders = $this->orderModel->getOrderByUser($userId);
            return $orders;
        } else {
            // Jika user tidak login, kembalikan array kosong atau bisa redirect
            header("Location: ../index.php");
            exit();
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new OrderController();
    $controller->order();
    $controller->confirmOrder();
}