<?php
session_start();
require_once __DIR__ . '/../models/MenuModel.php';

class MenuController {
    private $model;

    public function __construct() {
        $this->model = new MenuModel();
    }

    public function getMenus() {
        return $this->model->getMenus();
    }

    public function addMenu() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $menuName = $_POST['menu_name'];
            $description = $_POST['description'];
            $price = $_POST['price'];

            if (isset($_FILES['menu_image'])) {
                $targetDir = '../storage/images/';
                $fileName = basename($_FILES['menu_image']['name']);
                $targetFilePath = $targetDir . $fileName;

                move_uploaded_file($_FILES['menu_image']['tmp_name'], $targetFilePath);

                if ($this->model->addMenu($menuName, $description, $price, $fileName)) {
                    $_SESSION['message'] = ['type' => 'success', 'text' => 'Data menu berhasil ditambahkan'];
                } else {
                    $_SESSION['message'] = ['type' => 'error', 'text' => 'Terjadi kesalahan saat menambahkan data menu'];
                }
            }
            header("Location: ../views/home.php");
            exit();
        }
    }

    public function deleteMenu() {
        if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['menu_id'])) {
            $menuId = $_GET['menu_id'];
            if ($this->model->deleteMenu($menuId)) {
                $_SESSION['message'] = ['type' => 'success', 'text' => 'Menu berhasil dihapus'];
            } else {
                $_SESSION['message'] = ['type' => 'error', 'text' => 'Terjadi kesalahan saat menghapus menu'];
            }
        }
        header("Location: ../views/home.php");
        exit();
    }
}

$controller = new MenuController();

$controller = new MenuController();

if (isset($_GET['action'])) {
    if ($_GET['action'] === 'delete') {
        $controller->deleteMenu();
    }
} else {
    $controller->addMenu();
}
?>
