<?php
session_start();
require '../config/koneksi.php';
require '../includes/auth.php';
cek_customer();

$id_user = $_SESSION['id_user'];

// Proses simpan ulasan jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pesanan = mysqli_real_escape_string($conn, $_POST['id_pesanan']);
    $rating     = (int)$_POST['rating'];
    $komentar   = mysqli_real_escape_string($conn, $_POST['komentar']);

    // Validasi apakah pesanan ini benar milik user dan sudah berstatus 'selesai' / 'diambil'
    $cek_pesanan = mysqli_query($conn, "SELECT * FROM pesanan WHERE id_pesanan='$id_pesanan' AND id_user='$id_user' AND (status='selesai' OR status='diambil')");
    
    // Cek juga apakah pesanan ini sudah pernah diberi ulasan sebelumnya
    $cek_ulasan = mysqli_query($conn, "SELECT * FROM ulasan WHERE id_pesanan='$id_pesanan'");

    if (mysqli_num_rows($cek_pesanan) > 0 && mysqli_num_rows($cek_ulasan) == 0) {
        $query_insert = "INSERT INTO ulasan (id_user, id_pesanan, rating, komentar) VALUES ('$id_user', '$id_pesanan', '$rating', '$komentar')";
        if (mysqli_query($conn, $query_insert)) {
            echo "<script>alert('Terima kasih atas ulasan Anda!'); window.location='ulasan.php';</script>";
        } else {
            echo "<script>alert('Gagal mengirim ulasan.');</script>";
        }
    } else {
        echo "<script>alert('Pesanan tidak valid atau sudah pernah diulas!'); window.location='ulasan.php';</script>";
    }
}

include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-5 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Tulis Ulasan Baru</h5>
                </div>
                <div class="card-body">
                    <form action="ulasan.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Pilih Pesanan</label>
                            <select name="id_pesanan" class="form-select" required>
                                <option value="">-- Pilih Order Selesai --</option>
                                <?php
                                // Hanya menampilkan pesanan selesai/diambil yang BELUM pernah diulas
                                $q_opsi = mysqli_query($conn, "SELECT p.id_pesanan, p.tanggal_pesan FROM pesanan p 
                                                               LEFT JOIN ulasan u ON p.id_pesanan = u.id_pesanan 
                                                               WHERE p.id_user='$id_user' 
                                                               AND (p.status='selesai' OR p.status='diambil') 
                                                               AND u.id_ulasan IS NULL");
                                while($opsi = mysqli_fetch_assoc($q_opsi)):
                                ?>
                                    <option value="<?= $opsi['id_pesanan']; ?>">#ORD-<?= str_pad($opsi['id_pesanan'], 4, '0', STR_PAD_LEFT); ?> (<?= date('d M Y', strtotime($opsi['tanggal_pesan'])); ?>)</option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Rating</label>
                            <select name="rating" class="form-select" required>
                                <option value="5">⭐⭐⭐⭐⭐ (5 - Sangat Puas)</option>
                                <option value="4">⭐⭐⭐⭐ (4 - Puas)</option>
                                <option value="3">⭐⭐⭐ (3 - Cukup)</option>
                                <option value="2">⭐⭐ (2 - Kurang Puas)</option>
                                <option value="1">⭐ (1 - Kecewa)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Komentar / Kritik / Saran</label>
                            <textarea name="komentar" class="form-control" rows="4" placeholder="Tuliskan pengalaman Anda menggunakan layanan kami..." required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Kirim Ulasan</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-7 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Riwayat Ulasan Saya</h5>
                </div>
                <div class="card-body">
                    <?php
                    $q_list = mysqli_query($conn, "SELECT u.*, p.tanggal_pesan FROM ulasan u JOIN pesanan p ON u.id_pesanan = p.id_pesanan WHERE u.id_user = '$id_user' ORDER BY u.created_at DESC");
                    if (mysqli_num_rows($q_list) > 0):
                        while($ulasan = mysqli_fetch_assoc($q_list)):
                    ?>
                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-primary">#ORD-<?= str_pad($ulasan['id_pesanan'], 4, '0', STR_PAD_LEFT); ?></span>
                                <small class="text-muted"><?= date('d M Y H:i', strtotime($ulasan['created_at'])); ?></small>
                            </div>
                            <div class="text-warning my-1">
                                <?= str_repeat('⭐', $ulasan['rating']); ?>
                            </div>
                            <p class="mb-0 text-secondary" style="font-size: 15px;">"<?= htmlspecialchars($ulasan['komentar']); ?>"</p>
                        </div>
                    <?php 
                        endwhile;
                    else:
                        echo "<p class='text-muted text-center my-4'>Anda belum pernah menulis ulasan.</p>";
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>