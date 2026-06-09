<?php
session_start();
require '../config/koneksi.php';
require '../includes/auth.php';
cek_customer();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_SESSION['cart'])) {
        header("Location: ../customer/keranjang.php");
        exit;
    }

    $id_user = $_SESSION['id_user'];
    $total_harga = (float)$_POST['total_harga'];
    
    // 1. Simpan data ke tabel pesanan utama
    $query_pesanan = "INSERT INTO pesanan (id_user, total_harga, status, status_pembayaran) 
                      VALUES ('$id_user', '$total_harga', 'pending', 'belum')";
    
    if (mysqli_query($conn, $query_pesanan)) {
        // Ambil ID pesanan yang baru saja dibuat
        $id_pesanan = mysqli_insert_id($conn);
        
        // 2. Simpan setiap item di keranjang ke tabel detail_pesanan
        foreach ($_SESSION['cart'] as $id_layanan => $jumlah) {
            // Ambil harga layanan untuk subtotal
            $q_layanan = mysqli_query($conn, "SELECT harga FROM layanan WHERE id_layanan = '$id_layanan'");
            $data_layanan = mysqli_fetch_assoc($q_layanan);
            $subtotal = $data_layanan['harga'] * $jumlah;
            
            $query_detail = "INSERT INTO detail_pesanan (id_pesanan, id_layanan, jumlah, subtotal) 
                             VALUES ('$id_pesanan', '$id_layanan', '$jumlah', '$subtotal')";
            mysqli_query($conn, $query_detail);
        }
        
        // 3. Kosongkan keranjang setelah berhasil checkout
        unset($_SESSION['cart']);
        
        echo "<script>alert('Checkout berhasil! Silakan upload bukti pembayaran.'); window.location='../customer/riwayat.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat memproses pesanan.'); window.location='../customer/keranjang.php';</script>";
    }
} else {
    header("Location: ../customer/keranjang.php");
}
?>
