@extends('layouts.admin')

@section('title', 'Manajemen Pemesanan')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Manajemen Pemesanan</h4>
        </div>
    </div>
</div>

<!-- Filter & Search -->
<div class="row mb-4">
    <div class="col-12">
        <div class="bg-light rounded p-4">
            <form action="{{ route('admin.pemesanan.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="search" 
                               placeholder="Cari kode, nama pencari, atau nama kos..." 
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="status">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="dibayar" {{ request('status') == 'dibayar' ? 'selected' : '' }}>Dibayar</option>
                            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fa fa-search me-2"></i>Cari
                        </button>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.pemesanan.index') }}" class="btn btn-secondary w-100">
                            <i class="fa fa-redo me-2"></i>Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Tabel Pemesanan -->
<div class="row">
    <div class="col-12">
        <div class="bg-light rounded p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Pencari</th>
                            <th>Kos</th>
                            <th>Pemilik</th>
                            <th>Tanggal Masuk</th>
                            <th>Durasi</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pemesanan as $p)
                            <tr>
                                <td>{{ $p->kode_pemesanan }}</td>
                                <td>{{ $p->pencari->nama }}</td>
                                <td>{{ $p->kos->nama_kos }}</td>
                                <td>{{ $p->kos->pemilik->nama }}</td>
                                <td>{{ $p->tanggal_masuk->format('d/m/Y') }}</td>
                                <td>{{ $p->durasi_sewa }} {{ $p->satuan_durasi }}</td>
                                <td>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                                <td>
                                    @if($p->status == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($p->status == 'disetujui')
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif($p->status == 'dibayar')
                                        <span class="badge bg-info">Dibayar</span>
                                    @elseif($p->status == 'aktif')
                                        <span class="badge bg-primary">Aktif</span>
                                    @elseif($p->status == 'selesai')
                                        <span class="badge bg-secondary">Selesai</span>
                                    @elseif($p->status == 'ditolak')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @elseif($p->status == 'dibatalkan')
                                        <span class="badge bg-dark">Dibatalkan</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.pemesanan.show', $p->id) }}" 
                                       class="btn btn-sm btn-primary">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">Tidak ada data pemesanan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $pemesanan->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
