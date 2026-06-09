<?php 
require_once 'config/koneksi.php';
include 'includes/root_header.php'; 
include 'includes/navbar.php'; 
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Daftar Akun Baru</h5>
                </div>
                <div class="card-body">
                    <form action="process/register.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" placeholder="Nama lengkap Anda" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="email@contoh.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" name="no_telp" class="form-control" placeholder="08xxxxxxxxxx">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat untuk antar-jemput laundry"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Daftar Sekarang</button>
                        <p class="text-center mt-3 mb-0">Sudah punya akun? <a href="login.php">Login di sini</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/root_footer.php'; ?>
