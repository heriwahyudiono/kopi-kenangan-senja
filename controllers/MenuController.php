<?php
// Memanggil model menu
require_once '../models/MenuModel.php';

class MenuController {
    private $model;

    public function __construct() {
        // Membuat objek baru dari kelas MenuModel
        $model = new MenuModel();
    }

    // Fungsi untuk mengambil menu dari MenuModel
    public function getMenus() {
        // Mengembalikan hasil menu dari fungsi getMenus
        return $this->model->getMenus();
    }
}
?>