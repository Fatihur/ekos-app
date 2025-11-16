@extends('layouts.admin')

@section('title', 'Laporan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="bg-light rounded h-100 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="mb-0">Laporan Sistem</h6>
                <form action="{{ route('admin.laporan.index') }}" method="GET" class="d-flex">
                    <input type="month" name="bulan" class="form-control me-2" value="{{ $bulan }}">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-filter me-2"></i>Filter
                    </button>
                </form>
            </div>

            <!-- Statistik Umum -->
            <div class="row g-4 mb-4">
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-white rounded d-flex align-items-center justify-content-between p-4">
                        <i class="fa fa-home fa-3x text-primary"></i>
                        <div class="ms-3">
                            <p class="mb-2">Total Kos</p>
                            <h6 class="mb-0">{{ $totalKos }}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-white rounded d-flex align-items-center justify-content-between p-4">
                        <i class="fa fa-users fa-3x text-primary"></i>
                        <div class="ms-3">
                            <p class="mb-2">Total Pengguna</p>
                            <h6 class="mb-0">{{ $totalPengguna }}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-white rounded d-flex align-items-center justify-content-between p-4">
                        <i class="fa fa-calendar-check fa-3x text-primary"></i>
                        <div class="ms-3">
                            <p class="mb-2">Pemesanan Bulan Ini</p>
                            <h6 class="mb-0">{{ $totalPemesanan }}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-white rounded d-flex align-items-center justify-content-between p-4">
                        <i class="fa fa-money-bill-wave fa-3x text-primary"></i>
                        <div class="ms-3">
                            <p class="mb-2">Pendapatan</p>
                            <h6 class="mb-0">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- Pemesanan per Status -->
                <div class="col-md-6">
                    <div class="bg-white rounded p-4">
                        <h6 class="mb-4">Pemesanan per Status</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th class="text-end">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pemesananPerStatus as $item)
                                    <tr>
                                        <td>
                                            <span class="badge bg-{{ $item->status == 'disetujui' ? 'success' : ($item->status == 'pending' ? 'warning' : 'secondary') }}">
                                                {{ ucfirst($item->status) }}
                                            </span>
                                        </td>
                                        <td class="text-end">{{ $item->total }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="2" class="text-center">Tidak ada data</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Kos Terpopuler -->
                <div class="col-md-6">
                    <div class="bg-white rounded p-4">
                        <h6 class="mb-4">Kos Terpopuler</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Nama Kos</th>
                                        <th>Kota</th>
                                        <th class="text-end">Pemesanan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($kosPopuler as $kos)
                                    <tr>
                                        <td>{{ Str::limit($kos->nama_kos, 25) }}</td>
                                        <td>{{ $kos->kota }}</td>
                                        <td class="text-end">{{ $kos->pemesanan_count }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Tidak ada data</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Pemilik Kos Teraktif -->
                <div class="col-md-12">
                    <div class="bg-white rounded p-4">
                        <h6 class="mb-4">Pemilik Kos Teraktif</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Nama Pemilik</th>
                                        <th>Email</th>
                                        <th>Telepon</th>
                                        <th class="text-end">Jumlah Kos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pemilikAktif as $pemilik)
                                    <tr>
                                        <td>{{ $pemilik->nama }}</td>
                                        <td>{{ $pemilik->email }}</td>
                                        <td>{{ $pemilik->telepon ?? '-' }}</td>
                                        <td class="text-end">{{ $pemilik->kos_count }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada data</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
