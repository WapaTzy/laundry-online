<?php
session_start();
require '../config/koneksi.php';
require '../includes/auth.php';
cek_customer();

include '../includes/header.php';
include '../includes/navbar.php';

// Fitur untuk mengosongkan keranjang
if (isset($_GET['action']) && $_GET['action'] == 'clear') {
    unset($_SESSION['cart']);
    echo "<script>window.location='keranjang.php';</script>";
}
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Keranjang Pesanan</h2>
        <?php if(!empty($_SESSION['cart'])): ?>
            <a href="keranjang.php?action=clear" class="btn btn-outline-danger btn-sm" onclick="return confirm('Kosongkan keranjang?');">Kosongkan Keranjang</a>
        <?php endif; ?>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Layanan</th>
                            <th>Harga</th>
                            <th>Jumlah (Kg/Pcs)</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total_belanja = 0;
                        if (!empty($_SESSION['cart'])) {
                            $no = 1;
                            foreach ($_SESSION['cart'] as $id_layanan => $jumlah) {
                                $query = mysqli_query($conn, "SELECT * FROM layanan WHERE id_layanan = '$id_layanan'");
                                $row = mysqli_fetch_assoc($query);
                                
                                $subtotal = $row['harga'] * $jumlah;
                                $total_belanja += $subtotal;
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row['nama_layanan']); ?></td>
                            <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                            <td><?= $jumlah; ?></td>
                            <td class="text-end">Rp <?= number_format($subtotal, 0, ',', '.'); ?></td>
                        </tr>
                        <?php 
                            }
                        } else {
                            echo '<tr><td colspan="5" class="text-center">Keranjang masih kosong. <a href="dashboard.php">Pilih layanan</a></td></tr>';
                        }
                        ?>
                    </tbody>
                    <?php if (!empty($_SESSION['cart'])): ?>
                    <tfoot class="table-light fw-bold">
                        <tr>
                            <td colspan="4" class="text-end">Total Pembayaran:</td>
                            <td class="text-end text-primary fs-5">Rp <?= number_format($total_belanja, 0, ',', '.'); ?></td>
                        </tr>
                    </tfoot>
                    <?php endif; ?>
                </table>
            </div>

            <?php if (!empty($_SESSION['cart'])): ?>
            <div class="d-flex justify-content-end mt-3">
                <form action="../process/checkout.php" method="POST">
                    <input type="hidden" name="total_harga" value="<?= $total_belanja; ?>">
                    <button type="submit" class="btn btn-success btn-lg">Proses Checkout</button>
                </form>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>