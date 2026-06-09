<?php
session_start();
require '../../config/koneksi.php';
require '../../includes/auth.php';
cek_admin();

if (isset($_GET['id'])) {
    $id_pesanan = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Update status pembayaran pesanan menjadi lunas
    $query = "UPDATE pesanan SET status_pembayaran = 'lunas' WHERE id_pesanan = '$id_pesanan'";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Bukti pembayaran berhasil diverifikasi! Status: LUNAS.'); window.location='detail.php?id=$id_pesanan';</script>";
    } else {
        echo "<script>alert('Gagal memverifikasi pembayaran!'); window.location='detail.php?id=$id_pesanan';</script>";
    }
} else {
    header("Location: index.php");
}
?>