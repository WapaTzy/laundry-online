<?php
session_start();
require '../config/koneksi.php';
require '../includes/auth.php';
cek_customer();

if (empty($_SESSION['cart'])) {
    header("Location: keranjang.php");
    exit;
}

// Ambil data alamat default customer untuk konfirmasi
$id_user = $_SESSION['id_user'];
$result_user = mysqli_query($conn, "SELECT * FROM users WHERE id_user = '$id_user'");
$user_info = mysqli_fetch_assoc($result_user);

include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="container mt-5">
    <h2 class="mb-4">Konfirmasi Checkout Pesanan</h2>
    <div class="row">
        <div class="col-md-7 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-light fw-bold">Ringkasan Pesanan</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Layanan</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total = 0;
                            foreach ($_SESSION['cart'] as $id_layanan => $jumlah) {
                                $q = mysqli_query($conn, "SELECT * FROM layanan WHERE id_layanan = '$id_layanan'");
                                $row = mysqli_fetch_assoc($q);
                                $sub = $row['harga'] * $jumlah;
                                $total += $sub;
                                echo "<tr>
                                        <td>".htmlspecialchars($row['nama_layanan'])."</td>
                                        <td>$jumlah ".strtoupper($row['satuan'])."</td>
                                        <td>Rp ".number_format($sub, 0, ',', '.')."</td>
                                      </tr>";
                            }
                            ?>
                            <tr class="table-light fw-bold">
                                <td colspan="2">Total Pembayaran</td>
                                <td class="text-primary">Rp <?= number_format($total, 0, ',', '.'); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-5 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white fw-bold">Informasi Pengiriman & Alamat</div>
                <div class="card-body">
                    <p class="mb-1"><strong>Nama Penerima:</strong> <?= htmlspecialchars($user_info['nama']); ?></p>
                    <p class="mb-1"><strong>No. Telepon:</strong> <?= htmlspecialchars($user_info['no_telp']); ?></p>
                    <p class="mb-3"><strong>Alamat Pengantaran/Penjemputan:</strong><br><?= htmlspecialchars($user_info['alamat']); ?></p>
                    
                    <div class="alert alert-warning small">
                        *Pastikan alamat Anda sudah benar. Jika ingin mengubahnya, silakan update profil terlebih dahulu.
                    </div>

                    <form action="../process/checkout.php" method="POST">
                        <input type="hidden" name="total_harga" value="<?= $total; ?>">
                        <button type="submit" class="btn btn-success w-100 btn-lg">Konfirmasi & Buat Pesanan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
