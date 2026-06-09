<?php
session_start();
require '../../config/koneksi.php';
require '../../includes/auth.php';
cek_admin();

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$data_layanan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM layanan WHERE id_layanan = '$id'"));

if (!$data_layanan) {
    echo "<script>alert('Layanan tidak ditemukan!'); window.location='index.php';</script>";
    exit;
}

// Proses update jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_layanan = mysqli_real_escape_string($conn, $_POST['nama_layanan']);
    $harga        = mysqli_real_escape_string($conn, $_POST['harga']);
    $satuan       = mysqli_real_escape_string($conn, $_POST['satuan']);
    $deskripsi    = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    $query = "UPDATE layanan SET nama_layanan='$nama_layanan', harga='$harga', satuan='$satuan', deskripsi='$deskripsi' WHERE id_layanan='$id'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Layanan berhasil diperbarui!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui layanan!');</script>";
    }
}

include '../../includes/header.php';
include '../../includes/navbar.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Edit Layanan</h5>
                </div>
                <div class="card-body">
                    <form action="edit.php?id=<?= $id; ?>" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Nama Layanan</label>
                            <input type="text" name="nama_layanan" class="form-control" value="<?= htmlspecialchars($data_layanan['nama_layanan']); ?>" required>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Harga (Rp)</label>
                                <input type="number" name="harga" class="form-control" value="<?= $data_layanan['harga']; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Satuan</label>
                                <select name="satuan" class="form-select" required>
                                    <option value="kg" <?= ($data_layanan['satuan']=='kg') ? 'selected' : ''; ?>>Per Kilo (Kg)</option>
                                    <option value="pcs" <?= ($data_layanan['satuan']=='pcs') ? 'selected' : ''; ?>>Per Potong (Pcs)</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi Layanan</label>
                            <textarea name="deskripsi" class="form-control" rows="3"><?= htmlspecialchars($data_layanan['deskripsi']); ?></textarea>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="index.php" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
