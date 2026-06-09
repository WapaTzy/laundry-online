<?php
session_start();
require '../../config/koneksi.php';
require '../../includes/auth.php';
cek_admin();

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id_pesanan = mysqli_real_escape_string($conn, $_GET['id']);

// Ambil data pesanan beserta info user
$q_pesanan = mysqli_query($conn, "SELECT p.*, u.nama, u.email, u.no_telp, u.alamat FROM pesanan p JOIN users u ON p.id_user = u.id_user WHERE p.id_pesanan = '$id_pesanan'");
$pesanan = mysqli_fetch_assoc($q_pesanan);

if (!$pesanan) {
    echo "<script>alert('Pesanan tidak ditemukan!'); window.location='index.php';</script>";
    exit;
}

// Ambil detail item pesanan
$q_detail = mysqli_query($conn, "SELECT dp.*, l.nama_layanan, l.satuan FROM detail_pesanan dp JOIN layanan l ON dp.id_layanan = l.id_layanan WHERE dp.id_pesanan = '$id_pesanan'");

include '../../includes/header.php';
include '../../includes/navbar.php';
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Detail Pesanan #ORD-<?= str_pad($pesanan['id_pesanan'], 4, '0', STR_PAD_LEFT); ?></h2>
        <a href="index.php" class="btn btn-secondary">← Kembali</a>
    </div>

    <div class="row">
        <div class="col-md-7 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-light fw-bold">Daftar Item Pesanan</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr><th>Layanan</th><th>Jumlah</th><th>Subtotal</th></tr>
                        </thead>
                        <tbody>
                            <?php while ($item = mysqli_fetch_assoc($q_detail)): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['nama_layanan']); ?></td>
                                <td><?= $item['jumlah']; ?> <?= strtoupper($item['satuan']); ?></td>
                                <td>Rp <?= number_format($item['subtotal'], 0, ',', '.'); ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                        <tfoot class="table-light fw-bold">
                            <tr>
                                <td colspan="2" class="text-end">Total:</td>
                                <td>Rp <?= number_format($pesanan['total_harga'], 0, ',', '.'); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Bukti Pembayaran -->
            <?php if ($pesanan['bukti_pembayaran']): ?>
            <div class="card shadow-sm mt-3">
                <div class="card-header bg-light fw-bold">Bukti Pembayaran</div>
                <div class="card-body text-center">
                    <img src="../../assets/uploads/bukti_pembayaran/<?= htmlspecialchars($pesanan['bukti_pembayaran']); ?>" class="img-fluid rounded" style="max-height: 300px;">
                    <?php if ($pesanan['status_pembayaran'] == 'menunggu_verifikasi'): ?>
                    <div class="mt-3">
                        <a href="verifikasi.php?id=<?= $pesanan['id_pesanan']; ?>" class="btn btn-success" onclick="return confirm('Verifikasi pembayaran ini sebagai LUNAS?');">✅ Verifikasi Pembayaran</a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <div class="col-md-5 mb-4">
            <!-- Info Pelanggan -->
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-light fw-bold">Info Pelanggan</div>
                <div class="card-body">
                    <p class="mb-1"><strong>Nama:</strong> <?= htmlspecialchars($pesanan['nama']); ?></p>
                    <p class="mb-1"><strong>Email:</strong> <?= htmlspecialchars($pesanan['email']); ?></p>
                    <p class="mb-1"><strong>No. Telp:</strong> <?= htmlspecialchars($pesanan['no_telp']); ?></p>
                    <p class="mb-0"><strong>Alamat:</strong> <?= htmlspecialchars($pesanan['alamat']); ?></p>
                </div>
            </div>

            <!-- Update Status -->
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white fw-bold">Update Status Cucian</div>
                <div class="card-body">
                    <p><strong>Status Saat Ini:</strong> <span class="badge bg-primary"><?= strtoupper($pesanan['status']); ?></span></p>
                    <p><strong>Pembayaran:</strong> <span class="badge <?= ($pesanan['status_pembayaran']=='lunas') ? 'bg-success' : (($pesanan['status_pembayaran']=='menunggu_verifikasi') ? 'bg-warning text-dark' : 'bg-danger'); ?>"><?= str_replace('_', ' ', strtoupper($pesanan['status_pembayaran'])); ?></span></p>
                    <form action="update_status.php" method="POST">
                        <input type="hidden" name="id_pesanan" value="<?= $pesanan['id_pesanan']; ?>">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Ubah Status</label>
                            <select name="status" class="form-select" required>
                                <option value="pending" <?= ($pesanan['status']=='pending') ? 'selected' : ''; ?>>Pending</option>
                                <option value="proses" <?= ($pesanan['status']=='proses') ? 'selected' : ''; ?>>Proses</option>
                                <option value="selesai" <?= ($pesanan['status']=='selesai') ? 'selected' : ''; ?>>Selesai</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Simpan Status</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
