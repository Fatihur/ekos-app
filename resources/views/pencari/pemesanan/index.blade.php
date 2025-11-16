@extends('layouts.public')

@section('title', 'Pemesanan Saya')

@section('content')
<div class="container-xxl py-5">
    <div class="container">
        <h2 class="mb-4">Pemesanan Saya</h2>

        @if($pemesanan->count() > 0)
            <div class="row g-4">
                @foreach($pemesanan as $pesanan)
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    @if($pesanan->kos->foto_utama)
                                        <img src="{{ asset('storage/' . $pesanan->kos->foto_utama) }}" alt="{{ $pesanan->kos->nama_kos }}" class="img-fluid rounded">
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <h5>{{ $pesanan->kos->nama_kos }}</h5>
                                    <p class="text-muted mb-2">
                                        <i class="fa fa-map-marker-alt me-2"></i>{{ $pesanan->kos->kota }}
                                    </p>
                                    <p class="mb-1"><strong>Kode:</strong> {{ $pesanan->kode_pemesanan }}</p>
                                    <p class="mb-1"><strong>Tanggal Masuk:</strong> {{ $pesanan->tanggal_masuk->format('d/m/Y') }}</p>
                                    <p class="mb-1"><strong>Durasi:</strong> {{ $pesanan->durasi_sewa }} {{ $pesanan->satuan_durasi }}</p>
                                    <p class="mb-1"><strong>Total:</strong> Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
                                </div>
                                <div class="col-md-3 text-end">
                                    <div class="mb-3">
                                        @if($pesanan->status == 'pending')
                                            <span class="badge bg-warning">Menunggu Persetujuan</span>
                                        @elseif($pesanan->status == 'disetujui')
                                            <span class="badge bg-info">Disetujui - Belum Bayar</span>
                                        @elseif($pesanan->status == 'dibayar')
                                            <span class="badge bg-primary">Menunggu Verifikasi Pembayaran</span>
                                        @elseif($pesanan->status == 'aktif')
                                            <span class="badge bg-success">Aktif</span>
                                        @elseif($pesanan->status == 'selesai')
                                            <span class="badge bg-secondary">Selesai</span>
                                        @elseif($pesanan->status == 'ditolak')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @elseif($pesanan->status == 'dibatalkan')
                                            <span class="badge bg-dark">Dibatalkan</span>
                                        @endif
                                    </div>
                                    <a href="{{ route('pencari.pemesanan.show', $pesanan->id) }}" class="btn btn-primary btn-sm w-100">
                                        <i class="fa fa-eye me-2"></i>Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $pemesanan->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fa fa-calendar-times fa-4x text-muted mb-4"></i>
                <h4>Belum Ada Pemesanan</h4>
                <p class="text-muted mb-4">Anda belum melakukan pemesanan kos</p>
                <a href="{{ route('pencarian') }}" class="btn btn-primary rounded-pill px-5">
                    <i class="fa fa-search me-2"></i>Cari Kos
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
