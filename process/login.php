<?php
session_start();
require '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = md5($_POST['password']);

    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND password='$password'");

    if (mysqli_num_rows($query) == 1) {
        $user = mysqli_fetch_assoc($query);
        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['nama']    = $user['nama'];
        $_SESSION['role']    = $user['role'];

        if ($user['role'] == 'admin') {
            header("Location: ../admin/index.php");
        } else {
            header("Location: ../customer/dashboard.php");
        }
        exit;
    } else {
        echo "<script>alert('Email atau password salah!'); window.location='../login.php';</script>";
    }
} else {
    header("Location: ../login.php");
}
?>
