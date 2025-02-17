<?php
include 'koneksi.php'; // Path langsung ke folder inc/
include 'function.php'; // Memanggil fungsi registerUser

if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = $_POST['role']; // Pilihan role: admin, siswa, pembimbing, penguji

    // Validasi input tidak boleh kosong
    if (empty($username) || empty($password) || empty($role)) {
        echo "Semua field harus diisi!";
    } else {
        if (registerUser($username, $password, $role)) {
            echo "Pendaftaran berhasil! Silakan <a href='../index.php'>login</a>.";
        } else {
            echo "Pendaftaran gagal, coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <form action="" method="POST">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <select name="role">
            <option value="siswa">Siswa</option>
            <option value="pembimbing">Pembimbing</option>
            <option value="penguji">Penguji</option>
            <option value="admin">Admin</option>
        </select><br>
        <button type="submit" name="register">Register</button>
    </form>
</body>
</html>