<?php
session_start();
require '../config/koneksi.php';
require '../includes/auth.php';
cek_customer();

if (!isset($_GET['id'])) {
    header("Location: riwayat.php");
    exit;
}

$id_pesanan = mysqli_real_escape_string($conn, $_GET['id']);
$id_user = $_SESSION['id_user'];

// Ambil info pesanan utama
$query_pesanan = mysqli_query($conn, "SELECT * FROM pesanan WHERE id_pesanan = '$id_pesanan' AND id_user = '$id_user'");
$pesanan = mysqli_fetch_assoc($query_pesanan);

if (!$pesanan) {
    echo "<script>alert('Data pesanan tidak ditemukan!'); window.location='riwayat.php';</script>";
    exit;
}

include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Detail & Status Pesanan #ORD-<?= str_pad($pesanan['id_pesanan'], 4, '0', STR_PAD_LEFT); ?></h2>
        <a href="riwayat.php" class="btn btn-secondary">← Kembali</a>
    </div>

    <div class="row">
        <div class="col-md-7 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Daftar Cucian</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Layanan</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query_detail = mysqli_query($conn, "SELECT dp.*, l.nama_layanan, l.satuan FROM detail_pesanan dp JOIN layanan l ON dp.id_layanan = l.id_layanan WHERE dp.id_pesanan = '$id_pesanan'");
                            while ($item = mysqli_fetch_assoc($query_detail)) :
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($item['nama_layanan']); ?></td>
                                <td><?= $item['jumlah']; ?> <?= strtoupper($item['satuan']); ?></td>
                                <td>Rp <?= number_format($item['subtotal'], 0, ',', '.'); ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                        <tfoot class="table-light fw-bold">
                            <tr>
                                <td colspan="2" class="text-end">Total Akhir:</td>
                                <td>Rp <?= number_format($pesanan['total_harga'], 0, ',', '.'); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-5 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Status Pelacakan</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label class="text-muted small d-block">STATUS CUCIAN</label>
                        <h4 class="text-uppercase text-primary fw-bold"><?= $pesanan['status']; ?></h4>
                    </div>
                    <div class="mb-4">
                        <label class="text-muted small d-block">STATUS PEMBAYARAN</label>
                        <h4 class="text-uppercase text-success fw-bold"><?= str_replace('_', ' ', $pesanan['status_pembayaran']); ?></h4>
                    </div>
                    <hr>
                    <div class="p-3 bg-light rounded">
                        <p class="small fw-bold mb-2">Tahapan Laundry:</p>
                        <ul class="list-unstyled ps-2 mb-0" style="line-height: 2;">
                            <li class="<?= ($pesanan['status']=='pending') ? 'text-primary fw-bold' : 'text-muted'; ?>">
                                📥 <?= ($pesanan['status']=='pending') ? '➔' : '✓'; ?> Menunggu Konfirmasi / Antrean
                            </li>
                            <li class="<?= ($pesanan['status']=='proses') ? 'text-primary fw-bold' : 'text-muted'; ?>">
                                🧺 <?= ($pesanan['status']=='proses') ? '➔' : (($pesanan['status']=='selesai' || $pesanan['status']=='diambil') ? '✓' : 'o'); ?> Sedang Dicuci & Setrika
                            </li>
                            <li class="<?= ($pesanan['status']=='selesai') ? 'text-primary fw-bold' : 'text-muted'; ?>">
                                ✨ <?= ($pesanan['status']=='selesai') ? '➔' : (($pesanan['status']=='diambil') ? '✓' : 'o'); ?> Selesai, Siap Diambil / Diantar
                            </li>
                            <li class="<?= ($pesanan['status']=='diambil') ? 'text-primary fw-bold' : 'text-muted'; ?>">
                                📦 <?= ($pesanan['status']=='diambil') ? '➔' : 'o'; ?> Sudah Diambil Pemilik
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>