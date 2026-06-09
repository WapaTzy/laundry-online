<?php
session_start();
require '../config/koneksi.php';
require '../includes/auth.php';
cek_customer();

include '../includes/header.php';
include '../includes/navbar.php';

$id_user = $_SESSION['id_user'];
?>

<div class="container mt-5">
    <h2 class="mb-4">Riwayat Pesanan Saya</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>No. Order</th>
                            <th>Tanggal Pesan</th>
                            <th>Total Tagihan</th>
                            <th>Status Cucian</th>
                            <th>Status Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = mysqli_query($conn, "SELECT * FROM pesanan WHERE id_user = '$id_user' ORDER BY tanggal_pesan DESC");
                        while ($row = mysqli_fetch_assoc($query)) :
                        ?>
                        <tr>
                            <td class="fw-bold">#ORD-<?= str_pad($row['id_pesanan'], 4, '0', STR_PAD_LEFT); ?></td>
                            <td><?= date('d M Y H:i', strtotime($row['tanggal_pesan'])); ?></td>
                            <td>Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?></td>
                            <td>
                                <?php
                                    $badge_cucian = 'bg-secondary';
                                    if($row['status'] == 'proses') $badge_cucian = 'bg-primary';
                                    if($row['status'] == 'selesai') $badge_cucian = 'bg-success';
                                    if($row['status'] == 'diambil') $badge_cucian = 'bg-dark';
                                ?>
                                <span class="badge <?= $badge_cucian; ?>"><?= strtoupper($row['status']); ?></span>
                            </td>
                            <td>
                                <?php
                                    $badge_bayar = 'bg-danger';
                                    if($row['status_pembayaran'] == 'menunggu_verifikasi') $badge_bayar = 'bg-warning text-dark';
                                    if($row['status_pembayaran'] == 'lunas') $badge_bayar = 'bg-success';
                                ?>
                                <span class="badge <?= $badge_bayar; ?>"><?= str_replace('_', ' ', strtoupper($row['status_pembayaran'])); ?></span>
                            </td>
                            <td>
                                <a href="tracking.php?id=<?= $row['id_pesanan']; ?>" class="btn btn-sm btn-info text-white">Detail</a>
                                <?php if($row['status_pembayaran'] == 'belum'): ?>
                                    <a href="upload_bukti.php?id=<?= $row['id_pesanan']; ?>" class="btn btn-sm btn-danger mt-1 mt-md-0">Bayar</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                        
                        <?php if(mysqli_num_rows($query) == 0): ?>
                        <tr><td colspan="6" class="text-center">Belum ada riwayat pesanan.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>