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

// Pastikan pesanan ini memang milik user yang sedang login
$query = mysqli_query($conn, "SELECT * FROM pesanan WHERE id_pesanan = '$id_pesanan' AND id_user = '$id_user'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "<script>alert('Pesanan tidak ditemukan!'); window.location='riwayat.php';</script>";
    exit;
}

include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Upload Bukti Pembayaran</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <p class="mb-1">Silakan transfer sebesar:</p>
                        <h4 class="fw-bold text-dark">Rp <?= number_format($data['total_harga'], 0, ',', '.'); ?></h4>
                        <hr>
                        <p class="small mb-0"><strong>Bank Mandiri:</strong> 123-456-7890 (a.n Laundry Online)</p>
                    </div>

                    <form action="../process/upload_bukti.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id_pesanan" value="<?= $data['id_pesanan']; ?>">
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Pilih File Gambar</label>
                            <input type="file" name="bukti_pembayaran" class="form-control" accept="image/*" required>
                            <div class="form-text">Format yang diperbolehkan: JPG, JPEG, PNG. Maksimal 2MB.</div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="riwayat.php" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Kirim Bukti Pembayaran</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>