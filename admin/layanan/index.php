<?php
session_start();
require '../../config/koneksi.php';
require '../../includes/auth.php';
cek_admin();

include '../../includes/header.php';
include '../../includes/navbar.php';
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Kelola Layanan Laundry</h2>
        <a href="tambah.php" class="btn btn-primary">+ Tambah Layanan</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Layanan</th>
                            <th>Harga</th>
                            <th>Satuan</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $query = mysqli_query($conn, "SELECT * FROM layanan ORDER BY nama_layanan ASC");
                        while ($row = mysqli_fetch_assoc($query)) :
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row['nama_layanan']); ?></td>
                            <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                            <td><?= strtoupper($row['satuan']); ?></td>
                            <td><?= htmlspecialchars($row['deskripsi']); ?></td>
                            <td>
                                <a href="edit.php?id=<?= $row['id_layanan']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="hapus.php?id=<?= $row['id_layanan']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus layanan ini?');">Hapus</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>

                        <?php if(mysqli_num_rows($query) == 0): ?>
                        <tr><td colspan="6" class="text-center">Belum ada layanan terdaftar.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
