# Cara Testing Aplikasi E-Kos

## Prerequisites

Pastikan sudah menjalankan:
```bash
# 1. Setup database
CREATE DATABASE ekos_db;

# 2. Di folder ekos-app
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link
php artisan serve
```

## URL Testing

```
Homepage          : http://localhost:8000
Login             : http://localhost:8000/login
Register          : http://localhost:8000/register
Pencarian         : http://localhost:8000/pencarian
```

## Test Login Accounts

### 1. Test sebagai Admin
```
URL: http://localhost:8000/login
Email: admin@ekos.com
Password: admin123
```

**Fitur yang bisa ditest:**
- ✅ Dashboard admin dengan statistik
- ✅ Lihat total user (admin, pemilik, pencari)
- ✅ Lihat total kos
- ✅ Lihat total pemesanan

### 2. Test sebagai Pemilik Kos
```
URL: http://localhost:8000/login
Email: budi@ekos.com
Password: pemilik123
```

**Fitur yang bisa ditest:**
- ✅ Dashboard pemilik dengan statistik kos pribadi
- ✅ **CRUD Kos Lengkap:**
  - ✅ Tambah kos baru (form lengkap)
  - ✅ Upload foto utama & galeri
  - ✅ Pilih multiple fasilitas
  - ✅ Set harga, lokasi, peraturan
  - ✅ Lihat daftar kos dengan pagination
  - ✅ Edit kos
  - ✅ Hapus kos (dengan konfirmasi)
  - ✅ Lihat detail kos
- ✅ Sidebar navigation
- ✅ Quick action buttons

### 3. Test sebagai Pencari Kos
```
URL: http://localhost:8000/login
Email: siti@ekos.com
Password: pencari123
```

**Fitur yang bisa ditest:**
- ✅ Landing page dengan showcase kos
- ✅ Pencarian kos dengan filter:
  - Kata kunci (nama/lokasi)
  - Jenis kos (putra/putri/campur)
  - Range harga
- ✅ Lihat daftar hasil pencarian
- ✅ Pagination hasil
- ✅ View cards kos dengan info lengkap

### 4. Test sebagai Guest (Tanpa Login)
```
URL: http://localhost:8000
```

**Fitur yang bisa ditest:**
- ✅ Landing page
- ✅ Showcase kos terbaru (6 items)
- ✅ Showcase kos populer (6 items)
- ✅ Search bar di hero section
- ✅ Features section
- ✅ Call to action
- ✅ Register form
- ✅ Login form

## Test Flow: CRUD Kos (Pemilik)

### A. Tambah Kos Baru

1. Login sebagai pemilik kos
2. Klik "Tambah Kos Baru" di dashboard atau sidebar "Data Kos"
3. Isi form:
   ```
   Nama Kos: Kos Sejahtera
   Jenis Kos: Putra
   Jenis Kamar: Bulanan
   Deskripsi: Kos nyaman dekat kampus
   Harga: 1500000
   Jumlah Kamar: 10
   Kamar Tersedia: 10
   Alamat: Jl. Contoh No. 123
   Kota: Jakarta
   Provinsi: DKI Jakarta
   ```
4. Pilih fasilitas (WiFi, AC, dll)
5. Upload foto utama (required)
6. Upload foto tambahan (optional, max 10)
7. Centang "Aktifkan kos"
8. Klik "Simpan Kos"
9. **Expected**: Redirect ke halaman index dengan message sukses

### B. Lihat Daftar Kos

1. Dari dashboard, klik "Lihat Semua Kos"
2. **Expected**: Tampil tabel dengan:
   - Foto thumbnail
   - Nama kos
   - Jenis & lokasi
   - Harga per bulan
   - Status kamar (tersedia/penuh)
   - Status aktif/tidak aktif
   - Action buttons (view, edit, delete)
3. Test pagination jika ada banyak kos

### C. Edit Kos

1. Dari daftar kos, klik tombol edit (icon pensil kuning)
2. Form akan terisi dengan data kos existing
3. Ubah beberapa field (misal: harga, deskripsi)
4. Upload foto tambahan baru (optional)
5. Klik "Simpan Perubahan"
6. **Expected**: Redirect ke index dengan message sukses

### D. Lihat Detail Kos

1. Dari daftar kos, klik tombol view (icon mata biru)
2. **Expected**: Tampil detail lengkap:
   - Semua informasi kos
   - Galeri foto
   - Fasilitas
   - Lokasi
   - Statistik pemesanan

### E. Hapus Kos

1. Dari daftar kos, klik tombol delete (icon trash merah)
2. **Expected**: Muncul konfirmasi JavaScript
3. Klik "OK"
4. **Expected**: 
   - Kos dihapus dari database
   - Foto-foto dihapus dari storage
   - Redirect ke index dengan message sukses

## Test Flow: Pencarian (Public/Pencari)

### A. Search dari Homepage

1. Buka homepage (tanpa login)
2. Ketik "Jakarta" di search bar hero
3. Klik tombol "Cari"
4. **Expected**: Redirect ke halaman pencarian dengan hasil

### B. Search dengan Filter

1. Buka http://localhost:8000/pencarian
2. Test berbagai kombinasi filter:
   ```
   Kata Kunci: Sejahtera
   Jenis Kos: Putra
   Harga Min: 1000000
   Harga Max: 2000000
   ```
3. Klik "Cari"
4. **Expected**: Hasil terfilter sesuai kriteria
5. Klik "Reset" - **Expected**: Kembali ke semua hasil

### C. View Kos Card

1. Dari hasil pencarian, perhatikan setiap card menampilkan:
   - ✅ Foto kos
   - ✅ Nama kos
   - ✅ Lokasi (kota, provinsi)
   - ✅ Jenis kos (badge)
   - ✅ Rating atau "Baru"
   - ✅ Harga per periode
   - ✅ Fasilitas (max 4 + count)
   - ✅ Status ketersediaan (badge)
   - ✅ Button "Lihat Detail"
2. Jika login sebagai pencari, tampil juga button "Simpan"

## Test Validasi Form

### A. Form Tambah Kos - Required Fields

1. Login sebagai pemilik
2. Buka form tambah kos
3. Coba submit tanpa isi field required
4. **Expected**: Error messages muncul:
   - "Nama kos wajib diisi"
   - "Jenis kos wajib dipilih"
   - "Foto utama wajib diupload"
   - dll

### B. Form Tambah Kos - File Upload

1. Coba upload file bukan gambar (PDF, DOC)
2. **Expected**: Error "File harus berupa gambar"
3. Coba upload gambar > 2MB
4. **Expected**: Error "Ukuran foto maksimal 2MB"
5. Coba upload lebih dari 10 foto tambahan
6. **Expected**: Error "Maksimal 10 foto tambahan"

### C. Form Login - Validation

1. Buka login form
2. Coba login dengan email salah
3. **Expected**: Error "Email atau password salah"
4. Coba tanpa isi field
5. **Expected**: Error "Email wajib diisi"

### D. Form Register - Validation

1. Buka register form
2. Coba password kurang dari 8 karakter
3. **Expected**: Error "Password minimal 8 karakter"
4. Password & confirm password tidak sama
5. **Expected**: Error validasi
6. Email sudah terdaftar
7. **Expected**: Error "Email sudah digunakan"

## Test UI/UX

### A. Responsive Design

Test di berbagai ukuran layar:
- Desktop (1920px)
- Tablet (768px)
- Mobile (375px)

**Check:**
- ✅ Navbar collapse di mobile
- ✅ Sidebar toggle di admin
- ✅ Card grid responsive
- ✅ Table responsive dengan scroll
- ✅ Form layout stack di mobile

### B. Navigation

1. **Guest Navigation:**
   - Home → Login → Register → Back to Home
   - Search → View results → Back
   
2. **Admin Navigation:**
   - Login → Dashboard → Logout → Home
   - Check sidebar menu active state
   
3. **Pemilik Navigation:**
   - Dashboard → Data Kos → Create → Back
   - Dashboard → Data Kos → Edit → Back

### C. Flash Messages

Test bahwa flash messages muncul untuk:
- ✅ Login berhasil
- ✅ Register berhasil
- ✅ Kos ditambahkan
- ✅ Kos diupdate
- ✅ Kos dihapus
- ✅ Foto dihapus
- ✅ Error validasi

### D. Loading States

1. Check spinner muncul saat:
   - Page load pertama kali
   - Submit form
   - Upload file (jika file besar)

## Test Database Integration

### A. Check Data Relationships

1. Tambah kos dengan fasilitas
2. Check di database:
   ```sql
   SELECT * FROM kos WHERE pemilik_id = 2;
   SELECT * FROM fasilitas_kos WHERE kos_id = [id_kos];
   SELECT * FROM foto_kos WHERE kos_id = [id_kos];
   ```
3. **Expected**: Data tersimpan dengan benar

### B. Check Soft Deletes

1. Hapus kos
2. Check di database:
   ```sql
   SELECT * FROM kos WHERE id = [id_kos];
   ```
3. **Expected**: Record masih ada tapi deleted_at terisi

### C. Check File Storage

1. Tambah kos dengan foto
2. Check folder:
   ```
   storage/app/public/kos/
   storage/app/public/kos/galeri/
   ```
3. **Expected**: File foto tersimpan
4. Hapus kos
5. **Expected**: File foto juga terhapus

## Test Authorization

### A. Role-Based Access

1. Login sebagai pencari kos
2. Coba akses: http://localhost:8000/pemilik/dashboard
3. **Expected**: Error 403 Forbidden

4. Login sebagai pemilik kos
5. Coba akses: http://localhost:8000/admin/dashboard
6. **Expected**: Error 403 Forbidden

### B. Ownership Check

1. Login sebagai pemilik A (budi)
2. Catat ID kos pemilik A
3. Logout, login sebagai pemilik lain (jika ada)
4. Coba akses edit kos pemilik A:
   `http://localhost:8000/pemilik/kos/[id]/edit`
5. **Expected**: Error 403 atau Not Found

## Test Edge Cases

### A. Empty States

1. Login sebagai pemilik baru (register baru)
2. **Expected**: Dashboard menampilkan "Belum ada kos"
3. Halaman data kos menampilkan empty state dengan CTA

### B. Pagination

1. Tambahkan 15+ kos
2. Check halaman index kos
3. **Expected**: Pagination muncul (10 per page)
4. Test navigation antar page

### C. Search No Results

1. Search dengan keyword tidak ada
2. **Expected**: Tampil message "Tidak ada kos ditemukan"
3. CTA "Lihat Semua Kos"

## Performance Testing (Basic)

### A. Upload Speed

1. Upload foto 2MB
2. **Expected**: Upload selesai < 5 detik (tergantung koneksi)

### B. Page Load

1. Homepage dengan 6 kos
2. **Expected**: Load < 2 detik
3. Pencarian dengan 12 kos
4. **Expected**: Load < 2 detik

### C. Query Performance

1. Tambahkan 50+ kos
2. Check dashboard load time
3. **Expected**: Masih responsive < 3 detik

## Troubleshooting Common Issues

### 1. "Class 'Storage' not found"
```bash
# Make sure storage link exists
php artisan storage:link
```

### 2. "Target class [KosController] does not exist"
```bash
# Clear config cache
php artisan config:clear
php artisan route:clear
```

### 3. Upload foto error
```bash
# Check folder permissions
chmod -R 775 storage
```

### 4. Database error
```bash
# Re-run migrations
php artisan migrate:fresh --seed
```

### 5. CSS/JS not loading
```bash
# Check if files exist in public folder
ls -la public/template-admin/
ls -la public/landing-page/
```

## Checklist Testing Complete

- [ ] Login/Register berfungsi untuk semua role
- [ ] Dashboard menampilkan statistik yang benar
- [ ] CRUD Kos lengkap (Create, Read, Update, Delete)
- [ ] Upload foto berhasil dan file tersimpan
- [ ] Validasi form bekerja dengan benar
- [ ] Pencarian dengan filter berfungsi
- [ ] Pagination bekerja
- [ ] Authorization berdasarkan role
- [ ] Flash messages muncul
- [ ] Responsive di berbagai device
- [ ] Empty states ditampilkan
- [ ] Soft delete berfungsi
- [ ] Foto terhapus saat kos dihapus

## Status Testing

Setelah testing, catat hasil di sini:

```
✅ Authentication: PASS
✅ CRUD Kos: PASS
✅ Validation: PASS
✅ File Upload: PASS
✅ Search & Filter: PASS
✅ Authorization: PASS
✅ Responsive: PASS
✅ Database: PASS
```

---

**Happy Testing!** 🚀
