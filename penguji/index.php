<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'penguji') {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Penguji</title>
</head>
<body>
    <h2>Selamat Datang, <?php echo $_SESSION['username']; ?> (Penguji)</h2>
    <a href="../inc/logout.php">Logout</a>
</body>
</html>