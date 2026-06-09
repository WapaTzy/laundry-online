-- ============================================
-- DATABASE: laundry_online
-- Import file ini ke database yang sudah dibuat
-- ============================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+07:00";

-- -----------------------------------------------
-- Tabel: users
-- -----------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` INT AUTO_INCREMENT PRIMARY KEY,
  `nama` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin','customer') DEFAULT 'customer',
  `no_telp` VARCHAR(15) DEFAULT NULL,
  `alamat` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------
-- Tabel: layanan
-- -----------------------------------------------
CREATE TABLE IF NOT EXISTS `layanan` (
  `id_layanan` INT AUTO_INCREMENT PRIMARY KEY,
  `nama_layanan` VARCHAR(100) NOT NULL,
  `harga` DECIMAL(10,2) NOT NULL,
  `satuan` ENUM('kg','pcs') DEFAULT 'kg',
  `deskripsi` TEXT DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------
-- Tabel: pesanan
-- -----------------------------------------------
CREATE TABLE IF NOT EXISTS `pesanan` (
  `id_pesanan` INT AUTO_INCREMENT PRIMARY KEY,
  `id_user` INT NOT NULL,
  `tanggal_pesan` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `status` ENUM('pending','proses','selesai','diambil') DEFAULT 'pending',
  `status_pembayaran` ENUM('belum','menunggu_verifikasi','lunas') DEFAULT 'belum',
  `bukti_pembayaran` VARCHAR(255) DEFAULT NULL,
  `total_harga` DECIMAL(10,2) DEFAULT 0,
  FOREIGN KEY (`id_user`) REFERENCES `users`(`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------
-- Tabel: detail_pesanan
-- -----------------------------------------------
CREATE TABLE IF NOT EXISTS `detail_pesanan` (
  `id_detail` INT AUTO_INCREMENT PRIMARY KEY,
  `id_pesanan` INT NOT NULL,
  `id_layanan` INT NOT NULL,
  `jumlah` INT NOT NULL,
  `subtotal` DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan`(`id_pesanan`) ON DELETE CASCADE,
  FOREIGN KEY (`id_layanan`) REFERENCES `layanan`(`id_layanan`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------
-- Tabel: ulasan
-- -----------------------------------------------
CREATE TABLE IF NOT EXISTS `ulasan` (
  `id_ulasan` INT AUTO_INCREMENT PRIMARY KEY,
  `id_pesanan` INT NOT NULL,
  `id_user` INT NOT NULL,
  `rating` TINYINT(1) NOT NULL DEFAULT 5,
  `komentar` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan`(`id_pesanan`) ON DELETE CASCADE,
  FOREIGN KEY (`id_user`) REFERENCES `users`(`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------
-- Data Awal: Admin
-- -----------------------------------------------
INSERT IGNORE INTO `users` (`nama`, `email`, `password`, `role`, `no_telp`, `alamat`) VALUES
('Administrator', 'admin@laundry.com', MD5('admin123'), 'admin', '08123456789', 'Kantor Laundry Online');

-- -----------------------------------------------
-- Data Awal: Layanan
-- -----------------------------------------------
INSERT IGNORE INTO `layanan` (`nama_layanan`, `harga`, `satuan`, `deskripsi`) VALUES
('Cuci + Setrika', 7000.00, 'kg', 'Layanan lengkap cuci dan setrika pakaian, bersih dan rapi'),
('Cuci Saja', 5000.00, 'kg', 'Layanan cuci pakaian tanpa setrika'),
('Setrika Saja', 4000.00, 'kg', 'Layanan setrika pakaian yang sudah dicuci'),
('Cuci Sepatu', 25000.00, 'pcs', 'Layanan cuci sepatu bersih hingga sol'),
('Express 24 Jam', 12000.00, 'kg', 'Layanan kilat selesai dalam 24 jam'),
('Dry Cleaning', 15000.00, 'pcs', 'Layanan dry cleaning untuk pakaian berbahan khusus');
