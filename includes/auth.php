<?php
// Fungsi untuk memastikan user sudah login
function cek_login() {
    if (!isset($_SESSION['id_user'])) {
        echo "<script>alert('Silakan login terlebih dahulu!'); window.location='../login.php';</script>";
        exit;
    }
}

// Fungsi pembatasan khusus halaman Admin
function cek_admin() {
    cek_login();
    if ($_SESSION['role'] !== 'admin') {
        echo "<script>alert('Akses Ditolak! Anda bukan admin.'); window.location='../index.php';</script>";
        exit;
    }
}

// Fungsi pembatasan khusus halaman Customer
function cek_customer() {
    cek_login();
    if ($_SESSION['role'] !== 'customer') {
        echo "<script>alert('Akses Ditolak! Halaman khusus pelanggan.'); window.location='../index.php';</script>";
        exit;
    }
}
?>