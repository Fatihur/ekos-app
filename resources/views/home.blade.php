@extends('layouts.public')

@section('title', 'Cari Kos Terbaik')

@section('content')
<!-- Hero Start -->
<div class="container-fluid bg-primary hero-header mb-5">
    <div class="container text-center">
        <h1 class="display-4 text-white mb-3 animated slideInDown">Temukan Kos Impian Anda</h1>
        <p class="fs-5 fw-medium text-white mb-4 pb-3">Platform terpercaya untuk mencari dan mengelola kos di Batu Alang</p>
        
        <!-- Search Form -->
        <form action="{{ route('pencarian') }}" method="GET">
            <div class="position-relative w-75 mx-auto animated slideInDown">
                <div class="input-group">
                    <input class="form-control border-0 rounded-pill w-100 ps-4 pe-5" type="text" 
                           name="kata_kunci" placeholder="Cari kos berdasarkan nama atau lokasi..." 
                           style="height: 58px;">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 position-absolute top-0 end-0 mt-2 me-2">
                        <i class="fa fa-search"></i> Cari
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Hero End -->

<!-- Features Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-12 wow fadeInUp" data-wow-delay="0.1s">
                <div class="section-title mb-4">
                    <h1 class="display-6 mb-4">Kenapa Memilih E-Kos?</h1>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="bg-light p-4 rounded">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fa fa-search fa-2x text-primary me-3"></i>
                                <h5 class="mb-0">Mudah Dicari</h5>
                            </div>
                            <p class="mb-0">Temukan kos dengan mudah menggunakan filter lokasi, harga, dan fasilitas.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-light p-4 rounded">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fa fa-shield-alt fa-2x text-primary me-3"></i>
                                <h5 class="mb-0">Terpercaya</h5>
                            </div>
                            <p class="mb-0">Semua kos terverifikasi dengan sistem rating dan ulasan dari penghuni.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-light p-4 rounded">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fa fa-calendar-check fa-2x text-primary me-3"></i>
                                <h5 class="mb-0">Booking Online</h5>
                            </div>
                            <p class="mb-0">Pesan kos secara online dengan proses yang cepat dan aman.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Features End -->

<!-- Kos Terbaru Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="section-title text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <h1 class="display-6 mb-4">Kos Terbaru</h1>
            <p>Pilihan kos terbaru yang baru saja ditambahkan</p>
        </div>
        
        @if($kosTerbaru->count() > 0)
            <div class="row g-4">
                @foreach($kosTerbaru as $kos)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="service-item rounded h-100">
                            <div class="service-img rounded-top position-relative">
                                @if($kos->foto_utama)
                                    <img src="{{ asset('storage/' . $kos->foto_utama) }}" class="img-fluid rounded-top w-100" alt="{{ $kos->nama_kos }}" style="height: 200px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('landing-page/img/service-1.jpg') }}" class="img-fluid rounded-top w-100" alt="{{ $kos->nama_kos }}" style="height: 200px; object-fit: cover;">
                                @endif
                                <span class="position-absolute top-0 end-0 bg-primary text-white px-2 py-1 m-2 rounded">
                                    <small><i class="fa fa-home me-1"></i>{{ ucfirst($kos->jenis_kos) }}</small>
                                </span>
                            </div>
                            <div class="service-detail position-relative rounded-bottom p-3">
                                <h5 class="mb-2">{{ Str::limit($kos->nama_kos, 30) }}</h5>
                                <p class="text-muted mb-2 small">
                                    <i class="fa fa-map-marker-alt text-primary me-1"></i>
                                    {{ Str::limit($kos->alamat . ', ' . $kos->kota, 40) }}
                                </p>
                                
                                <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                    <small class="text-muted">
                                        <i class="fa fa-door-open text-primary me-1"></i>
                                        {{ $kos->kamar_tersedia }}/{{ $kos->jumlah_kamar }} kamar
                                    </small>
                                    <small class="text-muted">
                                        <i class="fa fa-star text-warning me-1"></i>
                                        {{ $kos->ulasan_count > 0 ? number_format($kos->rating_rata_rata, 1) . ' (' . $kos->ulasan_count . ')' : 'Belum ada ulasan' }}
                                    </small>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="text-primary mb-0">Rp {{ number_format($kos->harga, 0, ',', '.') }}</h5>
                                        <small class="text-muted">per bulan</small>
                                    </div>
                                    <a class="btn btn-primary btn-sm rounded-pill px-3" href="{{ route('kos.detail', $kos->id) }}">
                                        Detail <i class="fa fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center">
                <p class="text-muted">Belum ada kos tersedia saat ini.</p>
            </div>
        @endif
        
        <div class="text-center mt-4">
            <a href="{{ route('pencarian') }}" class="btn btn-primary rounded-pill px-5 py-3">
                Lihat Semua Kos <i class="fa fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</div>
<!-- Kos Terbaru End -->

<!-- Kos Populer Start -->
<div class="container-xxl py-5 bg-light">
    <div class="container">
        <div class="section-title text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <h1 class="display-6 mb-4">Kos Populer</h1>
            <p>Kos dengan pemesanan terbanyak</p>
        </div>
        
        @if($kosPopuler->count() > 0)
            <div class="row g-4">
                @foreach($kosPopuler as $kos)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="service-item rounded h-100">
                            <div class="service-img rounded-top position-relative">
                                @if($kos->foto_utama)
                                    <img src="{{ asset('storage/' . $kos->foto_utama) }}" class="img-fluid rounded-top w-100" alt="{{ $kos->nama_kos }}" style="height: 200px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('landing-page/img/service-2.jpg') }}" class="img-fluid rounded-top w-100" alt="{{ $kos->nama_kos }}" style="height: 200px; object-fit: cover;">
                                @endif
                                <span class="position-absolute top-0 start-0 bg-danger text-white px-2 py-1 m-2 rounded">
                                    <small><i class="fa fa-fire me-1"></i>Populer</small>
                                </span>
                                <span class="position-absolute top-0 end-0 bg-primary text-white px-2 py-1 m-2 rounded">
                                    <small><i class="fa fa-home me-1"></i>{{ ucfirst($kos->jenis_kos) }}</small>
                                </span>
                                
                                @auth
                                    @if(auth()->user()->isPencariKos())
                                        @php
                                            $isBookmarked = auth()->user()->bookmarks()->where('kos_id', $kos->id)->exists();
                                        @endphp
                                        <form action="{{ route('pencari.bookmark.toggle', $kos->id) }}" method="POST" 
                                              class="position-absolute bottom-0 end-0 m-2">
                                            @csrf
                                            <button type="submit" class="btn btn-sm rounded-circle shadow" 
                                                    style="width: 35px; height: 35px; background: white;"
                                                    title="{{ $isBookmarked ? 'Hapus dari favorit' : 'Tambah ke favorit' }}">
                                                <i class="fa{{ $isBookmarked ? 's' : 'r' }} fa-heart text-danger"></i>
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                            <div class="service-detail position-relative rounded-bottom p-3">
                                <h5 class="mb-2">{{ Str::limit($kos->nama_kos, 30) }}</h5>
                                <p class="text-muted mb-2 small">
                                    <i class="fa fa-map-marker-alt text-primary me-1"></i>
                                    {{ Str::limit($kos->alamat . ', ' . $kos->kota, 40) }}
                                </p>
                                
                                <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                    <small class="text-muted">
                                        <i class="fa fa-door-open text-primary me-1"></i>
                                        {{ $kos->kamar_tersedia }}/{{ $kos->jumlah_kamar }} kamar
                                    </small>
                                    <small class="text-muted">
                                        <i class="fa fa-star text-warning me-1"></i>
                                        {{ $kos->ulasan_count > 0 ? number_format($kos->rating_rata_rata, 1) . ' (' . $kos->ulasan_count . ')' : 'Belum ada ulasan' }}
                                    </small>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="text-primary mb-0">Rp {{ number_format($kos->harga, 0, ',', '.') }}</h5>
                                        <small class="text-muted">per bulan</small>
                                    </div>
                                    <a class="btn btn-primary btn-sm rounded-pill px-3" href="{{ route('kos.detail', $kos->id) }}">
                                        Detail <i class="fa fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center">
                <p class="text-muted">Belum ada data kos populer.</p>
            </div>
        @endif
    </div>
</div>
<!-- Kos Populer End -->

<!-- Call To Action Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                <div class="bg-primary text-white p-5 rounded">
                    <h2 class="text-white mb-4">Punya Kos?</h2>
                    <p class="mb-4">Daftarkan kos Anda di E-Kos dan dapatkan lebih banyak penyewa. Proses mudah dan cepat!</p>
                    <a href="{{ route('register') }}" class="btn btn-light rounded-pill px-5 py-3">
                        Daftar Sebagai Pemilik <i class="fa fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-6 wow fadeIn" data-wow-delay="0.3s">
                <div class="bg-light p-5 rounded">
                    <h2 class="mb-4">Cari Kos?</h2>
                    <p class="mb-4">Temukan kos impian Anda dengan mudah. Daftar sekarang dan nikmati fitur pencarian lengkap!</p>
                    <a href="{{ route('register') }}" class="btn btn-primary rounded-pill px-5 py-3">
                        Daftar Sebagai Pencari <i class="fa fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Call To Action End -->
@endsection
