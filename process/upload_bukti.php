<?php
session_start();
require '../config/koneksi.php';
require '../includes/auth.php';
cek_customer();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pesanan = mysqli_real_escape_string($conn, $_POST['id_pesanan']);
    $id_user    = $_SESSION['id_user'];

    // Pastikan pesanan milik user ini dan belum bayar
    $cek = mysqli_query($conn, "SELECT * FROM pesanan WHERE id_pesanan='$id_pesanan' AND id_user='$id_user' AND status_pembayaran='belum'");
    if (mysqli_num_rows($cek) == 0) {
        echo "<script>alert('Pesanan tidak valid atau sudah dibayar!'); window.location='../customer/riwayat.php';</script>";
        exit;
    }

    if (!isset($_FILES['bukti_pembayaran']) || $_FILES['bukti_pembayaran']['error'] !== UPLOAD_ERR_OK) {
        echo "<script>alert('Gagal mengupload file!'); window.location='../customer/upload_bukti.php?id=$id_pesanan';</script>";
        exit;
    }

    $file      = $_FILES['bukti_pembayaran'];
    $ext       = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed   = ['jpg', 'jpeg', 'png'];
    $max_size  = 2 * 1024 * 1024; // 2MB

    if (!in_array($ext, $allowed)) {
        echo "<script>alert('Format file tidak diizinkan! Gunakan JPG atau PNG.'); window.location='../customer/upload_bukti.php?id=$id_pesanan';</script>";
        exit;
    }

    if ($file['size'] > $max_size) {
        echo "<script>alert('Ukuran file terlalu besar! Maksimal 2MB.'); window.location='../customer/upload_bukti.php?id=$id_pesanan';</script>";
        exit;
    }

    $upload_dir = '../assets/uploads/bukti_pembayaran/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);

    $nama_file = 'bukti_' . $id_pesanan . '_' . time() . '.' . $ext;
    $tujuan    = $upload_dir . $nama_file;

    if (move_uploaded_file($file['tmp_name'], $tujuan)) {
        $query = "UPDATE pesanan SET bukti_pembayaran='$nama_file', status_pembayaran='menunggu_verifikasi' WHERE id_pesanan='$id_pesanan'";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Bukti pembayaran berhasil dikirim! Menunggu verifikasi admin.'); window.location='../customer/riwayat.php';</script>";
        } else {
            echo "<script>alert('Gagal menyimpan data!'); window.location='../customer/riwayat.php';</script>";
        }
    } else {
        echo "<script>alert('Gagal memindahkan file upload!'); window.location='../customer/upload_bukti.php?id=$id_pesanan';</script>";
    }
} else {
    header("Location: ../customer/riwayat.php");
}
?>
