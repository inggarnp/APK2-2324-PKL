<?php 
session_start();
require_once 'function.php';
//cek session
if (@$_SESSION['email']) {
    if (@$_SESSION['level']=="Admin") { header("location:../admin/index.php"); } 
        elseif (@$_SESSION['level']=="Penguji") { header("location:../penguji/index.php"); } 
        elseif (@$_SESSION['level']=="Pembimbing") { header("location:../pembimbing/index.php"); }
        elseif (@$_SESSION['level']=="Siswa") { header("location:../siswa/index.php"); 
        }
        
    } 



//cek login 
//jika tombol sign in (login) di tekan maka akan mengirim variabel yang ada di form login yaitu usernamae (email) dan password 

if (isset($_POST['login'])) {
    $email = strtolower(stripslashes($_POST['email'])); // email yang di input oleh user
    $userpass = mysqli_real_escape_string($KONEKSI, $_POST['password']); // password yang di input oleh user

//lalu kita query ke database
$sql = mysqli_query($KONEKSI, "SELECT password, role FROM tbl_users WHERE email='$email' ");

list($paswd, $role) = mysqli_fetch_array($sql);

//echo $role;
//ambil level role/user  sedang login
$tipe_user = "SELECT * FROM tbl_tipe_user WHERE id_tipe_user='$role'";
$hasil = mysqli_query($KONEKSI, $tipe_user);
$row = mysqli_fetch_assoc($hasil);
$level = $row['tipe_user'];
//echo $level;

//jika data di temukan dalam database maka akan melakukan proses validasi dengan menggunakan password_verify
if (mysqli_num_rows($sql)>0) {
    /*jika ada data (>0) maka kita lakukan validasi
    $userpass ==> di ambil dari form input yang di lakukan oleh user
    $passwd ==> password yang ada di database dalam bentuk HASH
    */
    if (password_verify($userpass,$paswd )) {
        //akan kita buat session
        session_start();
        $_SESSION['email'] = $email;
        $_SESSION['level'] = $level;

        /*
        jika berhasil login, maka user akan kita arah kan ke halaman admin sesuai dengan level user 
        jika dia level admin ===> admin/index.php
        jika dia level petugas ===> petugas/index.php
        jika dia level penyewa ===> penyewa/index.php
        */

        if ($_SESSION['level']=="Admin") {
            header("location:../admin/index.php");
        } elseif ($_SESSION['level']=="Penguji") {
            header("location:../penguji/index.php");
        } elseif ($_SESSION['level']=="Pembimbing") {
            header("location:../pembimbing/index.php");
        } elseif ($_SESSION['level']=="Siswa") {
            header("location:../siswa/index.php");
        } 
        die();
    } else {
        echo '<script language="javascript">
                window.alert("LOGIN GAGAL!!!, harap isi email / password dengan benar.");
                window.document.location.href="login.php";
            </script>';
    }
} else {
    echo '<script language="javascript">
                window.alert("LOGIN GAGAL, email yang anda masukkan tidak di temukan.");
                window.document.location.href="login.php";
            </script>';
}

}
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-sidebar="dark" data-sidebar-size="lg" data-preloader="disable" data-theme="default" data-topbar="light" data-bs-theme="light">


    
<!-- Mirrored from themesbrand.com/steex/layouts/auth-signin.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Oct 2024 03:15:52 GMT -->
<head>

        <meta charset="utf-8">
        <title>Sign In | Steex - Admin & Dashboard Template</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Minimal Admin & Dashboard Template" name="description">
        <meta content="Themesbrand" name="author">
        <!-- App favicon -->
        <link rel="shortcut icon" href="../assets/images/favicon.ico">

        <!-- Fonts css load -->
        <link rel="preconnect" href="https://fonts.googleapis.com/">
        <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
        <link id="fontsLink" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet">

        <!-- Layout config Js -->
        <script src="../assets/js/layout.js"></script>
        <!-- Bootstrap Css -->
        <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <!-- Icons Css -->
        <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css">
        <!-- App Css-->
        <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css">
        <!-- custom Css-->
        <link href="../assets/css/custom.min.css" rel="stylesheet" type="text/css">

    </head>

    <body>


        <section class="auth-page-wrapper py-5 position-relative d-flex align-items-center justify-content-center min-vh-100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-11">
                        <div class="card mb-0">
                            <div class="row g-0 align-items-center">
                                <div class="col-xxl-5">
                                    <div class="card auth-card bg-secondary h-100 border-0 shadow-none d-none d-sm-block mb-0">
                                        <div class="card-body py-5 d-flex justify-content-between flex-column">
                                            <div class="text-center">
                                                <h3 class="text-white">Start your journey with us.</h3>
                                                <p class="text-white opacity-75 fs-base">It brings together your tasks, projects, timelines, files and more</p>
                                            </div>
                            
                                            <div class="auth-effect-main my-5 position-relative rounded-circle d-flex align-items-center justify-content-center mx-auto">
                                                <div class="effect-circle-1 position-relative mx-auto rounded-circle d-flex align-items-center justify-content-center">
                                                    <div class="effect-circle-2 position-relative mx-auto rounded-circle d-flex align-items-center justify-content-center">
                                                        <div class="effect-circle-3 mx-auto rounded-circle position-relative text-white fs-4xl d-flex align-items-center justify-content-center">
                                                            Welcome to <span class="text-primary ms-1">Steex</span>
                                                        </div>
                                                    </div>
                                                </div>      
                                                <ul class="auth-user-list list-unstyled">
                                                    <li>
                                                        <div class="avatar-sm d-inline-block">
                                                            <div class="avatar-title bg-white shadow-lg overflow-hidden rounded-circle">
                                                                <img src="../assets/images/users/avatar-1.jpg" alt="" class="img-fluid">
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="avatar-sm d-inline-block">
                                                            <div class="avatar-title bg-white shadow-lg overflow-hidden rounded-circle">
                                                                <img src="../assets/images/users/avatar-2.jpg" alt="" class="img-fluid">
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="avatar-sm d-inline-block">
                                                            <div class="avatar-title bg-white shadow-lg overflow-hidden rounded-circle">
                                                                <img src="../assets/images/users/avatar-3.jpg" alt="" class="img-fluid">
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="avatar-sm d-inline-block">
                                                            <div class="avatar-title bg-white shadow-lg overflow-hidden rounded-circle">
                                                                <img src="../assets/images/users/avatar-4.jpg" alt="" class="img-fluid">
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="avatar-sm d-inline-block">
                                                            <div class="avatar-title bg-white shadow-lg overflow-hidden rounded-circle">
                                                                <img src="../assets/images/users/avatar-5.jpg" alt="" class="img-fluid">
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                            
                                            <div class="text-center">
                                                <p class="text-white opacity-75 mb-0 mt-3">
                                                    &copy; <script>document.write(new Date().getFullYear())</script> Steex. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-xxl-6 mx-auto">
                                    <div class="card mb-0 border-0 shadow-none mb-0">
                                        <div class="card-body p-sm-5 m-lg-4">
                                            <div class="text-center mt-5">
                                                <h5 class="fs-3xl">Welcome Back</h5>
                                                <p class="text-muted">Sign in to continue to Steex.</p>
                                            </div>
                                            <div class="p-2 mt-5">
                                                <form method="post">
                                                <form action="https://themesbrand.com/steex/layouts/index.html">
                            
                                                    <div class="mb-3">
                                                        <label for="username" class="form-label">Username / Email<span class="text-danger">*</span></label>
                                                        <div class="position-relative ">
                                                            <input type="text" class="form-control  password-input" id="username" placeholder="Enter username" name="email" required>
                                                        </div>
                                                    </div>
                            
                                                    <div class="mb-3">
                                                        <div class="float-end">
                                                            <a href="auth-pass-reset.html" class="text-muted">Forgot password?</a>
                                                        </div>
                                                        <label class="form-label" for="password-input">Password <span class="text-danger">*</span></label>
                                                        <div class="position-relative auth-pass-inputgroup mb-3">
                                                            <input type="password" class="form-control pe-5 password-input " placeholder="Enter password" id="password-input" name="password" required>
                                                            <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                                        </div>
                                                    </div>

                                                    <!--<div class="mb-3">
                                                        <label for="inputTypeUser" class="">Type User</label>
                                                        <select class="form-select" id="inputTypeUser" name="type_user" onchange="tipeUser(this.value)" required>
                                                            <option value="">Select Type User...</option>
                                                            <option value="1">Admin</option>
                                                            <option value="2">Petugas</option>
                                                            <option value="3">Karyawan</option>
                                                            <option value="4">Owner</option>
                                                            <option value="5">Penyewa</option>
                                                        </select>
                                                    </div>

                                                    <div class="mb-3" id="x_branch" style="display: none;">
                                                        <label for="ddlbranch" class="">Cabang Apartement</label>
                                                        <select class="form-select" id="ddlbranch" name="branch" required>
                                                            <option selected disabled value="">Choose...</option>
                                                            <option selected="" disabled="" value="">Pilih Cabang...</option>
                                                            <option value="1">Cabang 1</option>
                                                            <option value="2">Cabang 2</option>
                                                            <option value="3">Cabang 3</option>
                                                        </select>
                                                    </div>-->
                            
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="auth-remember-check">
                                                        <label class="form-check-label" for="auth-remember-check">Remember me</label>
                                                    </div>
                            
                                                    <div class="mt-4">
                                                        <button class="btn btn-primary w-100" type="submit" name="login">Sign In</button>
                                                    </div>
                            
                                                    <div class="mt-4 pt-2 text-center">
                                                        <div class="signin-other-title position-relative">
                                                            <h5 class="fs-sm mb-4 title">Sign In with</h5>
                                                        </div>
                                                        <div class="pt-2 hstack gap-2 justify-content-center">
                                                            <button type="button" class="btn btn-subtle-primary btn-icon"><i class="ri-facebook-fill fs-lg"></i></button>
                                                            <button type="button" class="btn btn-subtle-danger btn-icon"><i class="ri-google-fill fs-lg"></i></button>
                                                            <button type="button" class="btn btn-subtle-dark btn-icon"><i class="ri-github-fill fs-lg"></i></button>
                                                            <button type="button" class="btn btn-subtle-info btn-icon"><i class="ri-twitter-fill fs-lg"></i></button>
                                                        </div>
                                                    </div>
                                                </form>
                                                </form>
                            
                                                <div class="text-center mt-5">
                                                    <p class="mb-0">Don't have an account ? <a href="register.php" class="fw-semibold text-secondary text-decoration-underline"> SignUp</a> </p>
                                                </div>
                                            </div>
                                        </div><!-- end card body -->
                                    </div><!-- end card -->
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </div>
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->
            </div>
            <!--end container-->
        </section>
        
        <!-- JAVASCRIPT -->
        <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/libs/simplebar/simplebar.min.js"></script>
        <script src="../assets/js/plugins.js"></script>
        

        
        <script src="../assets/js/pages/password-addon.init.js"></script>
        
        <!--Swiper slider js-->
        <script src="../assets/libs/swiper/swiper-bundle.min.js"></script>
        
        <!-- swiper.init js -->
        <script src="../assets/js/pages/swiper.init.js"></script>

<script type="text/javascript">
    function tipeUser(val) {
        var branchDiv = document.getElementById("x_branch");
        
        if (val === '1') { // When Admin is selected
            branchDiv.style.display = "block";
        } else { 
            branchDiv.style.display = "none";
        }
    }
</script>

    </body>


<!-- Mirrored from themesbrand.com/steex/layouts/auth-signin.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Oct 2024 03:15:57 GMT -->
</html>