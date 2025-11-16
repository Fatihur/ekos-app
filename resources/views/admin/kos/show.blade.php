@extends('layouts.admin')

@section('title', 'Detail Kos')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="bg-light rounded h-100 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="mb-0">Detail Kos: {{ $kos->nama_kos }}</h6>
                <a href="{{ route('admin.kos.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left me-2"></i>Kembali
                </a>
            </div>

            <div class="row">
                <div class="col-md-8">
                    @if($kos->foto_utama)
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $kos->foto_utama) }}" alt="{{ $kos->nama_kos }}" class="img-fluid rounded">
                    </div>
                    @endif

                    @if($kos->foto->count() > 0)
                    <div class="mb-4">
                        <h6>Foto Lainnya</h6>
                        <div class="row">
                            @foreach($kos->foto as $foto)
                            <div class="col-md-3 mb-2">
                                <img src="{{ asset('storage/' . $foto->foto) }}" alt="Foto" class="img-fluid rounded">
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="mb-3">
                        <h6>Deskripsi</h6>
                        <p>{{ $kos->deskripsi }}</p>
                    </div>

                    @if($kos->peraturan)
                    <div class="mb-3">
                        <h6>Peraturan</h6>
                        <p>{{ $kos->peraturan }}</p>
                    </div>
                    @endif

                    @if($kos->fasilitas->count() > 0)
                    <div class="mb-3">
                        <h6>Fasilitas</h6>
                        <div class="row">
                            @foreach($kos->fasilitas as $fas)
                            <div class="col-md-4">
                                <span class="badge bg-info mb-2">{{ $fas->nama_fasilitas }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h6 class="card-title">Informasi Kos</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td>Pemilik</td>
                                    <td><strong>{{ $kos->pemilik->nama }}</strong></td>
                                </tr>
                                <tr>
                                    <td>Jenis Kos</td>
                                    <td><span class="badge bg-info">{{ ucfirst($kos->jenis_kos) }}</span></td>
                                </tr>
                                <tr>
                                    <td>Jenis Kamar</td>
                                    <td>{{ str_replace('_', ' ', ucwords($kos->jenis_kamar, '_')) }}</td>
                                </tr>
                                <tr>
                                    <td>Harga/Bulan</td>
                                    <td><strong>Rp {{ number_format($kos->harga, 0, ',', '.') }}</strong></td>
                                </tr>
                                <tr>
                                    <td>Jumlah Kamar</td>
                                    <td>{{ $kos->jumlah_kamar }} kamar</td>
                                </tr>
                                <tr>
                                    <td>Kamar Tersedia</td>
                                    <td>{{ $kos->kamar_tersedia }} kamar</td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>
                                        @if($kos->aktif)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>

                            <h6 class="mt-3">Lokasi</h6>
                            <p class="mb-1">{{ $kos->alamat }}</p>
                            <p class="mb-1">{{ $kos->kota }}, {{ $kos->provinsi }}</p>
                            @if($kos->kode_pos)
                            <p>{{ $kos->kode_pos }}</p>
                            @endif
                        </div>
                    </div>

                    @if($kos->pemesanan->count() > 0)
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Pemesanan ({{ $kos->pemesanan->count() }})</h6>
                            <div class="list-group">
                                @foreach($kos->pemesanan->take(5) as $pesanan)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between">
                                        <small>{{ $pesanan->pengguna->nama }}</small>
                                        <small>{{ $pesanan->created_at->format('d/m/Y') }}</small>
                                    </div>
                                    <span class="badge bg-{{ $pesanan->status == 'disetujui' ? 'success' : ($pesanan->status == 'pending' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($pesanan->status) }}
                                    </span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
