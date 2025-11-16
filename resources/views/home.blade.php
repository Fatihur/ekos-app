@extends('layouts.public')

@section('title', 'Cari Kos Terbaik')

@section('content')
<!-- Hero Start -->
<div class="container-fluid p-0 mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="position-relative" style="min-height: 500px;">
        <!-- Background Image with Overlay -->
        <div class="position-absolute w-100 h-100" 
             style="background: linear-gradient(rgba(0, 185, 142, 0.8), rgba(0, 185, 142, 0.8)), 
                    url('{{ asset('landing-page/img/carousel-1.jpg') }}') center center no-repeat; 
                    background-size: cover;">
        </div>
        
        <!-- Hero Content -->
        <div class="container position-relative" style="padding: 100px 0;">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white mb-4 animated slideInDown">
                        Temukan Kos Impian Anda
                    </h1>
                    <p class="fs-5 text-white mb-5 animated slideInDown">
                        Platform terpercaya untuk mencari dan mengelola kos dengan mudah dan aman
                    </p>
                    
                    <!-- Search Form -->
                    <form action="{{ route('pencarian') }}" method="GET" class="animated slideInUp">
                        <div class="row g-3 justify-content-center">
                            <div class="col-lg-8">
                                <div class="bg-white rounded-pill p-2 shadow-lg">
                                    <div class="input-group">
                                        <span class="input-group-text bg-transparent border-0 ps-4">
                                            <i class="fa fa-search text-primary"></i>
                                        </span>
                                        <input class="form-control border-0 rounded-pill" 
                                               type="text" 
                                               name="kata_kunci" 
                                               placeholder="Cari berdasarkan nama kos atau lokasi..." 
                                               style="height: 50px;">
                                        <button type="submit" 
                                                class="btn btn-primary rounded-pill px-4 me-1" 
                                                style="height: 50px;">
                                            Cari Sekarang
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Quick Filters -->
                        <div class="row g-2 justify-content-center mt-3">
                            <div class="col-auto">
                                <a href="{{ route('pencarian', ['jenis_kos' => 'putra']) }}" 
                                   class="btn btn-light btn-sm rounded-pill px-3">
                                    <i class="fa fa-male me-1"></i> Kos Putra
                                </a>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('pencarian', ['jenis_kos' => 'putri']) }}" 
                                   class="btn btn-light btn-sm rounded-pill px-3">
                                    <i class="fa fa-female me-1"></i> Kos Putri
                                </a>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('pencarian', ['jenis_kos' => 'campur']) }}" 
                                   class="btn btn-light btn-sm rounded-pill px-3">
                                    <i class="fa fa-users me-1"></i> Kos Campur
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Hero End -->

<!-- Stats Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="bg-light rounded text-center p-4">
                    <i class="fa fa-home fa-3x text-primary mb-3"></i>
                    <h2 class="mb-2">{{ \App\Models\Kos::count() }}+</h2>
                    <p class="mb-0">Kos Tersedia</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                <div class="bg-light rounded text-center p-4">
                    <i class="fa fa-users fa-3x text-primary mb-3"></i>
                    <h2 class="mb-2">{{ \App\Models\Pengguna::where('peran', 'pencari_kos')->count() }}+</h2>
                    <p class="mb-0">Pencari Kos</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="bg-light rounded text-center p-4">
                    <i class="fa fa-calendar-check fa-3x text-primary mb-3"></i>
                    <h2 class="mb-2">{{ \App\Models\Pemesanan::count() }}+</h2>
                    <p class="mb-0">Pemesanan</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
                <div class="bg-light rounded text-center p-4">
                    <i class="fa fa-star fa-3x text-primary mb-3"></i>
                    <h2 class="mb-2">{{ \App\Models\Ulasan::count() }}+</h2>
                    <p class="mb-0">Ulasan</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Stats End -->

<!-- Features Start -->
<div class="container-xxl py-5 bg-light">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h1 class="display-6 mb-3">Kenapa Memilih E-Kos?</h1>
            <p class="text-muted">Platform terbaik untuk mencari dan mengelola kos dengan berbagai keunggulan</p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="bg-white rounded p-4 h-100 shadow-sm">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0 btn-square bg-primary rounded-circle me-3" style="width: 60px; height: 60px;">
                            <i class="fa fa-search fa-2x text-white"></i>
                        </div>
                        <h5 class="mb-0">Mudah Dicari</h5>
                    </div>
                    <p class="mb-0">Temukan kos impian dengan mudah menggunakan filter lokasi, harga, fasilitas, dan jenis kos yang Anda inginkan.</p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                <div class="bg-white rounded p-4 h-100 shadow-sm">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0 btn-square bg-primary rounded-circle me-3" style="width: 60px; height: 60px;">
                            <i class="fa fa-shield-alt fa-2x text-white"></i>
                        </div>
                        <h5 class="mb-0">Terpercaya</h5>
                    </div>
                    <p class="mb-0">Semua kos terverifikasi dengan sistem rating dan ulasan dari penghuni sebelumnya untuk memastikan kualitas.</p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="bg-white rounded p-4 h-100 shadow-sm">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0 btn-square bg-primary rounded-circle me-3" style="width: 60px; height: 60px;">
                            <i class="fa fa-calendar-check fa-2x text-white"></i>
                        </div>
                        <h5 class="mb-0">Booking Online</h5>
                    </div>
                    <p class="mb-0">Pesan kos secara online dengan proses yang cepat, mudah, dan aman tanpa perlu datang langsung.</p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
                <div class="bg-white rounded p-4 h-100 shadow-sm">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0 btn-square bg-primary rounded-circle me-3" style="width: 60px; height: 60px;">
                            <i class="fa fa-credit-card fa-2x text-white"></i>
                        </div>
                        <h5 class="mb-0">Pembayaran Mudah</h5>
                    </div>
                    <p class="mb-0">Upload bukti pembayaran dengan mudah dan dapatkan verifikasi cepat dari pemilik kos.</p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="bg-white rounded p-4 h-100 shadow-sm">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0 btn-square bg-primary rounded-circle me-3" style="width: 60px; height: 60px;">
                            <i class="fa fa-heart fa-2x text-white"></i>
                        </div>
                        <h5 class="mb-0">Simpan Favorit</h5>
                    </div>
                    <p class="mb-0">Simpan kos favorit Anda dan akses kapan saja untuk memudahkan perbandingan dan keputusan.</p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.6s">
                <div class="bg-white rounded p-4 h-100 shadow-sm">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0 btn-square bg-primary rounded-circle me-3" style="width: 60px; height: 60px;">
                            <i class="fa fa-headset fa-2x text-white"></i>
                        </div>
                        <h5 class="mb-0">Dukungan 24/7</h5>
                    </div>
                    <p class="mb-0">Tim support kami siap membantu Anda kapan saja untuk memastikan pengalaman terbaik.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Features End -->

<!-- Kos Terbaru Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h1 class="display-6 mb-3">Kos Terbaru</h1>
            <p class="text-muted">Pilihan kos terbaru yang baru saja ditambahkan ke platform kami</p>
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
        
        <div class="text-center mt-5 wow fadeInUp" data-wow-delay="0.1s">
            <a href="{{ route('pencarian') }}" class="btn btn-primary rounded-pill px-5 py-3 shadow">
                <i class="fa fa-search me-2"></i>Lihat Semua Kos
            </a>
        </div>
    </div>
</div>
<!-- Kos Terbaru End -->

<!-- Kos Populer Start -->
<div class="container-xxl py-5 bg-light">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h1 class="display-6 mb-3">Kos Populer</h1>
            <p class="text-muted">Kos dengan rating terbaik dan pemesanan terbanyak dari pengguna kami</p>
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
        <div class="row g-4">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="position-relative h-100 rounded overflow-hidden shadow">
                    <div class="position-absolute w-100 h-100" 
                         style="background: linear-gradient(rgba(0, 185, 142, 0.9), rgba(0, 185, 142, 0.9));">
                    </div>
                    <div class="position-relative p-5 text-white">
                        <div class="mb-4">
                            <i class="fa fa-building fa-4x"></i>
                        </div>
                        <h2 class="text-white mb-3">Punya Kos?</h2>
                        <p class="mb-4 pb-2">Daftarkan kos Anda di E-Kos dan dapatkan lebih banyak penyewa. Proses mudah, cepat, dan gratis!</p>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="fa fa-check-circle me-2"></i>Gratis mendaftarkan kos</li>
                            <li class="mb-2"><i class="fa fa-check-circle me-2"></i>Jangkauan lebih luas</li>
                            <li class="mb-2"><i class="fa fa-check-circle me-2"></i>Kelola pemesanan online</li>
                        </ul>
                        <a href="{{ route('register') }}" class="btn btn-light rounded-pill px-4 py-3">
                            <i class="fa fa-user-plus me-2"></i>Daftar Sebagai Pemilik
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="position-relative h-100 rounded overflow-hidden shadow">
                    <div class="position-absolute w-100 h-100" 
                         style="background: linear-gradient(rgba(25, 28, 36, 0.9), rgba(25, 28, 36, 0.9));">
                    </div>
                    <div class="position-relative p-5 text-white">
                        <div class="mb-4">
                            <i class="fa fa-search fa-4x"></i>
                        </div>
                        <h2 class="text-white mb-3">Cari Kos?</h2>
                        <p class="mb-4 pb-2">Temukan kos impian Anda dengan mudah. Daftar sekarang dan nikmati berbagai fitur lengkap!</p>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="fa fa-check-circle me-2"></i>Pencarian mudah dan cepat</li>
                            <li class="mb-2"><i class="fa fa-check-circle me-2"></i>Booking online praktis</li>
                            <li class="mb-2"><i class="fa fa-check-circle me-2"></i>Simpan kos favorit</li>
                        </ul>
                        <a href="{{ route('register') }}" class="btn btn-primary rounded-pill px-4 py-3">
                            <i class="fa fa-user-plus me-2"></i>Daftar Sebagai Pencari
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Call To Action End -->
@endsection
