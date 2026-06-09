<?php
session_start();
require '../config/koneksi.php';
require '../includes/auth.php';
cek_customer();

include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Selamat datang, <?= htmlspecialchars($_SESSION['nama']); ?>!</h2>
        <a href="keranjang.php" class="btn btn-outline-primary">🛒 Lihat Keranjang</a>
    </div>

    <h4 class="mb-3">Pilih Layanan Laundry</h4>
    <div class="row">
        <?php
        $query = mysqli_query($conn, "SELECT * FROM layanan ORDER BY nama_layanan ASC");
        
        // Cek apakah query berhasil
        if (!$query) {
            echo '<div class="col-12"><div class="alert alert-danger">❌ Error: ' . htmlspecialchars(mysqli_error($conn)) . '</div></div>';
        } 
        // Cek apakah ada data
        elseif (mysqli_num_rows($query) == 0) {
            echo '<div class="col-12"><div class="alert alert-warning">⚠️ Belum ada layanan. Admin sedang membuat daftar layanan.</div></div>';
        } 
        // Jika OK, tampilkan layanan
        else {
            while ($row = mysqli_fetch_assoc($query)) :
            ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($row['nama_layanan']); ?></h5>
                        <h6 class="card-subtitle mb-2 text-primary fw-bold">
                            Rp <?= number_format($row['harga'], 0, ',', '.'); ?> / <?= strtoupper($row['satuan']); ?>
                        </h6>
                        <p class="card-text mt-3 text-muted" style="font-size: 14px;">
                            <?= htmlspecialchars($row['deskripsi']); ?>
                        </p>
                    </div>
                    <div class="card-footer bg-white border-top-0 pb-3">
                        <form action="../process/tambah_cart.php" method="POST" class="d-flex align-items-center">
                            <input type="hidden" name="id_layanan" value="<?= $row['id_layanan']; ?>">
                            <input type="number" name="jumlah" class="form-control me-2" value="1" min="1" style="width: 80px;" required>
                            <button type="submit" class="btn btn-primary w-100">+ Keranjang</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php 
            endwhile;
        }
        ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
