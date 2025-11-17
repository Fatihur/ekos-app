<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Cari Kos') - E-Kos</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link href="{{ asset('landing-page/img/favicon.ico') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;600;800&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"> 

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('landing-page/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('landing-page/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('landing-page/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('landing-page/css/style.css') }}" rel="stylesheet">

    <!-- Custom Responsive Styles -->
    <style>
        /* ========== GLOBAL RESPONSIVE UTILITIES ========== */
        
        /* Responsive Container */
        @media (max-width: 576px) {
            .container, .container-xxl {
                padding-left: 15px;
                padding-right: 15px;
            }
        }

        /* Responsive Cards */
        .service-item, .property-item {
            transition: all 0.3s ease;
        }

        .service-item:hover, .property-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.1) !important;
        }

        /* Responsive Images */
        img {
            max-width: 100%;
            height: auto;
        }

        /* Responsive Text */
        @media (max-width: 768px) {
            .display-1 { font-size: 2.5rem; }
            .display-2 { font-size: 2.25rem; }
            .display-3 { font-size: 2rem; }
            .display-4 { font-size: 1.75rem; }
            .display-5 { font-size: 1.5rem; }
            .display-6 { font-size: 1.25rem; }
            
            h1 { font-size: 1.75rem; }
            h2 { font-size: 1.5rem; }
            h3 { font-size: 1.25rem; }
            h4 { font-size: 1.1rem; }
            h5 { font-size: 1rem; }
        }

        /* Responsive Spacing */
        @media (max-width: 576px) {
            .py-5 { padding-top: 2.5rem !important; padding-bottom: 2.5rem !important; }
            .my-5 { margin-top: 2.5rem !important; margin-bottom: 2.5rem !important; }
        }

        /* Responsive Buttons */
        @media (max-width: 576px) {
            .btn {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }
            
            .btn-lg {
                padding: 0.75rem 1.5rem;
            }
        }

        /* Responsive Hero Section */
        @media (max-width: 768px) {
            .hero-header {
                min-height: 400px !important;
            }
            
            .hero-header h1 {
                font-size: 2rem !important;
            }
            
            .hero-header p {
                font-size: 1rem !important;
            }
        }

        /* Responsive Search Bar */
        @media (max-width: 576px) {
            .input-group .form-control {
                font-size: 0.9rem;
            }
            
            .input-group .btn {
                padding: 0.5rem 1rem;
                font-size: 0.85rem;
            }
        }

        /* Responsive Grid */
        @media (max-width: 768px) {
            .row.g-4 {
                --bs-gutter-x: 1rem;
                --bs-gutter-y: 1rem;
            }
            
            .row.g-5 {
                --bs-gutter-x: 1.5rem;
                --bs-gutter-y: 1.5rem;
            }
        }

        /* Responsive Modal */
        @media (max-width: 576px) {
            .modal-dialog {
                margin: 0.5rem;
                max-width: calc(100% - 1rem);
            }
        }

        /* Responsive Tables */
        @media (max-width: 768px) {
            .table {
                font-size: 0.85rem;
            }
            
            .table th, .table td {
                padding: 0.5rem;
            }
        }

        /* Rating Input Responsive */
        .rating-input {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
            gap: 5px;
        }
        
        .rating-input input[type="radio"] {
            display: none;
        }
        
        .rating-input label {
            cursor: pointer;
            font-size: 24px;
            color: #ddd;
            transition: color 0.2s;
        }
        
        @media (max-width: 576px) {
            .rating-input label {
                font-size: 20px;
            }
        }
        
        .rating-input label:hover,
        .rating-input label:hover ~ label,
        .rating-input input[type="radio"]:checked ~ label {
            color: #ffc107;
        }

        /* Responsive Navbar */
        @media (max-width: 991px) {
            .navbar-nav {
                padding: 1rem 0;
            }
            
            .navbar-nav .nav-link {
                padding: 0.5rem 1rem;
            }
        }

        /* Responsive Stats Cards */
        @media (max-width: 576px) {
            .bg-light.rounded.text-center {
                padding: 1.5rem 1rem !important;
            }
            
            .bg-light.rounded.text-center i {
                font-size: 2rem !important;
            }
            
            .bg-light.rounded.text-center h2 {
                font-size: 1.5rem !important;
            }
        }

        /* Responsive Feature Cards */
        @media (max-width: 768px) {
            .bg-white.rounded.p-4 {
                padding: 1.5rem !important;
            }
            
            .btn-square {
                width: 50px !important;
                height: 50px !important;
            }
            
            .btn-square i {
                font-size: 1.5rem !important;
            }
        }

        /* Utility Classes */
        .text-truncate-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .text-truncate-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Hide/Show on Mobile */
        @media (max-width: 768px) {
            .hide-mobile { display: none !important; }
        }

        .show-mobile { display: none !important; }
        
        @media (max-width: 768px) {
            .show-mobile { display: block !important; }
        }
    </style>

    <style>
        /* Custom CKEditor Display Styling */
        .ck-content {
            font-size: 16px;
            line-height: 1.8;
        }
        .ck-content h1 {
            font-size: 2em;
            margin-bottom: 0.5em;
            font-weight: 600;
            color: #191C24;
        }
        .ck-content h2 {
            font-size: 1.5em;
            margin-bottom: 0.5em;
            font-weight: 600;
            color: #191C24;
        }
        .ck-content h3 {
            font-size: 1.25em;
            margin-bottom: 0.5em;
            font-weight: 600;
            color: #191C24;
        }
        .ck-content p {
            margin-bottom: 1em;
            color: #666;
        }
        .ck-content ul, .ck-content ol {
            margin-bottom: 1em;
            padding-left: 2em;
        }
        .ck-content li {
            margin-bottom: 0.5em;
            color: #666;
        }
        .ck-content strong {
            font-weight: 600;
            color: #191C24;
        }
        .ck-content a {
            color: #00B98E;
            text-decoration: underline;
        }
        .ck-content a:hover {
            color: #009270;
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top px-4 px-lg-5">
        <a href="{{ route('home') }}" class="navbar-brand d-flex align-items-center">
            <h1 class="m-0"><i class="fa fa-home text-primary me-3"></i>E-Kos</h1>
        </a>
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav mx-auto bg-light pe-4 py-3 py-lg-0">
                <a href="{{ route('home') }}" class="nav-item nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
                <a href="{{ route('pencarian') }}" class="nav-item nav-link {{ request()->routeIs('pencarian') ? 'active' : '' }}">Cari Kos</a>
                
                @auth
                    @if(auth()->user()->isPencariKos())
                        <a href="{{ route('pencari.pemesanan.index') }}" class="nav-item nav-link {{ request()->routeIs('pencari.pemesanan.*') ? 'active' : '' }}">Pemesanan Saya</a>
                        <a href="{{ route('pencari.bookmark.index') }}" class="nav-item nav-link {{ request()->routeIs('pencari.bookmark.*') ? 'active' : '' }}">Bookmark</a>
                    @endif
                @endauth
            </div>
            
            @guest
                <div class="h-100 d-lg-inline-flex align-items-center d-none">
                    <a class="btn btn-primary rounded-pill py-2 px-4 ms-3" href="{{ route('login') }}">Masuk</a>
                    <a class="btn btn-outline-primary rounded-pill py-2 px-4 ms-2" href="{{ route('register') }}">Daftar</a>
                </div>
            @else
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="fa fa-user me-2"></i>{{ auth()->user()->nama }}
                    </a>
                    <div class="dropdown-menu bg-light border-0 m-0">
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="dropdown-item">Dashboard Admin</a>
                        @elseif(auth()->user()->isPemilikKos())
                            <a href="{{ route('pemilik.dashboard') }}" class="dropdown-item">Dashboard Pemilik</a>
                        @else
                            <a href="{{ route('pencari.profil.index') }}" class="dropdown-item">Profil Saya</a>
                            <a href="{{ route('pencari.pemesanan.index') }}" class="dropdown-item">Pemesanan Saya</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="dropdown-item">Keluar</button>
                        </form>
                    </div>
                </div>
            @endguest
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Page Content Start -->
    @if(session('success'))
        <div class="container-fluid bg-success text-white py-2">
            <div class="container">
                <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="container-fluid bg-danger text-white py-2">
            <div class="container">
                <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
            </div>
        </div>
    @endif

    @yield('content')
    <!-- Page Content End -->

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer mt-5 py-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-4 col-md-6">
                    <h4 class="text-white mb-4">E-Kos</h4>
                    <p>Platform terpercaya untuk mencari dan mengelola kos di Batu Alang. Hubungkan pemilik kos dengan pencari kos dengan mudah dan aman.</p>
                    
                </div>
                <div class="col-lg-4 col-md-6">
                    <h4 class="text-white mb-4">Link Cepat</h4>
                    <a class="btn btn-link" href="{{ route('home') }}">Beranda</a>
                    <a class="btn btn-link" href="{{ route('pencarian') }}">Cari Kos</a>
                    @guest
                        <a class="btn btn-link" href="{{ route('login') }}">Masuk</a>
                        <a class="btn btn-link" href="{{ route('register') }}">Daftar</a>
                    @endguest
                </div>
                
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Copyright Start -->
   
    <!-- Copyright End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i class="bi bi-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('landing-page/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('landing-page/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('landing-page/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('landing-page/lib/counterup/counterup.min.js') }}"></script>
    <script src="{{ asset('landing-page/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('landing-page/lib/parallax/parallax.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('landing-page/js/main.js') }}"></script>

    @stack('scripts')
</body>

</html>
