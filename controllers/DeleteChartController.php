<?php
session_start();
require_once __DIR__ . '/../models/ChartModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['chart_id'])) {
    $chartId = $_POST['chart_id'];

    $chartModel = new ChartModel();
    if ($chartModel->deleteChart($chartId)) {
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Menu berhasil dihapus dari keranjang'];
    } else {
        $_SESSION['message'] = ['type' => 'error', 'text' => 'Gagal menghapus menu dari keranjang'];
    }
    header('Location: ../views/customer/charts.php');
    exit();
}
