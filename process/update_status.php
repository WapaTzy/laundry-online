<?php
session_start();
require '../config/koneksi.php'; // Sesuaikan tingkat path jika ditaruh di dalam subfolder
require '../includes/auth.php';
cek_customer();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pesanan = mysqli_real_escape_string($conn, $_POST['id_pesanan']);
    $id_user = $_SESSION['id_user'];

    // Customer hanya boleh mengubah status menjadi 'diambil' jika status dari admin sudah 'selesai'
    $cek = mysqli_query($conn, "SELECT * FROM pesanan WHERE id_pesanan = '$id_pesanan' AND id_user = '$id_user' AND status = 'selesai'");
    
    if (mysqli_num_rows($cek) > 0) {
        $query = "UPDATE pesanan SET status = 'diambil' WHERE id_pesanan = '$id_pesanan'";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Terima kasih! Pesanan dinyatakan selesai.'); window.location='../customer/riwayat.php';</script>";
        } else {
            echo "<script>alert('Gagal memperbarui status transaksi.'); window.location='../customer/riwayat.php';</script>";
        }
    } else {
        echo "<script>alert('Aksi tidak valid atau cucian belum selesai dikerjakan admin!'); window.location='../customer/riwayat.php';</script>";
    }
} else {
    header("Location: ../customer/riwayat.php");
}
?>