@extends('layouts.public')

@section('title', $kos->nama_kos)

@section('content')
<!-- Detail Kos Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8">
                <!-- Foto Utama -->
                <div class="mb-4">
                    @if($kos->foto_utama)
                        <img src="{{ asset('storage/' . $kos->foto_utama) }}" alt="{{ $kos->nama_kos }}" class="img-fluid rounded">
                    @endif
                </div>

                <!-- Galeri Foto -->
                @if($kos->foto->count() > 0)
                <div class="mb-4">
                    <h5>Galeri Foto</h5>
                    <div class="row g-2">
                        @foreach($kos->foto as $foto)
                        <div class="col-md-3">
                            <img src="{{ asset('storage/' . $foto->foto) }}" alt="Foto {{ $foto->urutan }}" class="img-fluid rounded" style="height: 150px; width: 100%; object-fit: cover;">
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Deskripsi -->
                <div class="mb-4">
                    <h5>Deskripsi</h5>
                    <div class="ck-content" style="padding: 0;">
                        {!! $kos->deskripsi !!}
                    </div>
                </div>

                <!-- Fasilitas -->
                @if($kos->fasilitas->count() > 0)
                <div class="mb-4">
                    <h5>Fasilitas</h5>
                    <div class="row">
                        @foreach($kos->fasilitas as $fas)
                        <div class="col-md-4 mb-2">
                            <i class="fa fa-check text-primary me-2"></i>{{ $fas->nama_fasilitas }}
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Peraturan -->
                @if($kos->peraturan)
                <div class="mb-4">
                    <h5>Peraturan</h5>
                    <div class="ck-content" style="padding: 0;">
                        {!! $kos->peraturan !!}
                    </div>
                </div>
                @endif

                <!-- Ulasan -->
                @if($kos->ulasan->count() > 0)
                <div class="mb-4">
                    <h5>Ulasan ({{ $kos->ulasan->count() }})</h5>
                    @foreach($kos->ulasan as $ulasan)
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h6>{{ $ulasan->pengguna->nama }}</h6>
                                <div>
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fa fa-star {{ $i <= $ulasan->rating ? 'text-warning' : 'text-muted' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            <p class="mb-0">{{ $ulasan->komentar }}</p>
                            <small class="text-muted">{{ $ulasan->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            <div class="col-lg-4">
                <!-- Info Kos -->
                <div class="card mb-3">
                    <div class="card-body">
                        <h4 class="mb-3">{{ $kos->nama_kos }}</h4>
                        <h3 class="text-primary mb-3">Rp {{ number_format($kos->harga, 0, ',', '.') }}<small>/bulan</small></h3>
                        
                        <div class="mb-3">
                            <span class="badge bg-info me-2">{{ ucfirst($kos->jenis_kos) }}</span>
                            <span class="badge bg-secondary">{{ str_replace('_', ' ', ucwords($kos->jenis_kamar, '_')) }}</span>
                        </div>

                        <div class="mb-3">
                            <i class="fa fa-door-open text-primary me-2"></i>
                            <strong>{{ $kos->kamar_tersedia }}</strong> dari {{ $kos->jumlah_kamar }} kamar tersedia
                        </div>

                        @if($kos->rating_rata_rata > 0)
                        <div class="mb-3">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa fa-star {{ $i <= $kos->rating_rata_rata ? 'text-warning' : 'text-muted' }}"></i>
                            @endfor
                            <span class="ms-2">{{ number_format($kos->rating_rata_rata, 1) }} ({{ $kos->jumlah_ulasan }} ulasan)</span>
                        </div>
                        @endif

                        @auth
                            @if(auth()->user()->isPencariKos())
                                <div class="d-grid gap-2">
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pesanModal">
                                        <i class="fa fa-calendar-check me-2"></i>Pesan Sekarang
                                    </button>
                                    <form action="{{ route('pencari.bookmark.toggle', $kos->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-primary w-100">
                                            <i class="fa fa-heart{{ $isBookmarked ? ' text-danger' : '' }} me-2"></i>
                                            {{ $isBookmarked ? 'Hapus dari Favorit' : 'Tambah ke Favorit' }}
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @else
                            <div class="d-grid">
                                <a href="{{ route('login') }}" class="btn btn-primary">
                                    <i class="fa fa-sign-in-alt me-2"></i>Login untuk Memesan
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>

                <!-- Info Pemilik -->
                <div class="card mb-3">
                    <div class="card-body">
                        <h6>Pemilik Kos</h6>
                        <p class="mb-1"><strong>{{ $kos->pemilik->nama }}</strong></p>
                        @if($kos->pemilik->telepon)
                        <p class="mb-1"><i class="fa fa-phone me-2"></i>{{ $kos->pemilik->telepon }}</p>
                        @endif
                        @if($kos->pemilik->whatsapp)
                        <a href="https://wa.me/{{ $kos->pemilik->whatsapp }}" target="_blank" class="btn btn-success btn-sm w-100">
                            <i class="fab fa-whatsapp me-2"></i>Hubungi via WhatsApp
                        </a>
                        @endif
                    </div>
                </div>

                <!-- Lokasi -->
                <div class="card">
                    <div class="card-body">
                        <h6>Lokasi</h6>
                        <p class="mb-1">{{ $kos->alamat }}</p>
                        <p class="mb-0">{{ $kos->kota }}, {{ $kos->provinsi }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kos Lainnya -->
        @if($kosLainnya->count() > 0)
        <div class="mt-5">
            <h5 class="mb-4">Kos Lainnya dari Pemilik Ini</h5>
            <div class="row g-4">
                @foreach($kosLainnya as $item)
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="position-relative">
                            @if($item->foto_utama)
                                <img src="{{ asset('storage/' . $item->foto_utama) }}" class="card-img-top" alt="{{ $item->nama_kos }}" style="height: 180px; object-fit: cover;">
                            @endif
                            <span class="position-absolute top-0 end-0 bg-primary text-white px-2 py-1 m-2 rounded">
                                <small><i class="fa fa-home me-1"></i>{{ ucfirst($item->jenis_kos) }}</small>
                            </span>
                        </div>
                        <div class="card-body">
                            <h6 class="card-title mb-2">{{ Str::limit($item->nama_kos, 35) }}</h6>
                            <p class="text-muted mb-2 small">
                                <i class="fa fa-map-marker-alt text-primary me-1"></i>
                                {{ Str::limit($item->alamat . ', ' . $item->kota, 45) }}
                            </p>
                            
                            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                <small class="text-muted">
                                    <i class="fa fa-door-open text-primary me-1"></i>
                                    {{ $item->kamar_tersedia }}/{{ $item->jumlah_kamar }} kamar
                                </small>
                                <small class="text-muted">
                                    <i class="fa fa-star text-warning me-1"></i>
                                    {{ $item->ulasan->count() > 0 ? number_format($item->rating_rata_rata, 1) : 'Baru' }}
                                </small>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-primary mb-0">Rp {{ number_format($item->harga, 0, ',', '.') }}</h6>
                                    <small class="text-muted">per bulan</small>
                                </div>
                                <a href="{{ route('kos.detail', $item->id) }}" class="btn btn-sm btn-primary rounded-pill px-3">
                                    Detail <i class="fa fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
<!-- Detail Kos End -->

<!-- Modal Pemesanan -->
@auth
@if(auth()->user()->isPencariKos())
<div class="modal fade" id="pesanModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pesan Kos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('pencari.pemesanan.store') }}" method="POST">
                @csrf
                <input type="hidden" name="kos_id" value="{{ $kos->id }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tanggal Masuk</label>
                        <input type="date" name="tanggal_masuk" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Durasi Sewa</label>
                        <div class="input-group">
                            <input type="number" name="durasi_sewa" class="form-control" min="1" required>
                            <select name="satuan_durasi" class="form-select">
                                <option value="hari">Hari</option>
                                <option value="bulan" selected>Bulan</option>
                                <option value="tahun">Tahun</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan (Opsional)</label>
                        <textarea name="catatan" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Kirim Pemesanan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endauth
@endsection
