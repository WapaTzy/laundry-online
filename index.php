<?php 
require_once 'config/koneksi.php';
include 'includes/root_header.php'; 
include 'includes/navbar.php'; 
?>

<div class="container mt-5">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="display-4 fw-bold">Pakaian Bersih Tanpa Ribet</h1>
            <p class="lead">Layanan laundry profesional dengan fitur antar-jemput dan pelacakan status pesanan secara real-time.</p>
            <a href="register.php" class="btn btn-primary btn-lg mt-3">Mulai Pesan Sekarang</a>
        </div>
        <div class="col-md-6 text-center">
            <div class="p-5 bg-light rounded-3">
                <h3>Layanan Unggulan Kami</h3>
                <ul class="list-unstyled mt-3">
                    <li>✨ Cuci Komplit (Cuci + Setrika)</li>
                    <li>👕 Setrika Saja</li>
                    <li>👟 Cuci Sepatu</li>
                    <li>⚡ Layanan Express 24 Jam</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/root_footer.php'; ?>
