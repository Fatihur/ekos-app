@extends('layouts.admin')

@section('title', 'Kelola Pemesanan')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-0">Kelola Pemesanan</h4>
    </div>
</div>

<!-- Statistik -->
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
            <i class="fa fa-clock fa-3x text-warning"></i>
            <div class="ms-3 text-end">
                <p class="mb-2">Pending</p>
                <h6 class="mb-0">{{ $pemesanan->where('status', 'pending')->count() }}</h6>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
            <i class="fa fa-credit-card fa-3x text-info"></i>
            <div class="ms-3 text-end">
                <p class="mb-2">Perlu Verifikasi</p>
                <h6 class="mb-0">{{ $pemesanan->where('status', 'dibayar')->count() }}</h6>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
            <i class="fa fa-home fa-3x text-primary"></i>
            <div class="ms-3 text-end">
                <p class="mb-2">Aktif</p>
                <h6 class="mb-0">{{ $pemesanan->where('status', 'aktif')->count() }}</h6>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
            <i class="fa fa-check-circle fa-3x text-success"></i>
            <div class="ms-3 text-end">
                <p class="mb-2">Selesai</p>
                <h6 class="mb-0">{{ $pemesanan->where('status', 'selesai')->count() }}</h6>
            </div>
        </div>
    </div>
</div>

<!-- Filter & List -->
<div class="bg-light rounded p-4">
    <!-- Filter Form -->
    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-4">
            <label class="form-label">Filter Kos</label>
            <select name="kos_id" class="form-select">
                <option value="">Semua Kos</option>
                @foreach($kosList as $k)
                    <option value="{{ $k->id }}" {{ request('kos_id') == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kos }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Filter Status</label>
            <select name="status" class="form-select">
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
        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-primary me-2">
                <i class="fa fa-filter me-2"></i>Filter
            </button>
            <a href="{{ route('pemilik.pemesanan.index') }}" class="btn btn-secondary">
                <i class="fa fa-redo me-2"></i>Reset
            </a>
        </div>
    </form>
    
    <!-- Table -->
    <h6 class="mb-3">Daftar Pemesanan</h6>
    
    @if($pemesanan->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Pemesan</th>
                        <th>Kos</th>
                        <th>Tanggal Masuk</th>
                        <th>Durasi</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pemesanan as $p)
                        <tr>
                            <td><strong>{{ $p->kode_pemesanan }}</strong></td>
                            <td>
                                {{ $p->pencari->nama }}<br>
                                <small class="text-muted">{{ $p->pencari->email }}</small>
                            </td>
                            <td>
                                {{ $p->kos->nama_kos }}<br>
                                <small class="text-muted">{{ $p->kos->kota }}</small>
                            </td>
                            <td>{{ $p->tanggal_masuk->format('d/m/Y') }}</td>
                            <td>{{ $p->durasi_sewa }} {{ $p->satuan_durasi }}</td>
                            <td>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                            <td>
                                @if($p->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($p->status == 'disetujui')
                                    <span class="badge bg-success">Disetujui</span>
                                @elseif($p->status == 'dibayar')
                                    <span class="badge bg-info">Perlu Verifikasi</span>
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
                                <a href="{{ route('pemilik.pemesanan.show', $p->id) }}" 
                                   class="btn btn-sm btn-primary" title="Lihat Detail">
                                    <i class="fa fa-eye"></i>
                                </a>
                                
                                @if($p->status == 'pending')
                                    <button class="btn btn-sm btn-success" 
                                            onclick="approveBooking({{ $p->id }})" title="Setujui">
                                        <i class="fa fa-check"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $pemesanan->appends(request()->query())->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="fa fa-calendar-times fa-4x text-muted mb-3"></i>
            <p class="text-muted">Belum ada pemesanan</p>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function approveBooking(id) {
    if (confirm('Setujui pemesanan ini?')) {
        fetch(`/pemilik/pemesanan/${id}/approve`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Terjadi kesalahan');
            }
        })
        .catch(error => {
            alert('Terjadi kesalahan');
        });
    }
}
</script>
@endpush
