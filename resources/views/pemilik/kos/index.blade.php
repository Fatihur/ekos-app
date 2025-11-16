@extends('layouts.admin')

@section('title', 'Data Kos')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="bg-light rounded h-100 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="mb-0">Data Kos Saya</h6>
                <a href="{{ route('pemilik.kos.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus me-2"></i>Tambah Kos
                </a>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Nama Kos</th>
                            <th>Jenis</th>
                            <th>Harga/Bulan</th>
                            <th>Kamar</th>
                            <th>Kota</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kosList as $kos)
                        <tr>
                            <td>
                                @if($kos->foto_utama)
                                    <img src="{{ asset('storage/' . $kos->foto_utama) }}" alt="{{ $kos->nama_kos }}" style="width: 60px; height: 60px; object-fit: cover;" class="rounded">
                                @else
                                    <div class="bg-secondary rounded" style="width: 60px; height: 60px;"></div>
                                @endif
                            </td>
                            <td>{{ $kos->nama_kos }}</td>
                            <td>
                                <span class="badge bg-info">{{ ucfirst($kos->jenis_kos) }}</span>
                            </td>
                            <td>Rp {{ number_format($kos->harga, 0, ',', '.') }}</td>
                            <td>{{ $kos->kamar_tersedia }}/{{ $kos->jumlah_kamar }}</td>
                            <td>{{ $kos->kota }}</td>
                            <td>
                                @if($kos->aktif)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('pemilik.kos.show', $kos->id) }}" class="btn btn-sm btn-info" title="Detail">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ route('pemilik.kos.edit', $kos->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form action="{{ route('pemilik.kos.destroy', $kos->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kos ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Belum ada data kos</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $kosList->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
