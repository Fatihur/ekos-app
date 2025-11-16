@extends('layouts.admin')

@section('title', 'Detail Pemesanan')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Detail Pemesanan: {{ $pemesanan->kode_pemesanan }}</h4>
            <a href="{{ route('pemilik.pemesanan.index') }}" class="btn btn-secondary">
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
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Status Pemesanan</h6>
                @if($pemesanan->status == 'pending')
                    <span class="badge bg-warning fs-6">Menunggu Persetujuan Anda</span>
                @elseif($pemesanan->status == 'disetujui')
                    <span class="badge bg-success fs-6">Disetujui - Menunggu Pembayaran</span>
                @elseif($pemesanan->status == 'dibayar')
                    <span class="badge bg-info fs-6">Perlu Verifikasi Pembayaran</span>
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
            
            @if($pemesanan->status == 'pending')
                <div class="alert alert-warning">
                    <i class="fa fa-exclamation-triangle me-2"></i>
                    Pemesanan ini menunggu persetujuan Anda. Silakan setujui atau tolak.
                </div>
            @endif
            
            @if($pemesanan->status == 'dibayar')
                <div class="alert alert-info">
                    <i class="fa fa-info-circle me-2"></i>
                    Penyewa telah mengupload bukti pembayaran. Silakan verifikasi pembayaran.
                </div>
            @endif
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
                        <td><strong>Catatan dari Penyewa</strong></td>
                        <td>: {{ $pemesanan->catatan }}</td>
                    </tr>
                @endif
                @if($pemesanan->tanggal_disetujui)
                    <tr>
                        <td><strong>Tanggal Disetujui</strong></td>
                        <td>: {{ $pemesanan->tanggal_disetujui->format('d/m/Y H:i') }}</td>
                    </tr>
                @endif
                @if($pemesanan->alasan_penolakan)
                    <tr>
                        <td><strong>Alasan Penolakan</strong></td>
                        <td>: {{ $pemesanan->alasan_penolakan }}</td>
                    </tr>
                @endif
            </table>
        </div>
        
        <!-- Info Pembayaran -->
        @if($pemesanan->pembayaran && $pemesanan->pembayaran->count() > 0)
            <div class="bg-light rounded p-4">
                <h6 class="mb-3 border-bottom pb-2">Bukti Pembayaran</h6>
                @foreach($pemesanan->pembayaran as $bayar)
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="{{ asset('storage/' . $bayar->bukti_pembayaran) }}" 
                                         class="img-fluid rounded" alt="Bukti Pembayaran"
                                         style="cursor: pointer;" 
                                         onclick="window.open('{{ asset('storage/' . $bayar->bukti_pembayaran) }}', '_blank')">
                                    <small class="text-muted d-block mt-1">Klik untuk memperbesar</small>
                                </div>
                                <div class="col-md-8">
                                    <p class="mb-2"><strong>Jumlah:</strong> Rp {{ number_format($bayar->jumlah, 0, ',', '.') }}</p>
                                    <p class="mb-2"><strong>Metode:</strong> Transfer Bank</p>
                                    <p class="mb-2"><strong>Tanggal Upload:</strong> {{ $bayar->created_at->format('d/m/Y H:i') }}</p>
                                    <p class="mb-2">
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
                                        <div class="alert alert-danger mb-0">
                                            <small><strong>Alasan Penolakan:</strong> {{ $bayar->catatan }}</small>
                                        </div>
                                    @endif
                                    @if($bayar->status == 'berhasil' && $bayar->tanggal_verifikasi)
                                        <p class="mb-0 text-success">
                                            <small><i class="fa fa-check-circle me-1"></i>Diverifikasi pada {{ $bayar->tanggal_verifikasi->format('d/m/Y H:i') }}</small>
                                        </p>
                                    @endif
                                    
                                    @if($bayar->status == 'pending' && $pemesanan->status == 'dibayar')
                                        <div class="mt-3">
                                            <button class="btn btn-success btn-sm me-2" data-bs-toggle="modal" data-bs-target="#verifyModal">
                                                <i class="fa fa-check me-1"></i>Verifikasi
                                            </button>
                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectPaymentModal">
                                                <i class="fa fa-times me-1"></i>Tolak
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    
    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Info Penyewa -->
        <div class="bg-light rounded p-4 mb-4">
            <h6 class="mb-3 border-bottom pb-2">Penyewa</h6>
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
            <h6 class="text-center mb-3">{{ $pemesanan->pencari->nama }}</h6>
            <p class="mb-2 text-center"><small>{{ $pemesanan->pencari->email }}</small></p>
            @if($pemesanan->pencari->whatsapp)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pemesanan->pencari->whatsapp) }}" 
                   class="btn btn-success w-100 mb-2" target="_blank">
                    <i class="fab fa-whatsapp me-2"></i>Hubungi via WhatsApp
                </a>
            @endif
            @if($pemesanan->pencari->telepon)
                <a href="tel:{{ $pemesanan->pencari->telepon }}" class="btn btn-outline-primary w-100">
                    <i class="fa fa-phone me-2"></i>{{ $pemesanan->pencari->telepon }}
                </a>
            @endif
        </div>
        
        <!-- Aksi -->
        <div class="bg-light rounded p-4">
            <h6 class="mb-3 border-bottom pb-2">Aksi</h6>
            
            @if($pemesanan->status == 'pending')
                <button class="btn btn-success w-100 mb-2" data-bs-toggle="modal" data-bs-target="#approveModal">
                    <i class="fa fa-check-circle me-2"></i>Setujui Pemesanan
                </button>
                <button class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#rejectModal">
                    <i class="fa fa-times-circle me-2"></i>Tolak Pemesanan
                </button>
            @endif
            
            @if($pemesanan->status == 'aktif')
                <button class="btn btn-secondary w-100" data-bs-toggle="modal" data-bs-target="#completeModal">
                    <i class="fa fa-flag-checkered me-2"></i>Tandai Selesai
                </button>
            @endif
        </div>
    </div>
</div>

<!-- Modal Approve -->
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Setujui Pemesanan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('pemilik.pemesanan.approve', $pemesanan->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menyetujui pemesanan ini?</p>
                    <p class="mb-0"><strong>Kamar tersedia saat ini:</strong> {{ $pemesanan->kos->kamar_tersedia }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Ya, Setujui</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Reject -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Tolak Pemesanan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('pemilik.pemesanan.reject', $pemesanan->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Silakan berikan alasan penolakan:</p>
                    <textarea class="form-control" name="alasan_penolakan" rows="4" required 
                              placeholder="Contoh: Kamar sudah penuh, jadwal tidak sesuai, dll"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak Pemesanan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Verify Payment -->
<div class="modal fade" id="verifyModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Verifikasi Pembayaran</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('pemilik.pemesanan.verify-payment', $pemesanan->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Apakah Anda yakin pembayaran sudah sesuai dan akan memverifikasi pembayaran ini?</p>
                    <p class="mb-0"><small class="text-muted">Setelah diverifikasi, status pemesanan akan berubah menjadi AKTIF.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Ya, Verifikasi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Reject Payment -->
<div class="modal fade" id="rejectPaymentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Tolak Pembayaran</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('pemilik.pemesanan.reject-payment', $pemesanan->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Silakan berikan alasan penolakan pembayaran:</p>
                    <textarea class="form-control" name="alasan_penolakan" rows="4" required 
                              placeholder="Contoh: Nominal tidak sesuai, bukti tidak jelas, dll"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak Pembayaran</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Complete -->
<div class="modal fade" id="completeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title">Selesaikan Pemesanan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('pemilik.pemesanan.complete', $pemesanan->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Tandai pemesanan ini sebagai selesai?</p>
                    <p class="mb-0"><small class="text-muted">Kamar akan dikembalikan ke status tersedia.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Ya, Selesaikan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
