<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
</head>
<body>
    <h2>Selamat Datang, <?php echo $_SESSION['username']; ?> (Admin)</h2>
    <a href="../inc/logout.php">Logout</a>
</body>
</html>