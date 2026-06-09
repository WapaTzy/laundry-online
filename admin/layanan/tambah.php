<?php
session_start();
require '../../config/koneksi.php';
require '../../includes/auth.php';
cek_admin();

// Proses form jika disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_layanan = mysqli_real_escape_string($conn, $_POST['nama_layanan']);
    $harga        = mysqli_real_escape_string($conn, $_POST['harga']);
    $satuan       = mysqli_real_escape_string($conn, $_POST['satuan']);
    $deskripsi    = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    $query = "INSERT INTO layanan (nama_layanan, harga, satuan, deskripsi) 
              VALUES ('$nama_layanan', '$harga', '$satuan', '$deskripsi')";
              
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Layanan berhasil ditambahkan!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan layanan!');</script>";
    }
}

include '../../includes/header.php';
include '../../includes/navbar.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Tambah Layanan Baru</h5>
                </div>
                <div class="card-body">
                    <form action="tambah.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Nama Layanan</label>
                            <input type="text" name="nama_layanan" class="form-control" placeholder="Contoh: Cuci Komplit" required>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Harga (Rp)</label>
                                <input type="number" name="harga" class="form-control" placeholder="Contoh: 6000" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Satuan</label>
                                <select name="satuan" class="form-select" required>
                                    <option value="kg">Per Kilo (Kg)</option>
                                    <option value="pcs">Per Potong (Pcs)</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi Layanan</label>
                            <textarea name="deskripsi" class="form-control" rows="3" placeholder="Contoh: Cuci bersih, wangi, dan disetrika rapi."></textarea>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="index.php" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan Layanan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>