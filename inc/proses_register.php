<?php
include 'koneksi.php';
include 'function.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = $_POST['role'];

    if (empty($username) || empty($password) || empty($role)) {
        echo "Semua field harus diisi!";
    } else {
        if (registerUser($username, $password, $role)) {
            echo "Pendaftaran berhasil! Silakan <a href='index.php'>login</a>.";
        } else {
            echo "Pendaftaran gagal, coba lagi.";
        }
    }
}
?>