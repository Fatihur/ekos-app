@extends('layouts.admin')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="bg-light rounded h-100 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="mb-0">Manajemen Pengguna</h6>
                <a href="{{ route('admin.pengguna.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus me-2"></i>Tambah Pengguna
                </a>
            </div>

            <!-- Filter -->
            <form action="{{ route('admin.pengguna.index') }}" method="GET" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Cari nama atau email..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="peran" class="form-select">
                            <option value="">Semua Peran</option>
                            <option value="admin" {{ request('peran') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="pemilik_kos" {{ request('peran') == 'pemilik_kos' ? 'selected' : '' }}>Pemilik Kos</option>
                            <option value="pencari_kos" {{ request('peran') == 'pencari_kos' ? 'selected' : '' }}>Pencari Kos</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fa fa-search me-2"></i>Cari
                        </button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('admin.pengguna.index') }}" class="btn btn-secondary w-100">
                            <i class="fa fa-redo me-2"></i>Reset
                        </a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Peran</th>
                            <th>Telepon</th>
                            <th>Status</th>
                            <th>Terdaftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penggunaList as $pengguna)
                        <tr>
                            <td>{{ $pengguna->nama }}</td>
                            <td>{{ $pengguna->email }}</td>
                            <td>
                                <span class="badge bg-{{ $pengguna->peran == 'admin' ? 'danger' : ($pengguna->peran == 'pemilik_kos' ? 'primary' : 'info') }}">
                                    {{ ucfirst(str_replace('_', ' ', $pengguna->peran)) }}
                                </span>
                            </td>
                            <td>{{ $pengguna->telepon ?? '-' }}</td>
                            <td>
                                @if($pengguna->aktif)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>{{ $pengguna->created_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('admin.pengguna.edit', $pengguna->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                @if($pengguna->id != auth()->id())
                                <form action="{{ route('admin.pengguna.destroy', $pengguna->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data pengguna</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $penggunaList->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
