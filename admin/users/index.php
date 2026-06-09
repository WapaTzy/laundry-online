<?php
session_start();
require '../../config/koneksi.php';
require '../../includes/auth.php';
cek_admin();

include '../../includes/header.php';
include '../../includes/navbar.php';
?>

<div class="container mt-5">
    <h2 class="mb-4">Kelola Pengguna / Pelanggan</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No. Telepon</th>
                            <th>Alamat</th>
                            <th>Role</th>
                            <th>Bergabung</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $query = mysqli_query($conn, "SELECT * FROM users ORDER BY created_at DESC");
                        while ($row = mysqli_fetch_assoc($query)) :
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row['nama']); ?></td>
                            <td><?= htmlspecialchars($row['email']); ?></td>
                            <td><?= htmlspecialchars($row['no_telp']); ?></td>
                            <td><?= htmlspecialchars($row['alamat']); ?></td>
                            <td><span class="badge <?= ($row['role']=='admin') ? 'bg-danger' : 'bg-primary'; ?>"><?= strtoupper($row['role']); ?></span></td>
                            <td><?= date('d M Y', strtotime($row['created_at'])); ?></td>
                        </tr>
                        <?php endwhile; ?>

                        <?php if(mysqli_num_rows($query) == 0): ?>
                        <tr><td colspan="7" class="text-center">Belum ada pengguna terdaftar.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
