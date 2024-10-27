<?php
require_once 'models/MenuModel.php';

class MenuController {
    private $model;

    public function __construct() {
        $this->model = new MenuModel();
    }

    public function getMenus() {
        return $this->model->getMenu();
    }
}
?>
