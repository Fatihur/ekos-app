@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@push('styles')
<style>
    .dashboard-welcome {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .dashboard-welcome h6 {
        font-size: 1.1rem;
    }

    .dashboard-welcome p {
        margin-bottom: 0;
        color: #6c757d;
    }

    .stat-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        min-height: 120px;
        padding: 1.25rem;
    }

    .stat-card i {
        flex-shrink: 0;
    }

    .stat-card .stat-label {
        font-size: 0.95rem;
        margin-bottom: 0.3rem;
    }

    .stat-card .stat-value {
        font-size: 1.35rem;
        font-weight: 600;
        margin-bottom: 0;
    }

    @media (max-width: 575.98px) {
        .stat-card {
            flex-direction: column;
            text-align: center;
            padding: 1rem;
        }

        .stat-card i {
            margin-bottom: 0.5rem;
        }

        .stat-card .stat-value {
            font-size: 1.15rem;
        }
    }

    .quick-actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 0.75rem;
    }

    .quick-action-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.35rem;
        min-height: 54px;
        border-radius: 999px;
        font-weight: 500;
        transition: transform 0.2s ease;
    }

    .quick-action-btn:hover {
        transform: translateY(-1px);
    }

    @media (max-width: 575.98px) {
        .quick-action-btn {
            font-size: 0.9rem;
            min-height: 48px;
        }
    }

    .activity-table .table {
        margin-bottom: 0;
    }

    @media (max-width: 767.98px) {
        .activity-table .table thead {
            display: none;
        }

        .activity-table .table tbody tr {
            display: block;
            border-bottom: 1px solid #e9ecef;
            margin-bottom: 0.75rem;
            padding-bottom: 0.75rem;
        }

        .activity-table .table tbody tr:last-child {
            margin-bottom: 0;
        }

        .activity-table .table tbody td {
            display: flex;
            justify-content: space-between;
            padding: 0.4rem 0;
            font-size: 0.9rem;
        }

        .activity-table .table tbody td::before {
            font-weight: 600;
            margin-right: 1rem;
            color: #6c757d;
        }

        .activity-table .table tbody td:nth-child(1)::before { content: "Waktu"; }
        .activity-table .table tbody td:nth-child(2)::before { content: "Aktivitas"; }
        .activity-table .table tbody td:nth-child(3)::before { content: "User"; }
        .activity-table .table tbody td:nth-child(4)::before { content: "Status"; }

        .activity-table .table tbody td[colspan] {
            display: block;
            text-align: center;
            padding: 0.5rem 0;
        }

        .activity-table .table tbody td[colspan]::before {
            display: none;
            content: "";
        }
    }
</style>
@endpush

@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="bg-light rounded h-100 p-4 dashboard-welcome">
            <h6 class="mb-4">Selamat Datang, {{ auth()->user()->nama }}!</h6>
            <p>Dashboard Admin E-Kos - Kelola seluruh sistem dari sini.</p>
        </div>
    </div>
</div>

<!-- Statistik Cards -->
<div class="row g-4 mt-2">
    <div class="col-sm-6 col-xl-3">
        <div class="bg-light rounded stat-card">
            <i class="fa fa-user-shield fa-3x text-primary"></i>
            <div class="ms-3">
                <p class="mb-2 stat-label">Total Admin</p>
                <p class="mb-0 stat-value">{{ $totalAdmin }}</p>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="bg-light rounded stat-card">
            <i class="fa fa-user-tie fa-3x text-primary"></i>
            <div class="ms-3">
                <p class="mb-2 stat-label">Pemilik Kos</p>
                <p class="mb-0 stat-value">{{ $totalPemilikKos }}</p>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="bg-light rounded stat-card">
            <i class="fa fa-users fa-3x text-primary"></i>
            <div class="ms-3">
                <p class="mb-2 stat-label">Pencari Kos</p>
                <p class="mb-0 stat-value">{{ $totalPencariKos }}</p>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="bg-light rounded stat-card">
            <i class="fa fa-home fa-3x text-primary"></i>
            <div class="ms-3">
                <p class="mb-2 stat-label">Total Kos</p>
                <p class="mb-0 stat-value">{{ $totalKos }}</p>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-2">
    <div class="col-sm-6 col-xl-3">
        <div class="bg-light rounded stat-card">
            <i class="fa fa-check-circle fa-3x text-success"></i>
            <div class="ms-3">
                <p class="mb-2 stat-label">Kos Aktif</p>
                <p class="mb-0 stat-value">{{ $kosAktif }}</p>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="bg-light rounded stat-card">
            <i class="fa fa-calendar-check fa-3x text-primary"></i>
            <div class="ms-3">
                <p class="mb-2 stat-label">Total Pemesanan</p>
                <p class="mb-0 stat-value">{{ $totalPemesanan }}</p>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="bg-light rounded stat-card">
            <i class="fa fa-clock fa-3x text-warning"></i>
            <div class="ms-3">
                <p class="mb-2 stat-label">Pemesanan Pending</p>
                <p class="mb-0 stat-value">{{ $pemesananPending }}</p>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="bg-light rounded stat-card">
            <i class="fa fa-chart-line fa-3x text-info"></i>
            <div class="ms-3">
                <p class="mb-2 stat-label">Tingkat Hunian</p>
                <p class="mb-0 stat-value">
                    @if($totalKos > 0)
                        {{ number_format(($kosAktif / $totalKos) * 100, 1) }}%
                    @else
                        0%
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row g-4 mt-2">
    <div class="col-12">
        <div class="bg-light rounded h-100 p-4">
            <h6 class="mb-4">Aksi Cepat</h6>
            <div class="quick-actions-grid">
                <a href="{{ route('admin.pengguna.index') }}" class="btn btn-primary w-100 quick-action-btn">
                    <i class="fa fa-users"></i>
                    <span>Kelola Pengguna</span>
                </a>
                <a href="{{ route('admin.kos.index') }}" class="btn btn-primary w-100 quick-action-btn">
                    <i class="fa fa-home"></i>
                    <span>Kelola Kos</span>
                </a>
                <a href="{{ route('admin.pemesanan.index') }}" class="btn btn-primary w-100 quick-action-btn">
                    <i class="fa fa-calendar-check"></i>
                    <span>Lihat Pemesanan</span>
                </a>
                <a href="{{ route('admin.laporan.index') }}" class="btn btn-primary w-100 quick-action-btn">
                    <i class="fa fa-chart-bar"></i>
                    <span>Lihat Laporan</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row g-4 mt-2">
    <div class="col-12">
        <div class="bg-light rounded h-100 p-4 activity-table">
            <h6 class="mb-4">Aktivitas Terbaru</h6>
            <div class="table-responsive">
                <table class="table align-middle">
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
