@extends('layouts.admin')

@section('title', 'Manajemen Kos')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="bg-light rounded h-100 p-4">
            <h6 class="mb-4">Manajemen Kos</h6>

            <!-- Filter -->
            <form action="{{ route('admin.kos.index') }}" method="GET" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Cari nama kos, kota, atau pemilik..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <select name="jenis_kos" class="form-select">
                            <option value="">Semua Jenis</option>
                            <option value="putra" {{ request('jenis_kos') == 'putra' ? 'selected' : '' }}>Putra</option>
                            <option value="putri" {{ request('jenis_kos') == 'putri' ? 'selected' : '' }}>Putri</option>
                            <option value="campur" {{ request('jenis_kos') == 'campur' ? 'selected' : '' }}>Campur</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="aktif" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="1" {{ request('aktif') === '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ request('aktif') === '0' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fa fa-search me-2"></i>Cari
                        </button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('admin.kos.index') }}" class="btn btn-secondary w-100">
                            <i class="fa fa-redo me-2"></i>Reset
                        </a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Nama Kos</th>
                            <th>Pemilik</th>
                            <th>Jenis</th>
                            <th>Harga</th>
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
                            <td>{{ $kos->pemilik->nama }}</td>
                            <td>
                                <span class="badge bg-info">{{ ucfirst($kos->jenis_kos) }}</span>
                            </td>
                            <td>Rp {{ number_format($kos->harga, 0, ',', '.') }}</td>
                            <td>{{ $kos->kamar_tersedia }}/{{ $kos->jumlah_kamar }}</td>
                            <td>{{ $kos->kota }}</td>
                            <td>
                                <form action="{{ route('admin.kos.toggle-aktif', $kos->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-{{ $kos->aktif ? 'success' : 'secondary' }}">
                                        {{ $kos->aktif ? 'Aktif' : 'Nonaktif' }}
                                    </button>
                                </form>
                            </td>
                            <td>
                                <a href="{{ route('admin.kos.show', $kos->id) }}" class="btn btn-sm btn-info" title="Detail">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">Tidak ada data kos</td>
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
