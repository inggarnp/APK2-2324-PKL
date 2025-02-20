<?php
// Set waktu
date_default_timezone_set('Asia/Jakarta');
$tgl = date('Y-m-d H:i:s');   

// Koneksi database
$HOSTNAME = "localhost";
$DATABASE = "db_pengelolaan_pkl";
$USERNAME = "root";
$PASSWORD = "";

$KONEKSI = mysqli_connect($HOSTNAME, $USERNAME, $PASSWORD, $DATABASE);

if (!$KONEKSI) {
    die("Koneksi database error" . mysqli_connect_error());
}

// Fungsi untuk registrasi
function register($nama_lengkap, $email, $password, $role) {
    global $KONEKSI, $tgl;
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO tbl_users (nama_lengkap, email, password, role, created_at) VALUES ('$nama_lengkap', '$email', '$passwordHash', '$role', '$tgl')";
    return mysqli_query($KONEKSI, $query);
}

// Fungsi untuk login
function login($email, $password) {
    global $KONEKSI;
    session_start();
    $query = "SELECT * FROM tbl_users WHERE email = '$email'";
    $result = mysqli_query($KONEKSI, $query);
    
    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            $_SESSION['role'] = $user['role'];
            $_SESSION['folder'] = $user['role'];
            
            header("Location: ../" . $_SESSION['folder'] . "/index.php");
            exit;
        }
    }
    return false;
}

// Fungsi untuk memastikan user tetap di folder sesuai role
function check_access() {
    session_start();
    if (!isset($_SESSION['role'])) {
        header("Location: ../inc/login.php");
        exit;
    }
    
    $current_folder = basename(dirname($_SERVER['SCRIPT_NAME']));
    if ($current_folder !== $_SESSION['folder']) {
        header("Location: ../" . $_SESSION['folder'] . "/index.php");
        exit;
    }
}

// Fungsi untuk logout
function logout() {
    session_start();
    session_unset();
    session_destroy();
    header("Location: ../inc/login.php");
    exit;
}
