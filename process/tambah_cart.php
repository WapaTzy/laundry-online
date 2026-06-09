<?php
session_start();
require '../config/koneksi.php';
require '../includes/auth.php';
cek_customer();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_layanan = (int)$_POST['id_layanan'];
    $jumlah     = (int)$_POST['jumlah'];

    if ($id_layanan > 0 && $jumlah > 0) {
        // Jika layanan sudah ada di keranjang, tambahkan jumlahnya
        if (isset($_SESSION['cart'][$id_layanan])) {
            $_SESSION['cart'][$id_layanan] += $jumlah;
        } else {
            $_SESSION['cart'][$id_layanan] = $jumlah;
        }
        echo "<script>alert('Layanan berhasil ditambahkan ke keranjang!'); window.location='../customer/dashboard.php';</script>";
    } else {
        echo "<script>alert('Data tidak valid!'); window.location='../customer/dashboard.php';</script>";
    }
} else {
    header("Location: ../customer/dashboard.php");
}
?>
