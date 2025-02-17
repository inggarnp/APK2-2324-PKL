<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query  = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    $user   = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == 'admin') {
            header("Location: ../admin/index.php");
        } elseif ($user['role'] == 'siswa') {
            header("Location: ../siswa/index.php");
        } elseif ($user['role'] == 'pembimbing') {
            header("Location: ../pembimbing/index.php");
        } elseif ($user['role'] == 'penguji') {
            header("Location: ../penguji/index.php");
        } else {
            echo "Role tidak dikenali.";
        }
    } else {
        echo "Login gagal. Periksa kembali username dan password Anda.";
    }
}
?>
