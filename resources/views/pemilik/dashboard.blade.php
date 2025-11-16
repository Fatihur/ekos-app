@extends('layouts.admin')

@section('title', 'Dashboard Pemilik Kos')

@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="bg-light rounded h-100 p-4">
            <h6 class="mb-4">Selamat Datang, {{ auth()->user()->nama }}!</h6>
            <p>Kelola kos Anda dengan mudah melalui dashboard ini.</p>
        </div>
    </div>
</div>

<!-- Statistik Cards -->
<div class="row g-4 mt-2">
    <div class="col-sm-6 col-xl-3">
        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
            <i class="fa fa-home fa-3x text-primary"></i>
            <div class="ms-3">
                <p class="mb-2">Total Kos</p>
                <h6 class="mb-0">{{ $totalKos }}</h6>
            </div>
        </div>
    </div>
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
                <p class="mb-2">Pending</p>
                <h6 class="mb-0">{{ $pemesananPending }}</h6>
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
                    <a href="{{ route('pemilik.kos.create') }}" class="btn btn-primary w-100">
                        <i class="fa fa-plus-circle me-2"></i>Tambah Kos Baru
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('pemilik.kos.index') }}" class="btn btn-primary w-100">
                        <i class="fa fa-list me-2"></i>Lihat Semua Kos
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('pemilik.pemesanan.index') }}" class="btn btn-primary w-100">
                        <i class="fa fa-calendar-check me-2"></i>Kelola Pemesanan
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('pemilik.pengaturan.index') }}" class="btn btn-primary w-100">
                        <i class="fa fa-cog me-2"></i>Pengaturan Akun
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Daftar Kos -->
<div class="row g-4 mt-2">
    <div class="col-12">
        <div class="bg-light rounded h-100 p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Kos Saya</h6>
                <a href="{{ route('pemilik.kos.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            @if($kosList->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Nama Kos</th>
                                <th scope="col">Jenis</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Kamar Tersedia</th>
                                <th scope="col">Pemesanan</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kosList as $kos)
                                <tr>
                                    <td>{{ $kos->nama_kos }}</td>
                                    <td>{{ ucfirst($kos->jenis_kos) }}</td>
                                    <td>Rp {{ number_format($kos->harga, 0, ',', '.') }}</td>
                                    <td>{{ $kos->kamar_tersedia }}/{{ $kos->jumlah_kamar }}</td>
                                    <td>{{ $kos->pemesanan_count }}</td>
                                    <td>
                                        @if($kos->aktif)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('pemilik.kos.show', $kos->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('pemilik.kos.edit', $kos->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fa fa-home fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Anda belum memiliki kos. Tambahkan kos pertama Anda sekarang!</p>
                    <a href="{{ route('pemilik.kos.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus-circle me-2"></i>Tambah Kos
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Pemesanan Terbaru -->
<div class="row g-4 mt-2">
    <div class="col-12">
        <div class="bg-light rounded h-100 p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Pemesanan Terbaru</h6>
                <a href="{{ route('pemilik.pemesanan.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Kode</th>
                            <th scope="col">Kos</th>
                            <th scope="col">Pemesan</th>
                            <th scope="col">Tanggal Masuk</th>
                            <th scope="col">Durasi</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pemesananTerbaru as $pemesanan)
                            <tr>
                                <td>{{ $pemesanan->kode_pemesanan }}</td>
                                <td>{{ $pemesanan->kos->nama_kos }}</td>
                                <td>{{ $pemesanan->pencari->nama }}</td>
                                <td>{{ $pemesanan->tanggal_masuk->format('d/m/Y') }}</td>
                                <td>{{ $pemesanan->durasi_sewa }} {{ $pemesanan->satuan_durasi }}</td>
                                <td>
                                    @if($pemesanan->status == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($pemesanan->status == 'disetujui')
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif($pemesanan->status == 'dibayar')
                                        <span class="badge bg-info">Dibayar</span>
                                    @elseif($pemesanan->status == 'aktif')
                                        <span class="badge bg-primary">Aktif</span>
                                    @elseif($pemesanan->status == 'selesai')
                                        <span class="badge bg-secondary">Selesai</span>
                                    @elseif($pemesanan->status == 'ditolak')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @elseif($pemesanan->status == 'dibatalkan')
                                        <span class="badge bg-dark">Dibatalkan</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('pemilik.pemesanan.show', $pemesanan->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Belum ada pemesanan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
