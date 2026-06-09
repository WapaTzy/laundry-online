<?php
session_start();
require '../../config/koneksi.php';
require '../../includes/auth.php';
cek_admin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pesanan = mysqli_real_escape_string($conn, $_POST['id_pesanan']);
    $status     = mysqli_real_escape_string($conn, $_POST['status']);

    // Validasi nilai status yang diperbolehkan
    $allowed = ['pending', 'proses', 'selesai'];
    if (!in_array($status, $allowed)) {
        echo "<script>alert('Status tidak valid!'); window.location='index.php';</script>";
        exit;
    }

    $query = "UPDATE pesanan SET status = '$status' WHERE id_pesanan = '$id_pesanan'";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Status pesanan berhasil diperbarui!'); window.location='detail.php?id=$id_pesanan';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui status!'); window.location='detail.php?id=$id_pesanan';</script>";
    }
} else {
    header("Location: index.php");
}
?>
