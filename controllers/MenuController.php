<?php
// session_start();
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
                $fileExtension = pathinfo($_FILES['menu_image']['name'], PATHINFO_EXTENSION);
                $fileName = uniqid() . '.' . $fileExtension;
                $targetFilePath = $targetDir . $fileName;
    
                move_uploaded_file($_FILES['menu_image']['tmp_name'], $targetFilePath);
    
                if ($this->model->addMenu($menuName, $description, $price, $fileName)) {
                    $_SESSION['message'] = ['type' => 'success', 'text' => 'Data menu berhasil ditambahkan'];
                } else {
                    $_SESSION['message'] = ['type' => 'error', 'text' => 'Terjadi kesalahan saat menambahkan data menu'];
                }
            }
            header("Location: ../views/admin/home.php");
            exit();
        }
    }    

    public function deleteMenu() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($this->model->deleteMenu($id)) {
                $_SESSION['message'] = ['type' => 'success', 'text' => 'Data menu berhasil dihapus'];
            } else {
                $_SESSION['message'] = ['type' => 'error', 'text' => 'Terjadi kesalahan saat menghapus data menu'];
            }
            header("Location: ../views/admin/home.php");
            exit();
        }
    }

    public function updateMenu() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id = $_POST['id'];
            $menuName = $_POST['menu_name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $menuImage = null;
    
            if (isset($_FILES['menu_image']) && $_FILES['menu_image']['error'] === UPLOAD_ERR_OK) {
                $targetDir = '../storage/images/';
                $fileName = uniqid() . '.' . pathinfo($_FILES['menu_image']['name'], PATHINFO_EXTENSION);
                $targetFilePath = $targetDir . $fileName;
    
                if (move_uploaded_file($_FILES['menu_image']['tmp_name'], $targetFilePath)) {
                    $menuImage = $fileName;
                }
            }
    
            if ($this->model->updateMenu($id, $menuName, $description, $price, $menuImage)) {
                $_SESSION['message'] = ['type' => 'success', 'text' => 'Menu berhasil diperbarui'];
            } else {
                $_SESSION['message'] = ['type' => 'error', 'text' => 'Terjadi kesalahan saat memperbarui menu'];
            }
    
            header("Location: ../views/admin/home.php");
            exit();
        }
    }    
}

$controller = new MenuController();

$controller->addMenu();
$controller->updateMenu();

if (isset($_GET['id'])) {
    $controller->deleteMenu();
}
?>
