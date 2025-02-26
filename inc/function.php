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

//fungsi register
//fungsi register
function registrasi($data) {
    global $KONEKSI;
    global $tgl;

    $id_user = stripslashes($data['id_user']);
    $nama = stripslashes($data['nama']); //untuk cek form register dari nama
    $email = strtolower(stripslashes($data['email'])); //memastikan form register mengirim input email berupa huruf kecil semua
    $password = mysqli_real_escape_string($KONEKSI, $data['password']);
    $password2 = mysqli_real_escape_string($KONEKSI, $data['password2']);


    //echo $nama."|".$email."|".$password."|".$password2;

    //cek email yang di input belum di database 

    $result = mysqli_query($KONEKSI, "SELECT email from tbl_users WHERE email='$email'");
    //var_dump($result);

    if (mysqli_fetch_assoc($result)) {
        echo "<script>
    alert('email yang anda input sudah ada di database.');
    </script>";
        return false;
    }

    //cek konfirmasi password 
    if ($password !==   $password2) {
        echo "<script>
    alert('konfirmasi password!! password tidak sesuai');
            document.location.href='register.php';
    </script>";
        return false;
    }

    //enkripsi password yang akan masukkan ke database 
    $password_hash = password_hash($password, PASSWORD_DEFAULT); // menggunakan algoritma dari hash 
    //var_dump($password_hash);

    //ambil id_tipe_user yg ada di tbl_tipe_user

    $tipe_user = "SELECT * FROM tbl_tipe_user WHERE tipe_user='Admin' ";
    $hasil = mysqli_query($KONEKSI, $tipe_user);
    $row = mysqli_fetch_assoc($hasil);
    $id = $row['id_tipe_user'];

    //tambahkan user baru ke tbl_users
    $sql_users = "INSERT INTO tbl_users SET 
    id_user = '$id_user',
    role = '$id',
    email = '$email',
    password = '$password_hash',
    create_at = '$tgl'";

    mysqli_query($KONEKSI, $sql_users) or die("gagal menambahkan user" . mysqli_error($KONEKSI));

    //tambahkan user baru ke tbl_admin
    $sql_admin  = "INSERT INTO tbl_admin SET
                    id_user = '$id_user',
                    nama_admin = '$nama',
                    create_at = '$tgl' ";

    mysqli_query($KONEKSI, $sql_admin) or die("gagal menambahkan user" . mysqli_error($KONEKSI));


    echo "<script>
        document.location.href='login.php';
        </script>";

    return mysqli_affected_rows($KONEKSI);
}

//fungsi login
function login($username, $password) {
    global $KONEKSI;

    $query = "SELECT u.id_user, u.password, t.nama_tipe 
              FROM tbl_users u
              JOIN tbl_tipe_user t ON u.id_tipe = t.id_tipe
              WHERE u.username = '$username'";

    $result = mysqli_query($KONEKSI, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            session_start();
            $_SESSION['user_id'] = $row['id_user'];
            $_SESSION['role'] = $row['nama_tipe'];
            return $row['nama_tipe'];
        }
    }
    return false;
}

// Fungsi untuk logout
function logout() {
    session_start();
    session_unset();
    session_destroy();
    header("Location: ../inc/login.php");
    exit;
}

