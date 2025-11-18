@extends('layouts.admin')

@section('title', 'Detail Pemesanan')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Detail Pemesanan: {{ $pemesanan->kode_pemesanan }}</h4>
            <a href="{{ route('pencari.pemesanan.index') }}" class="btn btn-secondary">
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
                    <span class="badge bg-warning fs-6">Menunggu Persetujuan</span>
                @elseif($pemesanan->status == 'disetujui')
                    <span class="badge bg-success fs-6">Disetujui - Silakan Bayar</span>
                @elseif($pemesanan->status == 'dibayar')
                    <span class="badge bg-info fs-6">Menunggu Verifikasi Pembayaran</span>
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
            
            @if($pemesanan->status == 'ditolak' && $pemesanan->alasan_penolakan)
                <div class="alert alert-danger">
                    <strong>Alasan Penolakan:</strong><br>
                    {{ $pemesanan->alasan_penolakan }}
                </div>
            @endif
            
            @if($pemesanan->status == 'pending')
                <div class="alert alert-info">
                    <i class="fa fa-info-circle me-2"></i>
                    Pemesanan Anda sedang menunggu persetujuan dari pemilik kos. Anda akan mendapat notifikasi jika pemesanan disetujui atau ditolak.
                </div>
            @endif
            
            @if($pemesanan->status == 'disetujui')
                @php
                    $pembayaranDitolak = $pemesanan->pembayaran()->where('status', 'gagal')->latest()->first();
                @endphp
                
                @if($pembayaranDitolak)
                    <div class="alert alert-danger">
                        <i class="fa fa-exclamation-triangle me-2"></i>
                        <strong>Pembayaran Anda ditolak!</strong><br>
                        Alasan: {{ $pembayaranDitolak->catatan }}<br>
                        <small>Silakan upload ulang bukti pembayaran yang benar di bawah ini.</small>
                    </div>
                @else
                    <div class="alert alert-success">
                        <i class="fa fa-check-circle me-2"></i>
                        Pemesanan Anda telah disetujui! Silakan lakukan pembayaran dan upload bukti transfer.
                    </div>
                @endif
            @endif
            
            @if($pemesanan->status == 'aktif')
                <div class="alert alert-success">
                    <i class="fa fa-check-circle me-2"></i>
                    Pembayaran Anda telah diverifikasi! Pemesanan sekarang aktif. Anda dapat menghubungi pemilik kos untuk informasi lebih lanjut.
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
                        <td><strong>Catatan</strong></td>
                        <td>: {{ $pemesanan->catatan }}</td>
                    </tr>
                @endif
            </table>
        </div>
        
        <!-- Upload Bukti Pembayaran -->
        @if($pemesanan->status == 'disetujui')
            <div class="bg-light rounded p-4">
                <h6 class="mb-3 border-bottom pb-2">Upload Bukti Pembayaran</h6>
                
                <!-- Informasi Rekening -->
                <div class="alert alert-info mb-4">
                    <h6 class="mb-3"><i class="fa fa-university me-2"></i>Informasi Rekening Tujuan</h6>
                    @if($pemesanan->kos->pemilik->nama_bank && $pemesanan->kos->pemilik->nomor_rekening)
                        <table class="table table-sm table-borderless mb-0">
                            <tr>
                                <td width="40%"><strong>Bank</strong></td>
                                <td>: {{ $pemesanan->kos->pemilik->nama_bank }}</td>
                            </tr>
                            <tr>
                                <td><strong>Nomor Rekening</strong></td>
                                <td>: <strong class="text-primary">{{ $pemesanan->kos->pemilik->nomor_rekening }}</strong></td>
                            </tr>
                            <tr>
                                <td><strong>Atas Nama</strong></td>
                                <td>: {{ $pemesanan->kos->pemilik->nama_pemilik_rekening ?? $pemesanan->kos->pemilik->nama }}</td>
                            </tr>
                            <tr>
                                <td><strong>Jumlah Transfer</strong></td>
                                <td>: <strong class="text-danger fs-5">Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</strong></td>
                            </tr>
                        </table>
                    @else
                        <p class="mb-0"><i class="fa fa-exclamation-triangle me-2"></i>Informasi rekening belum tersedia. Silakan hubungi pemilik kos untuk detail pembayaran.</p>
                    @endif
                </div>
                
                <form action="{{ route('pencari.pemesanan.upload-bukti', $pemesanan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jumlah Dibayar <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('jumlah') is-invalid @enderror" 
                                       name="jumlah" value="{{ old('jumlah', $pemesanan->total_harga) }}" required>
                            </div>
                            @error('jumlah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Bukti Pembayaran <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('bukti_pembayaran') is-invalid @enderror" 
                                   name="bukti_pembayaran" accept="image/*" required>
                            <small class="text-muted">Format: JPG, PNG. Maksimal 2MB</small>
                            @error('bukti_pembayaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-upload me-2"></i>Upload Bukti Pembayaran
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        @endif
        
        <!-- Info Pembayaran (jika sudah upload) -->
        @if($pemesanan->pembayaran && $pemesanan->pembayaran->count() > 0)
            <div class="bg-light rounded p-4 mt-4">
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
    </div>
    
    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Info Pemilik -->
        <div class="bg-light rounded p-4 mb-4">
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
            <h6 class="text-center mb-3">{{ $pemesanan->kos->pemilik->nama }}</h6>
            @if($pemesanan->kos->pemilik->whatsapp)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pemesanan->kos->pemilik->whatsapp) }}" 
                   class="btn btn-success w-100 mb-2" target="_blank">
                    <i class="fab fa-whatsapp me-2"></i>Hubungi via WhatsApp
                </a>
            @endif
            @if($pemesanan->kos->pemilik->telepon)
                <a href="tel:{{ $pemesanan->kos->pemilik->telepon }}" class="btn btn-outline-primary w-100">
                    <i class="fa fa-phone me-2"></i>{{ $pemesanan->kos->pemilik->telepon }}
                </a>
            @endif
        </div>
        
        <!-- Ulasan -->
        @if($pemesanan->status == 'selesai')
            <div class="bg-light rounded p-4 mb-4">
                <h6 class="mb-3 border-bottom pb-2">Ulasan</h6>
                @if($pemesanan->ulasan)
                    <!-- Ulasan sudah ada -->
                    <div class="mb-3">
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
                @else
                    <!-- Form ulasan -->
                    <form action="{{ route('pencari.ulasan.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="pemesanan_id" value="{{ $pemesanan->id }}">
                        
                        <div class="mb-3">
                            <label class="form-label">Rating <span class="text-danger">*</span></label>
                            <div class="rating-input">
                                @for($i = 5; $i >= 1; $i--)
                                    <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}" required>
                                    <label for="star{{ $i }}">
                                        <i class="fas fa-star"></i>
                                    </label>
                                @endfor
                            </div>
                            @error('rating')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Komentar</label>
                            <textarea class="form-control @error('komentar') is-invalid @enderror" 
                                      name="komentar" rows="4" 
                                      placeholder="Bagikan pengalaman Anda...">{{ old('komentar') }}</textarea>
                            @error('komentar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fa fa-paper-plane me-2"></i>Kirim Ulasan
                        </button>
                    </form>
                @endif
            </div>
        @endif
        
        <!-- Aksi -->
        @if(in_array($pemesanan->status, ['pending', 'disetujui']))
            <div class="bg-light rounded p-4">
                <h6 class="mb-3 border-bottom pb-2">Aksi</h6>
                <form action="{{ route('pencari.pemesanan.cancel', $pemesanan->id) }}" method="POST" 
                      onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pemesanan ini?')">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="fa fa-times-circle me-2"></i>Batalkan Pemesanan
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection
