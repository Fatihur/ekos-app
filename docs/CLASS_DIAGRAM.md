# Class Diagram - Sistem E-Kos

## Diagram UML

```mermaid
classDiagram
    %% Enums
    class Peran {
        <<enumeration>>
        admin
        pemilik_kos
        pencari_kos
    }
    
    class StatusPemesanan {
        <<enumeration>>
        pending
        disetujui
        dibayar
        aktif
        selesai
        ditolak
        dibatalkan
    }
    
    class StatusPembayaran {
        <<enumeration>>
        pending
        berhasil
        gagal
    }
    
    class JenisKos {
        <<enumeration>>
        putra
        putri
        campur
    }
    
    class TipeNotifikasi {
        <<enumeration>>
        info
        success
        warning
        danger
    }
    
    %% Main Classes
    class Pengguna {
        +bigint id
        +string nama
        +string email
        +string telepon
        +string password
        +Peran peran
        +string foto_profil
        +text alamat
        +string nomor_rekening
        +string nama_bank
        +string nama_pemilik_rekening
        +string whatsapp
        +boolean aktif
        +timestamp email_verified_at
        +timestamp created_at
        +timestamp updated_at
        +timestamp deleted_at
        --
        +kos() HasMany
        +pemesanan() HasMany
        +ulasan() HasMany
        +bookmark() HasMany
        +notifikasi() HasMany
        +isAdmin() boolean
        +isPemilikKos() boolean
        +isPencariKos() boolean
    }
    
    class Kos {
        +bigint id
        +bigint pemilik_id
        +string nama_kos
        +text deskripsi
        +JenisKos jenis_kos
        +string jenis_kamar
        +decimal harga
        +integer jumlah_kamar
        +integer kamar_tersedia
        +text alamat
        +string google_maps_link
        +string kota
        +string provinsi
        +string kode_pos
        +decimal latitude
        +decimal longitude
        +text peraturan
        +string foto_utama
        +boolean aktif
        +timestamp created_at
        +timestamp updated_at
        +timestamp deleted_at
        --
        +pemilik() BelongsTo
        +fasilitas() BelongsToMany
        +foto() HasMany
        +pemesanan() HasMany
        +ulasan() HasMany
        +bookmark() HasMany
        +getRatingRataRataAttribute() float
        +getJumlahUlasanAttribute() int
    }
    
    class Pemesanan {
        +bigint id
        +bigint kos_id
        +bigint pencari_id
        +string kode_pemesanan
        +date tanggal_masuk
        +integer durasi_sewa
        +string satuan_durasi
        +decimal total_harga
        +StatusPemesanan status
        +text catatan
        +text alasan_penolakan
        +timestamp tanggal_disetujui
        +timestamp tanggal_dibayar
        +timestamp created_at
        +timestamp updated_at
        +timestamp deleted_at
        --
        +kos() BelongsTo
        +pencari() BelongsTo
        +pembayaran() HasMany
        +ulasan() HasOne
    }
    
    class Pembayaran {
        +bigint id
        +bigint pemesanan_id
        +decimal jumlah
        +string bukti_pembayaran
        +StatusPembayaran status
        +text catatan
        +timestamp tanggal_verifikasi
        +timestamp created_at
        +timestamp updated_at
        --
        +pemesanan() BelongsTo
    }
    
    class Ulasan {
        +bigint id
        +bigint kos_id
        +bigint pengguna_id
        +bigint pemesanan_id
        +integer rating
        +text komentar
        +boolean disetujui
        +timestamp created_at
        +timestamp updated_at
        +timestamp deleted_at
        --
        +kos() BelongsTo
        +pengguna() BelongsTo
        +pemesanan() BelongsTo
    }
    
    class Bookmark {
        +bigint id
        +bigint pengguna_id
        +bigint kos_id
        +timestamp created_at
        +timestamp updated_at
        --
        +pengguna() BelongsTo
        +kos() BelongsTo
    }
    
    class Fasilitas {
        +bigint id
        +string nama_fasilitas
        +string ikon
        +timestamp created_at
        +timestamp updated_at
        --
        +kos() BelongsToMany
    }
    
    class FotoKos {
        +bigint id
        +bigint kos_id
        +string foto
        +boolean is_utama
        +integer urutan
        +timestamp created_at
        +timestamp updated_at
        --
        +kos() BelongsTo
    }
    
    class Notifikasi {
        +bigint id
        +bigint pengguna_id
        +string judul
        +text pesan
        +TipeNotifikasi tipe
        +string link
        +boolean dibaca
        +timestamp dibaca_pada
        +timestamp created_at
        +timestamp updated_at
        --
        +pengguna() BelongsTo
        +markAsRead() void
        +kirim() Notifikasi$
    }
    
    %% Relationships
    Pengguna "1" --> "0..*" Kos : memiliki
    Pengguna "1" --> "0..*" Pemesanan : membuat
    Pengguna "1" --> "0..*" Ulasan : menulis
    Pengguna "1" --> "0..*" Bookmark : menyimpan
    Pengguna "1" --> "0..*" Notifikasi : menerima
    
    Kos "1" --> "0..*" Pemesanan : dipesan
    Kos "1" --> "0..*" Ulasan : diulas
    Kos "1" --> "0..*" Bookmark : disimpan
    Kos "1" --> "0..*" FotoKos : memiliki
    Kos "0..*" --> "0..*" Fasilitas : memiliki
    
    Pemesanan "1" --> "0..*" Pembayaran : memiliki
    Pemesanan "1" --> "0..1" Ulasan : memiliki
    
    %% Enum Relationships
    Pengguna --> Peran : uses
    Pemesanan --> StatusPemesanan : uses
    Pembayaran --> StatusPembayaran : uses
    Kos --> JenisKos : uses
    Notifikasi --> TipeNotifikasi : uses
```

## Deskripsi Entitas

### 1. Pengguna
Entitas utama yang merepresentasikan pengguna sistem dengan 3 peran:
- **Admin**: Mengelola seluruh sistem
- **Pemilik Kos**: Mengelola kos dan pemesanan
- **Pencari Kos**: Mencari dan memesan kos

**Atribut Penting:**
- `nomor_rekening`, `nama_bank`, `nama_pemilik_rekening`: Untuk pembayaran
- `whatsapp`: Untuk komunikasi
- `aktif`: Status aktif/nonaktif pengguna

### 2. Kos
Entitas yang merepresentasikan properti kos yang ditawarkan.

**Atribut Penting:**
- `jenis_kos`: Putra, Putri, atau Campur
- `kamar_tersedia`: Jumlah kamar yang masih tersedia
- `latitude`, `longitude`: Koordinat lokasi
- `google_maps_link`: Link ke Google Maps

### 3. Pemesanan
Entitas yang merepresentasikan transaksi pemesanan kos.

**Status Flow:**
1. `pending` → Menunggu persetujuan pemilik
2. `disetujui` → Disetujui, menunggu pembayaran
3. `dibayar` → Sudah bayar, menunggu verifikasi
4. `aktif` → Pembayaran terverifikasi, pemesanan aktif
5. `selesai` → Masa sewa selesai
6. `ditolak` → Ditolak oleh pemilik
7. `dibatalkan` → Dibatalkan oleh pencari

### 4. Pembayaran
Entitas yang merepresentasikan bukti pembayaran dari pencari kos.

**Status:**
- `pending`: Menunggu verifikasi
- `berhasil`: Terverifikasi
- `gagal`: Ditolak

### 5. Ulasan
Entitas yang merepresentasikan review dari pencari kos setelah masa sewa selesai.

**Atribut:**
- `rating`: 1-5 bintang
- `disetujui`: Moderasi oleh admin

### 6. Bookmark
Entitas untuk menyimpan kos favorit pencari.

### 7. Fasilitas
Entitas master fasilitas yang tersedia (WiFi, AC, Parkir, dll).

**Relasi:** Many-to-Many dengan Kos melalui tabel pivot `fasilitas_kos`

### 8. FotoKos
Entitas untuk menyimpan multiple foto kos.

**Atribut:**
- `is_utama`: Menandai foto utama
- `urutan`: Urutan tampilan foto

### 9. Notifikasi
Entitas untuk sistem notifikasi real-time.

**Tipe:**
- `info`: Informasi umum
- `success`: Notifikasi sukses
- `warning`: Peringatan
- `danger`: Notifikasi penting

## Relasi Antar Entitas

### One-to-Many
- Pengguna → Kos (1 pemilik memiliki banyak kos)
- Pengguna → Pemesanan (1 pencari membuat banyak pemesanan)
- Pengguna → Ulasan (1 pengguna menulis banyak ulasan)
- Pengguna → Bookmark (1 pengguna menyimpan banyak bookmark)
- Pengguna → Notifikasi (1 pengguna menerima banyak notifikasi)
- Kos → Pemesanan (1 kos dipesan berkali-kali)
- Kos → Ulasan (1 kos diulas berkali-kali)
- Kos → FotoKos (1 kos memiliki banyak foto)
- Pemesanan → Pembayaran (1 pemesanan bisa memiliki banyak pembayaran)

### One-to-One
- Pemesanan → Ulasan (1 pemesanan hanya bisa diulas 1 kali)

### Many-to-Many
- Kos ↔ Fasilitas (Banyak kos memiliki banyak fasilitas)

## Fitur Utama Sistem

1. **Manajemen Pengguna**: Multi-role (Admin, Pemilik, Pencari)
2. **Manajemen Kos**: CRUD kos dengan foto dan fasilitas
3. **Sistem Pemesanan**: Flow pemesanan dengan status tracking
4. **Sistem Pembayaran**: Upload dan verifikasi bukti transfer
5. **Sistem Ulasan**: Rating dan review dengan moderasi
6. **Bookmark**: Simpan kos favorit
7. **Notifikasi**: Real-time notification system
8. **Geolokasi**: Integrasi Google Maps

## Teknologi

- **Framework**: Laravel 11
- **Database**: MySQL
- **Authentication**: Laravel Sanctum/Breeze
- **Storage**: Laravel Storage (Public Disk)
- **Soft Deletes**: Untuk data recovery
