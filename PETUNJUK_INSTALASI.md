# Aplikasi E-Kos - Petunjuk Instalasi dan Penggunaan

## Deskripsi Aplikasi

E-Kos adalah aplikasi manajemen kos berbasis web yang menghubungkan pemilik kos dan pencari kos. Aplikasi ini dibangun menggunakan Laravel 12 dan MySQL dengan semua menu, database, dan field dalam Bahasa Indonesia.

## Fitur Utama

### 1. Admin
- Dashboard monitoring statistik
- Manajemen user (admin, pemilik kos, pencari kos)
- Manajemen kos
- Laporan dan analitik

### 2. Pemilik Kos
- Register dan login
- Manajemen kos (CRUD)
- Upload foto dan lokasi
- Manajemen pemesanan
- Pengaturan rekening dan kontak
- Notifikasi pemesanan dan ulasan

### 3. Pencari Kos
- Register dan login
- Pencarian kos dengan filter
- Detail kos lengkap
- Bookmark kos favorit
- Pesan kos
- Rating dan ulasan
- Notifikasi status pemesanan

## Teknologi yang Digunakan

- **Framework**: Laravel 12
- **Database**: MySQL
- **Frontend**: 
  - Template Admin: DASHMIN (Bootstrap Admin Template)
  - Landing Page: AirCon (Bootstrap Landing Page Template)
- **PHP**: 8.2+
- **Composer**: 2.x

## Struktur Database

### Tabel Utama

1. **pengguna** - Menyimpan data user (admin, pemilik_kos, pencari_kos)
2. **kos** - Menyimpan data kos
3. **fasilitas** - Master data fasilitas
4. **fasilitas_kos** - Relasi many-to-many kos dan fasilitas
5. **foto_kos** - Galeri foto kos
6. **pemesanan** - Data pemesanan
7. **pembayaran** - Data pembayaran
8. **ulasan** - Rating dan review kos
9. **bookmark** - Kos favorit user

## Instalasi

### 1. Prerequisites

Pastikan Anda telah menginstall:
- PHP 8.2 atau lebih tinggi
- Composer
- MySQL
- Web Server (Apache/Nginx) atau bisa menggunakan Laravel development server

### 2. Konfigurasi Database

Buat database MySQL baru:

```sql
CREATE DATABASE ekos_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 3. Konfigurasi Environment

File `.env` sudah dikonfigurasi dengan setting berikut:

```env
APP_NAME="E-Kos"
APP_LOCALE=id
APP_FALLBACK_LOCALE=id

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ekos_db
DB_USERNAME=root
DB_PASSWORD=
```

Sesuaikan `DB_USERNAME` dan `DB_PASSWORD` dengan kredensial MySQL Anda.

### 4. Install Dependencies

```bash
cd ekos-app
composer install
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Jalankan Migrasi Database

```bash
php artisan migrate
```

### 7. Jalankan Seeder

Seeder akan membuat:
- 1 Admin user
- 1 Pemilik Kos contoh
- 1 Pencari Kos contoh
- 20 Master fasilitas kos

```bash
php artisan db:seed
```

### 8. Jalankan Aplikasi

```bash
php artisan serve
```

Aplikasi akan berjalan di: `http://localhost:8000`

## Akun Default

Setelah menjalankan seeder, Anda dapat login dengan akun berikut:

### Admin
- **Email**: admin@ekos.com
- **Password**: admin123

### Pemilik Kos
- **Email**: budi@ekos.com
- **Password**: pemilik123

### Pencari Kos
- **Email**: siti@ekos.com
- **Password**: pencari123

## Struktur Folder

```
ekos-app/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Admin/          # Controllers untuk Admin
│   │       ├── PemilikKos/     # Controllers untuk Pemilik Kos
│   │       └── PencariKos/     # Controllers untuk Pencari Kos
│   └── Models/
│       ├── Pengguna.php        # Model User dengan multi-role
│       ├── Kos.php             # Model Kos
│       ├── Fasilitas.php       # Model Fasilitas
│       ├── FotoKos.php         # Model Foto Kos
│       ├── Pemesanan.php       # Model Pemesanan
│       ├── Pembayaran.php      # Model Pembayaran
│       ├── Ulasan.php          # Model Ulasan
│       └── Bookmark.php        # Model Bookmark
├── database/
│   ├── migrations/             # Semua migration dalam Bahasa Indonesia
│   └── seeders/
│       ├── PenggunaSeeder.php  # Seeder user default
│       └── FasilitasSeeder.php # Seeder fasilitas
├── public/
│   ├── template-admin/         # Template dashboard admin/pemilik
│   └── landing-page/           # Template landing page/pencari
└── resources/
    └── views/                  # Blade templates

```

## Models dan Relasi

### Pengguna (User)
- HasMany: kos, pemesanan, ulasan, bookmark
- Helper methods: isAdmin(), isPemilikKos(), isPencariKos()

### Kos
- BelongsTo: pemilik (Pengguna)
- BelongsToMany: fasilitas
- HasMany: foto, pemesanan, ulasan, bookmark
- Attributes: rating_rata_rata, jumlah_ulasan

### Pemesanan
- BelongsTo: kos, pencari (Pengguna)
- HasMany: pembayaran
- HasOne: ulasan
- Auto-generate kode pemesanan: KOS-YYYYMMDD-XXXXXX

## Fitur yang Akan Dikembangkan

Berikut adalah controller dan views yang perlu dibuat:

### Controllers

#### Auth
- [ ] LoginController
- [ ] RegisterController
- [ ] LogoutController

#### Admin
- [ ] DashboardController
- [ ] ManajemenPenggunaController
- [ ] ManajemenKosController
- [ ] LaporanController

#### Pemilik Kos
- [ ] DashboardController
- [ ] KosController (CRUD)
- [ ] PemesananController
- [ ] PengaturanController

#### Pencari Kos
- [ ] HomeController (Landing Page)
- [ ] PencarianController
- [ ] DetailKosController
- [ ] PemesananController
- [ ] BookmarkController
- [ ] UlasanController

### Views

#### Layouts
- [ ] admin.blade.php (menggunakan template-admin)
- [ ] public.blade.php (menggunakan landing-page)

#### Admin Views
- [ ] admin/dashboard.blade.php
- [ ] admin/pengguna/index.blade.php
- [ ] admin/pengguna/create.blade.php
- [ ] admin/pengguna/edit.blade.php
- [ ] admin/kos/index.blade.php
- [ ] admin/laporan/index.blade.php

#### Pemilik Kos Views
- [ ] pemilik/dashboard.blade.php
- [ ] pemilik/kos/index.blade.php
- [ ] pemilik/kos/create.blade.php
- [ ] pemilik/kos/edit.blade.php
- [ ] pemilik/pemesanan/index.blade.php
- [ ] pemilik/pengaturan/index.blade.php

#### Pencari Kos Views
- [ ] home.blade.php
- [ ] pencarian.blade.php
- [ ] detail-kos.blade.php
- [ ] pemesanan.blade.php
- [ ] bookmark.blade.php
- [ ] profil.blade.php

## Troubleshooting

### Error: Class "User" not found
Pastikan di `config/auth.php` provider model sudah diubah ke `App\Models\Pengguna::class`

### Error: SQLSTATE[HY000] [2002] No such file or directory
Pastikan MySQL service sudah berjalan dan kredensial di `.env` sudah benar

### Error: storage permission denied
Jalankan:
```bash
chmod -R 775 storage bootstrap/cache
```

## Kontribusi

Untuk mengembangkan fitur lebih lanjut, ikuti struktur yang sudah ada:
1. Buat Controller dengan namespace yang sesuai
2. Tambahkan routes di `routes/web.php`
3. Buat Blade views dengan extends layout yang sesuai
4. Gunakan Middleware untuk proteksi route berdasarkan role

## Lisensi

Aplikasi ini dibuat untuk keperluan pembelajaran dan development.

## Kontak

Untuk pertanyaan atau bantuan, silakan hubungi tim development.
