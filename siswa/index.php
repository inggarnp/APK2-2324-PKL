<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'siswa') {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Siswa</title>
</head>
<body>
    <h2>Selamat Datang, <?php echo $_SESSION['username']; ?> (Siswa)</h2>
    <a href="../inc/logout.php">Logout</a>
</body>
</html>