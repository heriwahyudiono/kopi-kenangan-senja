<?php
session_start();
require_once __DIR__ . '/../models/ChartModel.php';

class AddChartController
{
    private $chartModel;

    public function __construct()
    {
        $this->chartModel = new ChartModel();
    }

    public function addChart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $menu_id = $_POST['menu_id'];
            $menu_name = $_POST['menu_name'];
    
            if ($this->chartModel->addChart($menu_id)) {
                $_SESSION['message'] = ['type' => 'success', 'text' => "$menu_name ditambahkan ke keranjang"];
                header("Location: ../views/customer/charts.php");
                exit();
            } else {
                $_SESSION['message'] = ['type' => 'error', 'text' => "$menu_name sudah ada di keranjang"];
                header("Location: ../views/customer/home.php");
                exit();
            }
        }
    }    
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new AddChartController();
    $controller->addChart();
}