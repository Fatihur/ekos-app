@extends('layouts.public')

@section('title', 'Pencarian Kos')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid page-header py-5 mb-5">
    <div class="container py-5">
        <h1 class="display-3 text-white mb-3 animated slideInDown">Cari Kos</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="text-white" href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Pencarian</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- Search & Filter Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="bg-light rounded p-4 mb-5">
            <form action="{{ route('pencarian') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="kata_kunci" 
                               placeholder="Nama kos atau lokasi..." 
                               value="{{ request('kata_kunci') }}">
                    </div>
                    <div class="col-md-2">
                        <select class="form-select" name="jenis_kos">
                            <option value="">Semua Jenis</option>
                            <option value="putra" {{ request('jenis_kos') == 'putra' ? 'selected' : '' }}>Putra</option>
                            <option value="putri" {{ request('jenis_kos') == 'putri' ? 'selected' : '' }}>Putri</option>
                            <option value="campur" {{ request('jenis_kos') == 'campur' ? 'selected' : '' }}>Campur</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="number" class="form-control" name="harga_min" 
                               placeholder="Harga Min" value="{{ request('harga_min') }}">
                    </div>
                    <div class="col-md-2">
                        <input type="number" class="form-control" name="harga_max" 
                               placeholder="Harga Max" value="{{ request('harga_max') }}">
                    </div>
                    <div class="col-md-3">
                        <div class="d-grid gap-2 d-md-flex">
                            <button type="submit" class="btn btn-primary flex-fill">
                                <i class="fa fa-search me-2"></i>Cari
                            </button>
                            <a href="{{ route('pencarian') }}" class="btn btn-secondary">
                                <i class="fa fa-redo me-2"></i>Reset
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        @if(request()->hasAny(['kata_kunci', 'jenis_kos', 'harga_min', 'harga_max']))
            <div class="mb-4">
                <h6>Hasil Pencarian: {{ $kosList->total() }} kos ditemukan</h6>
                @if(request('kata_kunci'))
                    <span class="badge bg-primary">{{ request('kata_kunci') }}</span>
                @endif
                @if(request('jenis_kos'))
                    <span class="badge bg-primary">{{ ucfirst(request('jenis_kos')) }}</span>
                @endif
                @if(request('harga_min'))
                    <span class="badge bg-primary">Min: Rp {{ number_format(request('harga_min'), 0, ',', '.') }}</span>
                @endif
                @if(request('harga_max'))
                    <span class="badge bg-primary">Max: Rp {{ number_format(request('harga_max'), 0, ',', '.') }}</span>
                @endif
            </div>
        @endif

        @if($kosList->count() > 0)
            <div class="row g-4">
                @foreach($kosList as $kos)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="service-item rounded h-100">
                            <div class="service-img rounded-top position-relative">
                                @if($kos->foto_utama)
                                    <img src="{{ asset('storage/' . $kos->foto_utama) }}" 
                                         class="img-fluid rounded-top w-100" alt="{{ $kos->nama_kos }}" 
                                         style="height: 200px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('landing-page/img/service-1.jpg') }}" 
                                         class="img-fluid rounded-top w-100" alt="{{ $kos->nama_kos }}" 
                                         style="height: 200px; object-fit: cover;">
                                @endif
                                @if($kos->kamar_tersedia == 0)
                                    <span class="position-absolute top-0 start-0 bg-danger text-white px-2 py-1 m-2 rounded">
                                        <small><i class="fa fa-times-circle me-1"></i>Penuh</small>
                                    </span>
                                @elseif($kos->kamar_tersedia <= 2)
                                    <span class="position-absolute top-0 start-0 bg-warning text-white px-2 py-1 m-2 rounded">
                                        <small><i class="fa fa-exclamation-triangle me-1"></i>Sisa {{ $kos->kamar_tersedia }}</small>
                                    </span>
                                @endif
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
                                        {{ $kos->ulasan->count() > 0 ? number_format($kos->rating_rata_rata, 1) . ' (' . $kos->ulasan->count() . ')' : 'Belum ada ulasan' }}
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

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-5">
                {{ $kosList->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fa fa-search fa-4x text-muted mb-4"></i>
                <h4 class="mb-3">Tidak ada kos ditemukan</h4>
                <p class="text-muted mb-4">Coba ubah filter pencarian Anda atau lihat semua kos yang tersedia.</p>
                <a href="{{ route('pencarian') }}" class="btn btn-primary rounded-pill px-5">
                    Lihat Semua Kos
                </a>
            </div>
        @endif
    </div>
</div>
<!-- Search & Filter End -->
@endsection
