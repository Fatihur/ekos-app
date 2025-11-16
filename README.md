# E-Kos - Platform Manajemen Kos Online Batu Alang

## 📋 Deskripsi Aplikasi

E-Kos adalah platform web berbasis Laravel untuk manajemen kos-kosan di area Batu Alang. Aplikasi ini memfasilitasi tiga jenis pengguna: Admin, Pemilik Kos, dan Pencari Kos dengan fitur-fitur lengkap untuk pencarian, pemesanan, pembayaran, dan manajemen kos secara online.

## 🎯 Tujuan Aplikasi

- Memudahkan pencari kos menemukan kos yang sesuai di Batu Alang
- Membantu pemilik kos mengelola properti dan pemesanan secara online
- Menyediakan platform terpusat untuk transaksi kos yang aman dan terverifikasi
- Meningkatkan transparansi dengan sistem rating dan ulasan

## 👥 User Roles

### 1. Admin
- Mengelola seluruh sistem
- Manajemen pengguna (CRUD)
- Monitoring kos dan pemesanan
- Melihat laporan dan statistik
- Mengaktifkan/menonaktifkan kos

### 2. Pemilik Kos
- Mendaftarkan dan mengelola kos
- Menerima/menolak pemesanan
- Verifikasi pembayaran
- Mengelola foto dan fasilitas kos
- Melihat statistik pemesanan

### 3. Pencari Kos
- Mencari dan melihat detail kos
- Memesan kos online
- Upload bukti pembayaran
- Memberikan rating dan ulasan
- Menyimpan kos favorit (bookmark)

## 🚀 Fitur Utama

### Fitur Umum
- **Authentication & Authorization**: Login, Register, Logout dengan role-based access
- **Multi-language**: Bahasa Indonesia untuk semua pesan dan validasi
- **Responsive Design**: Tampilan optimal di desktop dan mobile
- **Search & Filter**: Pencarian berdasarkan nama, lokasi, jenis kos, harga

### Fitur Pencari Kos
- **Pencarian Kos**: Filter berdasarkan jenis kos, harga, lokasi, fasilitas
- **Detail Kos**: Galeri foto, deskripsi, fasilitas, peraturan, lokasi Google Maps
- **Pemesanan Online**: Form pemesanan dengan durasi sewa fleksibel
- **Upload Bukti Pembayaran**: Upload dan tracking status pembayaran
- **Bookmark/Favorit**: Simpan kos favorit untuk akses cepat
- **Rating & Ulasan**: Berikan rating dan ulasan setelah pemesanan selesai
- **Manajemen Profil**: Edit profil, foto, dan password

### Fitur Pemilik Kos
- **CRUD Kos**: Tambah, edit, hapus, dan kelola kos
- **Upload Foto**: Foto utama dan galeri foto tambahan
- **Manajemen Fasilitas**: Pilih fasilitas yang tersedia
- **Google Maps Link**: Tambahkan link lokasi (opsional)
- **Manajemen Pemesanan**: 
  - Terima/tolak pemesanan
  - Verifikasi/tolak pembayaran
  - Tandai pemesanan selesai
- **Dashboard**: Statistik kos dan pemesanan
- **Pengaturan Akun**: Edit profil dan informasi rekening

### Fitur Admin
- **Dashboard**: Statistik lengkap sistem
- **Manajemen Pengguna**: CRUD pengguna dengan semua role
- **Manajemen Kos**: Monitoring dan aktivasi/deaktivasi kos
- **Manajemen Pemesanan**: Monitoring semua transaksi
- **Laporan**: Laporan pemesanan dan statistik

## 🗄️ Database Schema

### Tabel Utama

#### 1. pengguna
```sql
- id (PK)
- nama
- email (unique)
- password
- peran (enum: admin, pemilik_kos, pencari_kos)
- telepon
- whatsapp
- foto_profil
- alamat
- nomor_rekening
- nama_bank
- nama_pemilik_rekening
- aktif (boolean)
- email_verified_at
- timestamps
- soft_deletes
```

#### 2. kos
```sql
- id (PK)
- pemilik_id (FK -> pengguna)
- nama_kos
- deskripsi (text)
- jenis_kos (enum: putra, putri, campur)
- jenis_kamar (enum: kamar_mandi_dalam, kamar_mandi_luar)
- harga (decimal)
- jumlah_kamar
- kamar_tersedia
- alamat
- google_maps_link (nullable)
- kota
- provinsi
- kode_pos
- peraturan (text)
- foto_utama
- aktif (boolean)
- timestamps
- soft_deletes
```

#### 3. pemesanan
```sql
- id (PK)
- kos_id (FK -> kos)
- pencari_id (FK -> pengguna)
- kode_pemesanan (unique)
- tanggal_masuk
- durasi_sewa
- satuan_durasi (enum: hari, bulan, tahun)
- total_harga (decimal)
- status (enum: pending, disetujui, ditolak, dibayar, aktif, selesai, dibatalkan)
- catatan
- alasan_penolakan
- tanggal_disetujui
- timestamps
- soft_deletes
```

#### 4. pembayaran
```sql
- id (PK)
- pemesanan_id (FK -> pemesanan)
- jumlah (decimal)
- bukti_pembayaran
- status (enum: pending, berhasil, gagal)
- catatan
- tanggal_verifikasi
- timestamps
```

#### 5. ulasan
```sql
- id (PK)
- kos_id (FK -> kos)
- pemesanan_id (FK -> pemesanan)
- pengguna_id (FK -> pengguna)
- rating (1-5)
- komentar
- timestamps
```

#### 6. bookmark
```sql
- id (PK)
- pengguna_id (FK -> pengguna)
- kos_id (FK -> kos)
- timestamps
```

#### 7. fasilitas
```sql
- id (PK)
- nama_fasilitas
- icon
- timestamps
```

#### 8. fasilitas_kos (pivot table)
```sql
- id (PK)
- kos_id (FK -> kos)
- fasilitas_id (FK -> fasilitas)
- timestamps
```

#### 9. foto_kos
```sql
- id (PK)
- kos_id (FK -> kos)
- foto
- urutan
- timestamps
```

## 🔄 Flow Aplikasi

### Flow Pemesanan Kos

```
1. Pencari Kos mencari kos
   ↓
2. Melihat detail kos
   ↓
3. Klik "Pesan Sekarang"
   ↓
4. Isi form pemesanan (tanggal masuk, durasi)
   ↓
5. Status: PENDING (menunggu persetujuan pemilik)
   ↓
6. Pemilik Kos menerima notifikasi
   ↓
7. Pemilik MENYETUJUI atau MENOLAK
   ↓
   ├─ DITOLAK → Pemesanan selesai
   │
   └─ DISETUJUI → Status: DISETUJUI
      ↓
8. Pencari upload bukti pembayaran
   ↓
9. Status: DIBAYAR (menunggu verifikasi)
   ↓
10. Pemilik verifikasi pembayaran
    ↓
    ├─ DITOLAK → Kembali ke status DISETUJUI (upload ulang)
    │
    └─ DITERIMA → Status: AKTIF
       ↓
11. Pemesanan berjalan
    ↓
12. Pemilik tandai SELESAI
    ↓
13. Pencari dapat memberikan ULASAN
```

### Flow Manajemen Kos

```
1. Pemilik login
   ↓
2. Dashboard Pemilik
   ↓
3. Tambah Kos Baru
   ↓
4. Isi informasi kos:
   - Data dasar (nama, jenis, harga)
   - Lokasi (alamat, kota, Google Maps link)
   - Deskripsi & Peraturan
   - Fasilitas
   - Upload foto
   ↓
5. Kos tersimpan (status: aktif)
   ↓
6. Muncul di halaman pencarian
   ↓
7. Pemilik dapat:
   - Edit informasi
   - Upload/hapus foto
   - Nonaktifkan kos
   - Lihat statistik pemesanan
```

### Flow Verifikasi Pembayaran

```
1. Pencari upload bukti pembayaran
   ↓
2. Status pembayaran: PENDING
   ↓
3. Pemilik melihat bukti pembayaran
   ↓
4. Pemilik memutuskan:
   ↓
   ├─ VERIFIKASI
   │  ↓
   │  - Status pembayaran: BERHASIL
   │  - Status pemesanan: AKTIF
   │  - Kamar tersedia berkurang
   │
   └─ TOLAK
      ↓
      - Status pembayaran: GAGAL
      - Status pemesanan: DISETUJUI
      - Pencari harus upload ulang
```

## 📁 Struktur Folder

```
ekos-app/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── ManajemenPenggunaController.php
│   │   │   │   ├── ManajemenKosController.php
│   │   │   │   ├── ManajemenPemesananController.php
│   │   │   │   └── LaporanController.php
│   │   │   ├── PemilikKos/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── KosController.php
│   │   │   │   ├── PemesananController.php
│   │   │   │   └── PengaturanController.php
│   │   │   ├── PencariKos/
│   │   │   │   ├── HomeController.php
│   │   │   │   ├── DetailKosController.php
│   │   │   │   ├── PemesananController.php
│   │   │   │   ├── BookmarkController.php
│   │   │   │   ├── ProfilController.php
│   │   │   │   └── UlasanController.php
│   │   │   └── Auth/
│   │   │       ├── LoginController.php
│   │   │       └── RegisterController.php
│   │   ├── Middleware/
│   │   │   └── RoleMiddleware.php
│   │   └── Requests/
│   │       ├── KosRequest.php
│   │       └── PemesananRequest.php
│   └── Models/
│       ├── Pengguna.php
│       ├── Kos.php
│       ├── Pemesanan.php
│       ├── Pembayaran.php
│       ├── Ulasan.php
│       ├── Bookmark.php
│       ├── Fasilitas.php
│       └── FotoKos.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── admin.blade.php
│   │   │   └── public.blade.php
│   │   ├── admin/
│   │   ├── pemilik/
│   │   ├── pencari/
│   │   ├── auth/
│   │   ├── home.blade.php
│   │   ├── pencarian.blade.php
│   │   └── detail-kos.blade.php
│   └── lang/
│       └── id/
└── routes/
    └── web.php
```

## 🛠️ Teknologi yang Digunakan

### Backend
- **Framework**: Laravel 12.x
- **PHP**: 8.4+
- **Database**: MySQL
- **Authentication**: Laravel Breeze/UI

### Frontend
- **Template**: 
  - Admin: DASHMIN Bootstrap Template
  - Public: AirCon Landing Page Template
- **CSS Framework**: Bootstrap 5
- **Icons**: Font Awesome 5
- **JavaScript**: jQuery, Bootstrap JS
- **Rich Text Editor**: CKEditor 5

### Tools & Libraries
- **Image Storage**: Laravel Storage (public disk)
- **Validation**: Laravel Form Request
- **Soft Deletes**: Eloquent Soft Deletes
- **Pagination**: Laravel Pagination
- **Seeder**: Database Seeder untuk data dummy

## 📦 Instalasi

### Requirements
- PHP >= 8.4
- Composer
- MySQL
- Node.js & NPM

### Langkah Instalasi

1. Clone repository
```bash
git clone <repository-url>
cd ekos-app
```

2. Install dependencies
```bash
composer install
npm install
```

3. Setup environment
```bash
cp .env.example .env
php artisan key:generate
```

4. Konfigurasi database di `.env`
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ekos
DB_USERNAME=root
DB_PASSWORD=
```

5. Jalankan migration dan seeder
```bash
php artisan migrate
php artisan db:seed
```

6. Create storage link
```bash
php artisan storage:link
```

7. Compile assets
```bash
npm run dev
```

8. Jalankan server
```bash
php artisan serve
```

9. Akses aplikasi di `http://localhost:8000`

## 👤 Default User Accounts

Setelah menjalankan seeder, gunakan akun berikut:

### Admin
- Email: `admin@ekos.com`
- Password: `password`

### Pemilik Kos
- Email: `pemilik@ekos.com`
- Password: `password`

### Pencari Kos
- Email: `pencari@ekos.com`
- Password: `password`

## 🎨 Fitur UI/UX

### Landing Page
- Hero section dengan search bar
- Statistik real-time (jumlah kos, pengguna, pemesanan)
- Kos terbaru dan populer
- Quick filter (Kos Putra, Putri, Campur)
- Call-to-action untuk registrasi

### Dashboard
- **Admin**: Statistik lengkap, grafik, aktivitas terbaru
- **Pemilik**: Statistik kos, pemesanan pending, quick actions
- **Pencari**: Riwayat pemesanan, kos favorit

### Responsive Design
- Mobile-friendly navigation
- Adaptive card layouts
- Touch-friendly buttons
- Optimized images

## 🔒 Security Features

- **Password Hashing**: Bcrypt
- **CSRF Protection**: Laravel CSRF tokens
- **SQL Injection Prevention**: Eloquent ORM
- **XSS Protection**: Blade templating
- **Role-based Access Control**: Middleware
- **File Upload Validation**: Image type & size validation
- **Soft Deletes**: Data recovery capability

## 📊 Status & Enum Values

### Status Pemesanan
- `pending`: Menunggu persetujuan pemilik
- `disetujui`: Disetujui, menunggu pembayaran
- `ditolak`: Ditolak oleh pemilik
- `dibayar`: Menunggu verifikasi pembayaran
- `aktif`: Pembayaran terverifikasi, pemesanan aktif
- `selesai`: Pemesanan selesai
- `dibatalkan`: Dibatalkan oleh pencari

### Status Pembayaran
- `pending`: Menunggu verifikasi
- `berhasil`: Terverifikasi
- `gagal`: Ditolak

### Jenis Kos
- `putra`: Khusus laki-laki
- `putri`: Khusus perempuan
- `campur`: Campuran

### Jenis Kamar
- `kamar_mandi_dalam`: Kamar mandi dalam
- `kamar_mandi_luar`: Kamar mandi luar

## 🚀 Fitur Mendatang (Future Development)

- [ ] Notifikasi real-time (WebSocket)
- [ ] Chat antara pemilik dan pencari
- [ ] Payment gateway integration
- [ ] Export laporan ke PDF/Excel
- [ ] Email notifications
- [ ] SMS notifications
- [ ] Mobile app (Flutter/React Native)
- [ ] Advanced analytics dashboard
- [ ] Multi-language support
- [ ] Dark mode

## 📝 License

This project is proprietary software developed for E-Kos Batu Alang.

## 👨‍💻 Developer

Developed with ❤️ for E-Kos Batu Alang

---

**Version**: 1.0.0  
**Last Updated**: November 2025
