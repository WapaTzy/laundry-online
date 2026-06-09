# Sistem Laundry Online (Native PHP & Bootstrap)

Aplikasi manajemen laundry berbasis web yang dibuat menggunakan PHP Native tanpa framework backend, dan Bootstrap untuk desain antarmukanya.

## Fitur Utama
- **Autentikasi Multi-role**: Pemisahan hak akses antara Administrator dan Customer.
- **Manajemen Layanan (Admin)**: CRUD data jenis layanan, harga, dan satuan laundry (Kg/Pcs).
- **Sistem Pemesanan (Customer)**: Memilih layanan menggunakan sistem keranjang belanja interaktif hingga proses checkout.
- **Transaksi & Upload Bukti**: Unggah berkas pembayaran (JPG/PNG) langsung ke sistem oleh pelanggan.
- **Verifikasi & Pelacakan Real-time**: Admin memverifikasi dana masuk dan memperbarui status cucian (Pending -> Proses -> Selesai -> Diambil), yang bisa dipantau langsung oleh customer.
- **Manajemen User (Admin)**: Monitoring data seluruh pengguna terdaftar.
- **Sistem Feedback/Ulasan**: Pelanggan memberikan rating bintang dan review setelah cucian selesai diambil.

- **Sistem Feedback/Ulasan**: Pelanggan memberikan rating bintang dan review setelah cucian selesai diambil.

## Arsitektur Sistem

```mermaid

graph TD
    %% Styling (opsional untuk menyamai warna diagram)
    classDef frontend fill:#1e4c82,stroke:#fff,stroke-width:2px,color:#fff;
    classDef router fill:#2d5e1e,stroke:#fff,stroke-width:2px,color:#fff;
    classDef backend fill:#38661e,stroke:#fff,stroke-width:2px,color:#fff;
    classDef database fill:#433e85,stroke:#fff,stroke-width:2px,color:#fff;
    classDef assets fill:#6b2e1f,stroke:#fff,stroke-width:2px,color:#fff;

    %% Subgraph Frontend
    subgraph FrontendLayer [Frontend - UI]
        Tamu["👤 Tamu<br>Login, Register"]:::frontend
        Customer["👤 Customer<br>Dashboard, Order"]:::frontend
        Admin["👤 Admin<br>Manage Order"]:::frontend
    end

    %% Subgraph Backend
    subgraph BackendLayer [Backend PHP Logic - TUGAS ANDA]
        Router["Router & Middleware<br>(index.php, login.php, customer/dashboard.php, admin/pesanan/index.php)"]:::router
        
        Auth["⚙️ Auth Module<br>Login, Register,<br>Session Check"]:::backend
        Order["⚙️ Order Module<br>Create, Update,<br>Status, Tracking"]:::backend
        Service["⚙️ Service Module<br>CRUD Layanan,<br>Harga"]:::backend
    end

    %% Subgraph Database
    subgraph DatabaseLayer [Database - MySQL]
        DB["🗄️ Database laundry_online<br>Tables: users, layanan, pesanan, detail_pesanan, ulasan<br>File: laundry.sql (import data awal)"]:::database
    end

    %% Subgraph Assets
    subgraph AssetsLayer [Assets - Static Resources]
        direction LR
        CSSJS["📁 CSS / JS<br>assets/css/style.css<br>assets/js/app.js"]:::assets
        Storage["📁 File Storage<br>assets/uploads/<br>bukti_pembayaran/"]:::assets
        Config["📁 Config<br>config/koneksi.php<br>(DB creds)"]:::assets
    end

    %% Alur Panah
    Tamu --> Router
    Customer --> Router
    Admin --> Router

    Router --> Auth
    Router --> Order
    Router --> Service

    Auth --> DB
    Order --> DB
    Service --> DB

```

## Cara Instalasi
1. Clone atau ekstrak folder proyek ini ke dalam direktori server lokal (`htdocs` untuk XAMPP).
2. Nyalakan modul Apache dan MySQL pada control panel local server Anda.
3. Buka phpMyAdmin, buat database baru dengan nama `laundry_online`.
4. Import file database yang berada di `/database/laundry.sql`.
5. Akses sistem melalui browser dengan alamat `http://localhost/laundry-online/`.

## Default Akses Admin
- **Email**: admin@laundry.com
- **Password**: admin123