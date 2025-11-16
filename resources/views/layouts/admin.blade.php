<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Dashboard') - E-Kos Admin</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link href="{{ asset('template-admin/img/favicon.ico') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('template-admin/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template-admin/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('template-admin/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('template-admin/css/style.css') }}" rel="stylesheet">

    <style>
        /* Custom CKEditor Content Styling */
        .ck-content {
            font-size: 14px;
            line-height: 1.6;
        }
        .ck-content h1 {
            font-size: 2em;
            margin-bottom: 0.5em;
            font-weight: 600;
        }
        .ck-content h2 {
            font-size: 1.5em;
            margin-bottom: 0.5em;
            font-weight: 600;
        }
        .ck-content h3 {
            font-size: 1.25em;
            margin-bottom: 0.5em;
            font-weight: 600;
        }
        .ck-content p {
            margin-bottom: 1em;
        }
        .ck-content ul, .ck-content ol {
            margin-bottom: 1em;
            padding-left: 1.5em;
        }
        .ck-content li {
            margin-bottom: 0.5em;
        }
        .ck-content strong {
            font-weight: 600;
        }
        .ck-content a {
            color: #0d6efd;
            text-decoration: underline;
        }
        .ck-content a:hover {
            color: #0a58ca;
        }
    </style>

    @stack('styles')
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="/" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-home me-2"></i>E-Kos</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        @if(auth()->user()->foto_profil)
                            <img class="rounded-circle" src="{{ asset('storage/' . auth()->user()->foto_profil) }}" alt="" style="width: 40px; height: 40px;">
                        @else
                            <img class="rounded-circle" src="{{ asset('template-admin/img/user.jpg') }}" alt="" style="width: 40px; height: 40px;">
                        @endif
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0">{{ auth()->user()->nama }}</h6>
                        <span>{{ ucfirst(str_replace('_', ' ', auth()->user()->peran)) }}</span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="nav-item nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="fa fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                        <a href="{{ route('admin.pengguna.index') }}" class="nav-item nav-link {{ request()->routeIs('admin.pengguna.*') ? 'active' : '' }}">
                            <i class="fa fa-users me-2"></i>Manajemen Pengguna
                        </a>
                        <a href="{{ route('admin.kos.index') }}" class="nav-item nav-link {{ request()->routeIs('admin.kos.*') ? 'active' : '' }}">
                            <i class="fa fa-home me-2"></i>Manajemen Kos
                        </a>
                        <a href="{{ route('admin.laporan.index') }}" class="nav-item nav-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                            <i class="fa fa-chart-bar me-2"></i>Laporan
                        </a>
                    @elseif(auth()->user()->isPemilikKos())
                        <a href="{{ route('pemilik.dashboard') }}" class="nav-item nav-link {{ request()->routeIs('pemilik.dashboard') ? 'active' : '' }}">
                            <i class="fa fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                        <a href="{{ route('pemilik.kos.index') }}" class="nav-item nav-link {{ request()->routeIs('pemilik.kos.*') ? 'active' : '' }}">
                            <i class="fa fa-home me-2"></i>Data Kos
                        </a>
                        <a href="{{ route('pemilik.pemesanan.index') }}" class="nav-item nav-link {{ request()->routeIs('pemilik.pemesanan.*') ? 'active' : '' }}">
                            <i class="fa fa-calendar-check me-2"></i>Pemesanan
                        </a>
                        <a href="{{ route('pemilik.pengaturan.index') }}" class="nav-item nav-link {{ request()->routeIs('pemilik.pengaturan.*') ? 'active' : '' }}">
                            <i class="fa fa-cog me-2"></i>Pengaturan
                        </a>
                    @elseif(auth()->user()->isPencariKos())
                        <a href="{{ route('home') }}" class="nav-item nav-link">
                            <i class="fa fa-home me-2"></i>Beranda
                        </a>
                        <a href="{{ route('pencarian') }}" class="nav-item nav-link">
                            <i class="fa fa-search me-2"></i>Cari Kos
                        </a>
                        <a href="{{ route('pencari.pemesanan.index') }}" class="nav-item nav-link {{ request()->routeIs('pencari.pemesanan.*') ? 'active' : '' }}">
                            <i class="fa fa-calendar-check me-2"></i>Pemesanan Saya
                        </a>
                        <a href="{{ route('pencari.bookmark.index') }}" class="nav-item nav-link {{ request()->routeIs('pencari.bookmark.*') ? 'active' : '' }}">
                            <i class="fa fa-heart me-2"></i>Favorit
                        </a>
                        <a href="{{ route('pencari.profil.index') }}" class="nav-item nav-link {{ request()->routeIs('pencari.profil.*') ? 'active' : '' }}">
                            <i class="fa fa-user me-2"></i>Profil
                        </a>
                    @endif
                    
                    <!-- Notifikasi untuk semua role -->
                    <a href="{{ route('notifikasi.index') }}" class="nav-item nav-link {{ request()->routeIs('notifikasi.*') ? 'active' : '' }}">
                        <i class="fa fa-bell me-2"></i>Notifikasi
                        @php
                            $unreadCount = auth()->user()->notifikasiBelumDibaca()->count();
                        @endphp
                        @if($unreadCount > 0)
                            <span class="badge bg-danger ms-1">{{ $unreadCount }}</span>
                        @endif
                    </a>
                </div>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <div class="navbar-nav align-items-center ms-auto">
                    <!-- Notifikasi Dropdown -->
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-bell me-lg-2"></i>
                            @php
                                $unreadCount = auth()->user()->notifikasiBelumDibaca()->count();
                            @endphp
                            @if($unreadCount > 0)
                                <span class="badge bg-danger">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0" style="min-width: 350px; max-height: 400px; overflow-y: auto;">
                            <div class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom">
                                <h6 class="mb-0">Notifikasi</h6>
                                @if($unreadCount > 0)
                                    <form action="{{ route('notifikasi.read-all') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-link text-decoration-none p-0">
                                            Tandai semua dibaca
                                        </button>
                                    </form>
                                @endif
                            </div>
                            @forelse(auth()->user()->notifikasi()->latest()->limit(5)->get() as $notif)
                                <a href="{{ $notif->link ?? route('notifikasi.index') }}" 
                                   class="dropdown-item {{ $notif->dibaca ? '' : 'bg-light' }}"
                                   onclick="event.preventDefault(); document.getElementById('notif-form-{{ $notif->id }}').submit();">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-grow-1">
                                            <strong class="d-block">{{ $notif->judul }}</strong>
                                            <small class="text-muted">{{ Str::limit($notif->pesan, 50) }}</small>
                                            <br>
                                            <small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
                                        </div>
                                        @if(!$notif->dibaca)
                                            <span class="badge bg-primary ms-2">Baru</span>
                                        @endif
                                    </div>
                                </a>
                                <form id="notif-form-{{ $notif->id }}" action="{{ route('notifikasi.read', $notif->id) }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            @empty
                                <div class="dropdown-item text-center text-muted py-3">
                                    Tidak ada notifikasi
                                </div>
                            @endforelse
                            <a href="{{ route('notifikasi.index') }}" class="dropdown-item text-center border-top">
                                Lihat Semua Notifikasi
                            </a>
                        </div>
                    </div>

                    <!-- User Dropdown -->
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            @if(auth()->user()->foto_profil)
                                <img class="rounded-circle me-lg-2" src="{{ asset('storage/' . auth()->user()->foto_profil) }}" alt="" style="width: 40px; height: 40px;">
                            @else
                                <img class="rounded-circle me-lg-2" src="{{ asset('template-admin/img/user.jpg') }}" alt="" style="width: 40px; height: 40px;">
                            @endif
                            <span class="d-none d-lg-inline-flex">{{ auth()->user()->nama }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            @if(auth()->user()->isPencariKos())
                                <a href="{{ route('pencari.profil.index') }}" class="dropdown-item">Profil Saya</a>
                            @elseif(auth()->user()->isPemilikKos())
                                <a href="{{ route('pemilik.pengaturan.index') }}" class="dropdown-item">Pengaturan</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item">Keluar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->

            <!-- Page Content Start -->
            <div class="container-fluid pt-4 px-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </div>
            <!-- Page Content End -->

            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">E-Kos</a>, All Right Reserved. 
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            Designed By <a href="#">E-Kos Team</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('template-admin/lib/chart/chart.min.js') }}"></script>
    <script src="{{ asset('template-admin/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('template-admin/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('template-admin/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('template-admin/lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ asset('template-admin/lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
    <script src="{{ asset('template-admin/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('template-admin/js/main.js') }}"></script>

    <!-- CKEditor 4 LTS (Latest Secure Version) -->
    <script src="https://cdn.ckeditor.com/4.25.1-lts/standard/ckeditor.js"></script>

    @stack('scripts')
</body>

</html>
