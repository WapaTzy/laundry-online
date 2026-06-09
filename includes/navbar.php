<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand fw-bold" href="/laundry-online/index.php">🧺 Laundry Online</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="/laundry-online/index.php">Beranda</a>
        </li>
        <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
            <li class="nav-item"><a class="nav-link" href="/laundry-online/admin/index.php">📊 Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="/laundry-online/admin/pesanan/index.php">📦 Pesanan</a></li>
            <li class="nav-item"><a class="nav-link" href="/laundry-online/admin/layanan/index.php">🧺 Layanan</a></li>
            <li class="nav-item"><a class="nav-link" href="/laundry-online/admin/users/index.php">👥 Pengguna</a></li>
            <li class="nav-item"><a class="nav-link" href="/laundry-online/process/logout.php">Logout</a></li>
        <?php elseif(isset($_SESSION['role']) && $_SESSION['role'] == 'customer'): ?>
            <li class="nav-item"><a class="nav-link" href="/laundry-online/customer/dashboard.php">🏠 Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="/laundry-online/customer/keranjang.php">🛒 Keranjang</a></li>
            <li class="nav-item"><a class="nav-link" href="/laundry-online/customer/riwayat.php">📋 Riwayat</a></li>
            <li class="nav-item"><a class="nav-link" href="/laundry-online/customer/ulasan.php">⭐ Ulasan</a></li>
            <li class="nav-item"><a class="nav-link" href="/laundry-online/process/logout.php">Logout</a></li>
        <?php else: ?>
            <li class="nav-item"><a class="nav-link" href="/laundry-online/login.php">Login</a></li>
            <li class="nav-item"><a class="nav-link" href="/laundry-online/register.php">Register</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>