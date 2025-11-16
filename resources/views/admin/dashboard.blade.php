@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="bg-light rounded h-100 p-4">
            <h6 class="mb-4">Selamat Datang, {{ auth()->user()->nama }}!</h6>
            <p>Dashboard Admin E-Kos - Kelola seluruh sistem dari sini.</p>
        </div>
    </div>
</div>

<!-- Statistik Cards -->
<div class="row g-4 mt-2">
    <div class="col-sm-6 col-xl-3">
        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
            <i class="fa fa-user-shield fa-3x text-primary"></i>
            <div class="ms-3">
                <p class="mb-2">Total Admin</p>
                <h6 class="mb-0">{{ $totalAdmin }}</h6>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
            <i class="fa fa-user-tie fa-3x text-primary"></i>
            <div class="ms-3">
                <p class="mb-2">Pemilik Kos</p>
                <h6 class="mb-0">{{ $totalPemilikKos }}</h6>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
            <i class="fa fa-users fa-3x text-primary"></i>
            <div class="ms-3">
                <p class="mb-2">Pencari Kos</p>
                <h6 class="mb-0">{{ $totalPencariKos }}</h6>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
            <i class="fa fa-home fa-3x text-primary"></i>
            <div class="ms-3">
                <p class="mb-2">Total Kos</p>
                <h6 class="mb-0">{{ $totalKos }}</h6>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-2">
    <div class="col-sm-6 col-xl-3">
        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
            <i class="fa fa-check-circle fa-3x text-success"></i>
            <div class="ms-3">
                <p class="mb-2">Kos Aktif</p>
                <h6 class="mb-0">{{ $kosAktif }}</h6>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
            <i class="fa fa-calendar-check fa-3x text-primary"></i>
            <div class="ms-3">
                <p class="mb-2">Total Pemesanan</p>
                <h6 class="mb-0">{{ $totalPemesanan }}</h6>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
            <i class="fa fa-clock fa-3x text-warning"></i>
            <div class="ms-3">
                <p class="mb-2">Pemesanan Pending</p>
                <h6 class="mb-0">{{ $pemesananPending }}</h6>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
            <i class="fa fa-chart-line fa-3x text-info"></i>
            <div class="ms-3">
                <p class="mb-2">Tingkat Hunian</p>
                <h6 class="mb-0">
                    @if($totalKos > 0)
                        {{ number_format(($kosAktif / $totalKos) * 100, 1) }}%
                    @else
                        0%
                    @endif
                </h6>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row g-4 mt-2">
    <div class="col-12">
        <div class="bg-light rounded h-100 p-4">
            <h6 class="mb-4">Aksi Cepat</h6>
            <div class="row g-3">
                <div class="col-md-3">
                    <a href="{{ route('admin.pengguna.index') }}" class="btn btn-primary w-100">
                        <i class="fa fa-users me-2"></i>Kelola Pengguna
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('admin.kos.index') }}" class="btn btn-primary w-100">
                        <i class="fa fa-home me-2"></i>Kelola Kos
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('admin.pemesanan.index') }}" class="btn btn-primary w-100">
                        <i class="fa fa-calendar-check me-2"></i>Lihat Pemesanan
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('admin.laporan.index') }}" class="btn btn-primary w-100">
                        <i class="fa fa-chart-bar me-2"></i>Lihat Laporan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row g-4 mt-2">
    <div class="col-12">
        <div class="bg-light rounded h-100 p-4">
            <h6 class="mb-4">Aktivitas Terbaru</h6>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Waktu</th>
                            <th scope="col">Aktivitas</th>
                            <th scope="col">User</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4" class="text-center text-muted">Tidak ada aktivitas terbaru</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
