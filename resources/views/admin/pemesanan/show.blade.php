@extends('layouts.admin')

@section('title', 'Detail Pemesanan')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Detail Pemesanan: {{ $pemesanan->kode_pemesanan }}</h4>
            <a href="{{ route('admin.pemesanan.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Info Pemesanan -->
    <div class="col-lg-8">
        <!-- Status Card -->
        <div class="bg-light rounded p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Status Pemesanan</h6>
                @if($pemesanan->status == 'pending')
                    <span class="badge bg-warning fs-6">Pending</span>
                @elseif($pemesanan->status == 'disetujui')
                    <span class="badge bg-success fs-6">Disetujui</span>
                @elseif($pemesanan->status == 'dibayar')
                    <span class="badge bg-info fs-6">Dibayar</span>
                @elseif($pemesanan->status == 'aktif')
                    <span class="badge bg-primary fs-6">Aktif</span>
                @elseif($pemesanan->status == 'selesai')
                    <span class="badge bg-secondary fs-6">Selesai</span>
                @elseif($pemesanan->status == 'ditolak')
                    <span class="badge bg-danger fs-6">Ditolak</span>
                @elseif($pemesanan->status == 'dibatalkan')
                    <span class="badge bg-dark fs-6">Dibatalkan</span>
                @endif
            </div>
        </div>
        
        <!-- Detail Kos -->
        <div class="bg-light rounded p-4 mb-4">
            <h6 class="mb-3 border-bottom pb-2">Informasi Kos</h6>
            <div class="row">
                <div class="col-md-4">
                    @if($pemesanan->kos->foto_utama)
                        <img src="{{ asset('storage/' . $pemesanan->kos->foto_utama) }}" 
                             class="img-fluid rounded" alt="{{ $pemesanan->kos->nama_kos }}">
                    @else
                        <div class="bg-secondary rounded" style="height: 150px;"></div>
                    @endif
                </div>
                <div class="col-md-8">
                    <h5>{{ $pemesanan->kos->nama_kos }}</h5>
                    <p class="mb-2">
                        <i class="fa fa-map-marker-alt text-primary me-2"></i>
                        {{ $pemesanan->kos->alamat }}, {{ $pemesanan->kos->kota }}
                    </p>
                    <p class="mb-2">
                        <i class="fa fa-home text-primary me-2"></i>
                        Jenis: {{ ucfirst($pemesanan->kos->jenis_kos) }}
                    </p>
                    <p class="mb-0">
                        <i class="fa fa-money-bill text-primary me-2"></i>
                        Harga: Rp {{ number_format($pemesanan->kos->harga, 0, ',', '.') }}/{{ $pemesanan->kos->jenis_kamar }}
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Detail Pemesanan -->
        <div class="bg-light rounded p-4 mb-4">
            <h6 class="mb-3 border-bottom pb-2">Detail Pemesanan</h6>
            <table class="table table-borderless mb-0">
                <tr>
                    <td width="40%"><strong>Kode Pemesanan</strong></td>
                    <td>: {{ $pemesanan->kode_pemesanan }}</td>
                </tr>
                <tr>
                    <td><strong>Tanggal Pesan</strong></td>
                    <td>: {{ $pemesanan->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                <tr>
                    <td><strong>Tanggal Masuk</strong></td>
                    <td>: {{ $pemesanan->tanggal_masuk->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td><strong>Durasi Sewa</strong></td>
                    <td>: {{ $pemesanan->durasi_sewa }} {{ $pemesanan->satuan_durasi }}</td>
                </tr>
                <tr>
                    <td><strong>Total Harga</strong></td>
                    <td>: <strong class="text-primary fs-5">Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</strong></td>
                </tr>
                @if($pemesanan->catatan)
                    <tr>
                        <td><strong>Catatan</strong></td>
                        <td>: {{ $pemesanan->catatan }}</td>
                    </tr>
                @endif
            </table>
        </div>
        
        <!-- Info Pembayaran -->
        @if($pemesanan->pembayaran && $pemesanan->pembayaran->count() > 0)
            <div class="bg-light rounded p-4 mb-4">
                <h6 class="mb-3 border-bottom pb-2">Riwayat Pembayaran</h6>
                @foreach($pemesanan->pembayaran as $bayar)
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="{{ asset('storage/' . $bayar->bukti_pembayaran) }}" 
                                         class="img-fluid rounded" alt="Bukti Pembayaran">
                                </div>
                                <div class="col-md-8">
                                    <p class="mb-2"><strong>Jumlah:</strong> Rp {{ number_format($bayar->jumlah, 0, ',', '.') }}</p>
                                    <p class="mb-2"><strong>Metode:</strong> Transfer Bank</p>
                                    <p class="mb-2"><strong>Tanggal Upload:</strong> {{ $bayar->created_at->format('d/m/Y H:i') }}</p>
                                    <p class="mb-0">
                                        <strong>Status:</strong>
                                        @if($bayar->status == 'pending')
                                            <span class="badge bg-warning">Menunggu Verifikasi</span>
                                        @elseif($bayar->status == 'berhasil')
                                            <span class="badge bg-success">Berhasil Diverifikasi</span>
                                        @elseif($bayar->status == 'gagal')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </p>
                                    @if($bayar->status == 'gagal' && $bayar->catatan)
                                        <div class="alert alert-danger mt-2 mb-0">
                                            <small><strong>Alasan Penolakan:</strong> {{ $bayar->catatan }}</small>
                                        </div>
                                    @endif
                                    @if($bayar->status == 'berhasil' && $bayar->tanggal_verifikasi)
                                        <p class="mt-2 mb-0 text-success">
                                            <small><i class="fa fa-check-circle me-1"></i>Diverifikasi pada {{ $bayar->tanggal_verifikasi->format('d/m/Y H:i') }}</small>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Ulasan -->
        @if($pemesanan->ulasan)
            <div class="bg-light rounded p-4">
                <h6 class="mb-3 border-bottom pb-2">Ulasan</h6>
                <div class="mb-2">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $pemesanan->ulasan->rating)
                            <i class="fas fa-star text-warning"></i>
                        @else
                            <i class="far fa-star text-warning"></i>
                        @endif
                    @endfor
                    <span class="ms-2">({{ $pemesanan->ulasan->rating }}/5)</span>
                </div>
                @if($pemesanan->ulasan->komentar)
                    <p class="mb-2">{{ $pemesanan->ulasan->komentar }}</p>
                @endif
                <small class="text-muted">Ditulis pada {{ $pemesanan->ulasan->created_at->format('d/m/Y') }}</small>
            </div>
        @endif
    </div>
    
    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Info Pencari -->
        <div class="bg-light rounded p-4 mb-4">
            <h6 class="mb-3 border-bottom pb-2">Pencari Kos</h6>
            <div class="text-center mb-3">
                @if($pemesanan->pencari->foto_profil)
                    <img src="{{ asset('storage/' . $pemesanan->pencari->foto_profil) }}" 
                         class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                @else
                    <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center"
                         style="width: 80px; height: 80px;">
                        <i class="fa fa-user fa-2x"></i>
                    </div>
                @endif
            </div>
            <h6 class="text-center mb-2">{{ $pemesanan->pencari->nama }}</h6>
            <p class="text-center text-muted mb-3">{{ $pemesanan->pencari->email }}</p>
            @if($pemesanan->pencari->no_telepon)
                <p class="text-center mb-0">
                    <i class="fa fa-phone me-2"></i>{{ $pemesanan->pencari->no_telepon }}
                </p>
            @endif
        </div>
        
        <!-- Info Pemilik -->
        <div class="bg-light rounded p-4">
            <h6 class="mb-3 border-bottom pb-2">Pemilik Kos</h6>
            <div class="text-center mb-3">
                @if($pemesanan->kos->pemilik->foto_profil)
                    <img src="{{ asset('storage/' . $pemesanan->kos->pemilik->foto_profil) }}" 
                         class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                @else
                    <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center"
                         style="width: 80px; height: 80px;">
                        <i class="fa fa-user fa-2x"></i>
                    </div>
                @endif
            </div>
            <h6 class="text-center mb-2">{{ $pemesanan->kos->pemilik->nama }}</h6>
            <p class="text-center text-muted mb-3">{{ $pemesanan->kos->pemilik->email }}</p>
            @if($pemesanan->kos->pemilik->no_telepon)
                <p class="text-center mb-0">
                    <i class="fa fa-phone me-2"></i>{{ $pemesanan->kos->pemilik->no_telepon }}
                </p>
            @endif
        </div>
    </div>
</div>
@endsection
