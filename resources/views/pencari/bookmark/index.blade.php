@extends('layouts.public')

@section('title', 'Kos Favorit Saya')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('landing-page/img/carousel-1.jpg') }}') center center no-repeat; background-size: cover;">
    <div class="container text-center py-5">
        <h1 class="display-3 text-white mb-4 animated slideInDown">Kos Favorit Saya</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Favorit</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- Bookmark Section Start -->
<div class="container-xxl py-5">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($bookmarks->count() > 0)
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <h1 class="display-6 mb-3">{{ $bookmarks->total() }} Kos Favorit</h1>
                <p class="mb-0">Kos yang Anda simpan sebagai favorit</p>
            </div>

            <div class="row g-4">
                @foreach($bookmarks as $bookmark)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="property-item rounded overflow-hidden shadow-sm h-100">
                            <div class="position-relative overflow-hidden">
                                @if($bookmark->kos->foto_utama)
                                    <a href="{{ route('kos.detail', $bookmark->kos->id) }}">
                                        <img class="img-fluid" src="{{ asset('storage/' . $bookmark->kos->foto_utama) }}" 
                                             alt="{{ $bookmark->kos->nama_kos }}"
                                             style="height: 250px; width: 100%; object-fit: cover;">
                                    </a>
                                @else
                                    <div class="bg-secondary" style="height: 250px;"></div>
                                @endif
                                
                                <div class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3">
                                    {{ ucfirst($bookmark->kos->jenis_kos) }}
                                </div>
                                
                                <form action="{{ route('pencari.bookmark.toggle', $bookmark->kos->id) }}" method="POST" 
                                      class="position-absolute end-0 top-0 m-4"
                                      onsubmit="return confirm('Hapus kos ini dari favorit?')">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm rounded-circle" 
                                            style="width: 40px; height: 40px;" title="Hapus dari favorit">
                                        <i class="fas fa-heart"></i>
                                    </button>
                                </form>
                            </div>
                            
                            <div class="p-4 pb-0">
                                <h5 class="mb-3">
                                    <a href="{{ route('kos.detail', $bookmark->kos->id) }}" class="text-dark">
                                        {{ $bookmark->kos->nama_kos }}
                                    </a>
                                </h5>
                                
                                <p class="text-muted mb-2">
                                    <i class="fa fa-map-marker-alt text-primary me-2"></i>
                                    {{ $bookmark->kos->kota }}, {{ $bookmark->kos->provinsi }}
                                </p>
                                
                                <div class="d-flex mb-3">
                                    <small class="flex-fill text-center border-end py-2">
                                        <i class="fa fa-bed text-primary me-2"></i>
                                        {{ $bookmark->kos->kamar_tersedia }}/{{ $bookmark->kos->jumlah_kamar }} Kamar
                                    </small>
                                    <small class="flex-fill text-center py-2">
                                        <i class="fa fa-bath text-primary me-2"></i>
                                        {{ ucfirst($bookmark->kos->jenis_kamar) }}
                                    </small>
                                </div>
                                
                                @if($bookmark->kos->rating_rata_rata > 0)
                                    <div class="mb-3">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $bookmark->kos->rating_rata_rata)
                                                <i class="fas fa-star text-warning"></i>
                                            @else
                                                <i class="far fa-star text-warning"></i>
                                            @endif
                                        @endfor
                                        <small class="text-muted ms-2">
                                            ({{ $bookmark->kos->ulasan->count() }} ulasan)
                                        </small>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="d-flex border-top p-4">
                                <div class="flex-grow-1">
                                    <h5 class="text-primary mb-0">Rp {{ number_format($bookmark->kos->harga, 0, ',', '.') }}</h5>
                                    <small class="text-muted">/{{ $bookmark->kos->jenis_kamar }}</small>
                                </div>
                                <a class="btn btn-primary rounded-pill px-4" href="{{ route('kos.detail', $bookmark->kos->id) }}">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-5">
                {{ $bookmarks->links() }}
            </div>
        @else
            <div class="text-center py-5 wow fadeInUp" data-wow-delay="0.1s">
                <div class="bg-light rounded p-5" style="max-width: 600px; margin: 0 auto;">
                    <i class="fa fa-heart fa-5x text-primary mb-4"></i>
                    <h3 class="mb-3">Belum Ada Kos Favorit</h3>
                    <p class="text-muted mb-4">Anda belum menyimpan kos apapun sebagai favorit. Mulai cari kos impian Anda dan simpan sebagai favorit!</p>
                    <a href="{{ route('pencarian') }}" class="btn btn-primary rounded-pill py-3 px-5">
                        <i class="fa fa-search me-2"></i>Cari Kos Sekarang
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
<!-- Bookmark Section End -->
@endsection
