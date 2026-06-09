<?php
session_start();
require '../../config/koneksi.php';
require '../../includes/auth.php';
cek_admin();

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    $query = "DELETE FROM layanan WHERE id_layanan = '$id'";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Layanan berhasil dihapus!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus layanan! Layanan mungkin sedang digunakan dalam pesanan.'); window.location='index.php';</script>";
    }
} else {
    header("Location: index.php");
}
?>