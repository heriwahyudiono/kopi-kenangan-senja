<?php
require_once '../models/UserModel.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $id = $_SESSION['user']['id']; 

    $userModel = new UserModel();
    $isUpdated = $userModel->updateUser($id, $name, $email);

    if ($isUpdated) {
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Profil berhasil diperbarui'];
    } else {
        $_SESSION['message'] = ['type' => 'error', 'text' => 'Terjadi kesalahan saat memperbarui profil'];
    }

    $user = $userModel->getUserById($id);

    $_SESSION['user'] = [
        'id' => $user['id'],
        'name' => $user['name'],
        'email' => $user['email']
    ];

    header("Location: ../views/profile.php");
    exit;
}
?>
