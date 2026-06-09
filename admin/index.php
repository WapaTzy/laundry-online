<?php
session_start();
require '../config/koneksi.php';
require '../includes/auth.php';
cek_admin();

include '../includes/header.php';
include '../includes/navbar.php';

// Statistik ringkasan
$total_pesanan    = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM pesanan"))[0];
$pesanan_pending  = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM pesanan WHERE status='pending'"))[0];
$menunggu_verif   = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM pesanan WHERE status_pembayaran='menunggu_verifikasi'"))[0];
$total_pelanggan  = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM users WHERE role='customer'"))[0];
?>

<div class="container mt-5">
    <h2 class="mb-4">Dashboard Admin</h2>

    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white shadow-sm">
                <div class="card-body text-center">
                    <h3><?= $total_pesanan; ?></h3>
                    <p class="mb-0">Total Pesanan</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-dark shadow-sm">
                <div class="card-body text-center">
                    <h3><?= $pesanan_pending; ?></h3>
                    <p class="mb-0">Pesanan Pending</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-danger text-white shadow-sm">
                <div class="card-body text-center">
                    <h3><?= $menunggu_verif; ?></h3>
                    <p class="mb-0">Menunggu Verifikasi</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white shadow-sm">
                <div class="card-body text-center">
                    <h3><?= $total_pelanggan; ?></h3>
                    <p class="mb-0">Total Pelanggan</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5>📦 Kelola Pesanan</h5>
                    <p class="text-muted">Lihat, verifikasi, dan update status pesanan masuk.</p>
                    <a href="pesanan/index.php" class="btn btn-primary">Buka Pesanan</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5>🧺 Kelola Layanan</h5>
                    <p class="text-muted">Tambah, edit, atau hapus jenis layanan laundry.</p>
                    <a href="layanan/index.php" class="btn btn-primary">Buka Layanan</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5>👥 Kelola Pengguna</h5>
                    <p class="text-muted">Lihat daftar semua pelanggan yang terdaftar.</p>
                    <a href="users/index.php" class="btn btn-primary">Buka Pengguna</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
