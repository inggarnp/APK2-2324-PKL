<?php
include 'koneksi.php'; // Pastikan path benar, karena file ini ada di dalam folder inc/

function registerUser($username, $password, $role) {
    global $conn;

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $username, $hashed_password, $role);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}
?>