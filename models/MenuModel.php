<?php
// Memanggil koneksi ke databases
require_once '../config/connection.php';

class MenuModel {
    // Membuat properti koneksi  
    private $conn;

    // Constructor: Fungsi atau method yang otomatis dipanggil ketika membuat object dari sebuah kelas
    public function __construct() {
        // Membuat objek baru dari kelas Connection
        $db = new Connection();
        // Memanggil propeerti koneksi
        $this->conn = $db->openConnection();
    }  
    
    // Fungsi untuk mengambil menu
    public function getMenus() {
        // Query untuk mengambil menu
        $sql = "SELECT id, menu_name, menu_image, price, description FROM menus";
        // Mengembalikan hasil query
        $result = $this->conn->query($sql);
        // Isi variabel $menus dengan array kosong sementara
        $menus = [];

        // Jika hasil lebih dari 0
        if ($result->num_rows > 0) {
            // Ketika baris di isi dengan hasil array asosiatif
            while ($row = $result->fetch_assoc()) {
                // Maka array kosong menus di isi dengan baris atau row
                $menus[] = $row;
            }
        }
        // Mengembalikan hasil
        return $menus;
    }
}
?>