@extends('layouts.admin')

@section('title', 'Detail Kos')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="bg-light rounded h-100 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="mb-0">Detail Kos: {{ $ko->nama_kos }}</h6>
                <div>
                    <a href="{{ route('pemilik.kos.edit', $ko->id) }}" class="btn btn-warning">
                        <i class="fa fa-edit me-2"></i>Edit
                    </a>
                    <a href="{{ route('pemilik.kos.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="mb-4">
                        @if($ko->foto_utama)
                            <img src="{{ asset('storage/' . $ko->foto_utama) }}" alt="{{ $ko->nama_kos }}" class="img-fluid rounded">
                        @endif
                    </div>

                    @if($ko->foto->count() > 0)
                    <div class="mb-4">
                        <h6>Foto Lainnya</h6>
                        <div class="row">
                            @foreach($ko->foto as $foto)
                            <div class="col-md-3 mb-2">
                                <img src="{{ asset('storage/' . $foto->foto) }}" alt="Foto" class="img-fluid rounded">
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="mb-3">
                        <h6>Deskripsi</h6>
                        <div class="ck-content" style="padding: 0;">
                            {!! $ko->deskripsi ?? '<p>Tidak ada deskripsi</p>' !!}
                        </div>
                    </div>

                    @if($ko->peraturan)
                    <div class="mb-3">
                        <h6>Peraturan</h6>
                        <div class="ck-content" style="padding: 0;">
                            {!! $ko->peraturan !!}
                        </div>
                    </div>
                    @endif

                    @if($ko->fasilitas->count() > 0)
                    <div class="mb-3">
                        <h6>Fasilitas</h6>
                        <div class="row">
                            @foreach($ko->fasilitas as $fas)
                            <div class="col-md-4">
                                <span class="badge bg-info mb-2">{{ $fas->nama_fasilitas }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Informasi Kos</h6>
                            
                            <table class="table table-sm">
                                <tr>
                                    <td>Jenis Kos</td>
                                    <td><span class="badge bg-info">{{ ucfirst($ko->jenis_kos) }}</span></td>
                                </tr>
                                <tr>
                                    <td>Jenis Kamar</td>
                                    <td>{{ str_replace('_', ' ', ucwords($ko->jenis_kamar, '_')) }}</td>
                                </tr>
                                <tr>
                                    <td>Harga/Bulan</td>
                                    <td><strong>Rp {{ number_format($ko->harga, 0, ',', '.') }}</strong></td>
                                </tr>
                                <tr>
                                    <td>Jumlah Kamar</td>
                                    <td>{{ $ko->jumlah_kamar }} kamar</td>
                                </tr>
                                <tr>
                                    <td>Kamar Tersedia</td>
                                    <td>{{ $ko->kamar_tersedia }} kamar</td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>
                                        @if($ko->aktif)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>

                            <h6 class="mt-3">Lokasi</h6>
                            <p class="mb-1">{{ $ko->alamat }}</p>
                            <p class="mb-1">{{ $ko->kota }}, {{ $ko->provinsi }}</p>
                            @if($ko->kode_pos)
                            <p>{{ $ko->kode_pos }}</p>
                            @endif
                        </div>
                    </div>

                    @if($ko->pemesanan->count() > 0)
                    <div class="card mt-3">
                        <div class="card-body">
                            <h6 class="card-title">Pemesanan Terakhir</h6>
                            <div class="list-group">
                                @foreach($ko->pemesanan as $pesanan)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between">
                                        <small>{{ $pesanan->kode_pemesanan }}</small>
                                        <small>{{ $pesanan->created_at->format('d/m/Y') }}</small>
                                    </div>
                                    <span class="badge bg-{{ $pesanan->status == 'disetujui' ? 'success' : ($pesanan->status == 'menunggu' ? 'warning' : 'danger') }}">
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
