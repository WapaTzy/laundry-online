<?php
session_start();
require '../../config/koneksi.php';
require '../../includes/auth.php';
cek_admin();

include '../../includes/header.php';
include '../../includes/navbar.php';
?>

<div class="container mt-5">
    <h2 class="mb-4">Kelola Pesanan Laundry</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>No. Order</th>
                            <th>Pelanggan</th>
                            <th>Tanggal Masuk</th>
                            <th>Total Tagihan</th>
                            <th>Status Cucian</th>
                            <th>Status Bayar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Query join untuk mengambil nama pelanggan
                        $query = mysqli_query($conn, "SELECT p.*, u.nama FROM pesanan p JOIN users u ON p.id_user = u.id_user ORDER BY p.tanggal_pesan DESC");
                        while ($row = mysqli_fetch_assoc($query)) :
                        ?>
                        <tr>
                            <td class="fw-bold">#ORD-<?= str_pad($row['id_pesanan'], 4, '0', STR_PAD_LEFT); ?></td>
                            <td><?= htmlspecialchars($row['nama']); ?></td>
                            <td><?= date('d M Y H:i', strtotime($row['tanggal_pesan'])); ?></td>
                            <td>Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?></td>
                            <td>
                                <span class="badge <?= ($row['status']=='proses') ? 'bg-primary' : (($row['status']=='selesai') ? 'bg-success' : (($row['status']=='diambil') ? 'bg-dark' : 'bg-secondary')); ?>">
                                    <?= strtoupper($row['status']); ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge <?= ($row['status_pembayaran']=='lunas') ? 'bg-success' : (($row['status_pembayaran']=='menunggu_verifikasi') ? 'bg-warning text-dark' : 'bg-danger'); ?>">
                                    <?= str_replace('_', ' ', strtoupper($row['status_pembayaran'])); ?>
                                </span>
                            </td>
                            <td>
                                <a href="detail.php?id=<?= $row['id_pesanan']; ?>" class="btn btn-sm btn-info text-white">Detail / Aksi</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                        
                        <?php if(mysqli_num_rows($query) == 0): ?>
                        <tr><td colspan="7" class="text-center">Belum ada pesanan masuk.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>