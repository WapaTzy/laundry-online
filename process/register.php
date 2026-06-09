<?php
session_start();
require '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mencegah SQL Injection sederhana
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = md5($_POST['password']); 
    $no_telp = mysqli_real_escape_string($conn, $_POST['no_telp']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

    // Cek apakah email sudah terdaftar sebelumnya
    $cek_email = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($cek_email) > 0) {
        echo "<script>alert('Email sudah terdaftar!'); window.location='../register.php';</script>";
    } else {
        // Default role untuk register mandiri adalah 'customer'
        $query = "INSERT INTO users (nama, email, password, role, no_telp, alamat) 
                  VALUES ('$nama', '$email', '$password', 'customer', '$no_telp', '$alamat')";
        
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location='../login.php';</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan sistem!'); window.location='../register.php';</script>";
        }
    }
}
?>