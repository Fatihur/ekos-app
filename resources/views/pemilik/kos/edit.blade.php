@extends('layouts.admin')

@section('title', 'Edit Kos')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="bg-light rounded h-100 p-4">
            <h6 class="mb-4">Edit Kos: {{ $ko->nama_kos }}</h6>
            
            <form id="formEditKos" action="{{ route('pemilik.kos.update', $ko->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Kos <span class="text-danger">*</span></label>
                        <input type="text" name="nama_kos" class="form-control @error('nama_kos') is-invalid @enderror" value="{{ old('nama_kos', $ko->nama_kos) }}" required>
                        @error('nama_kos')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Jenis Kos <span class="text-danger">*</span></label>
                        <select name="jenis_kos" class="form-select @error('jenis_kos') is-invalid @enderror" required>
                            <option value="">Pilih Jenis</option>
                            <option value="putra" {{ old('jenis_kos', $ko->jenis_kos) == 'putra' ? 'selected' : '' }}>Putra</option>
                            <option value="putri" {{ old('jenis_kos', $ko->jenis_kos) == 'putri' ? 'selected' : '' }}>Putri</option>
                            <option value="campur" {{ old('jenis_kos', $ko->jenis_kos) == 'campur' ? 'selected' : '' }}>Campur</option>
                        </select>
                        @error('jenis_kos')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Jenis Kamar <span class="text-danger">*</span></label>
                        <select name="jenis_kamar" class="form-select @error('jenis_kamar') is-invalid @enderror" required>
                            <option value="">Pilih Jenis</option>
                            <option value="kamar_mandi_dalam" {{ old('jenis_kamar', $ko->jenis_kamar) == 'kamar_mandi_dalam' ? 'selected' : '' }}>Kamar Mandi Dalam</option>
                            <option value="kamar_mandi_luar" {{ old('jenis_kamar', $ko->jenis_kamar) == 'kamar_mandi_luar' ? 'selected' : '' }}>Kamar Mandi Luar</option>
                        </select>
                        @error('jenis_kamar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Harga per Bulan <span class="text-danger">*</span></label>
                        <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror" value="{{ old('harga', $ko->harga) }}" required>
                        @error('harga')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Jumlah Kamar <span class="text-danger">*</span></label>
                        <input type="number" name="jumlah_kamar" class="form-control @error('jumlah_kamar') is-invalid @enderror" value="{{ old('jumlah_kamar', $ko->jumlah_kamar) }}" required>
                        @error('jumlah_kamar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kamar Tersedia <span class="text-danger">*</span></label>
                        <input type="number" name="kamar_tersedia" class="form-control @error('kamar_tersedia') is-invalid @enderror" value="{{ old('kamar_tersedia', $ko->kamar_tersedia) }}" required>
                        @error('kamar_tersedia')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
                    <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="5" required>{{ old('deskripsi', $ko->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea name="alamat" rows="2" class="form-control @error('alamat') is-invalid @enderror" required>{{ old('alamat', $ko->alamat) }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kota <span class="text-danger">*</span></label>
                        <input type="text" name="kota" class="form-control @error('kota') is-invalid @enderror" value="{{ old('kota', $ko->kota) }}" required>
                        @error('kota')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Provinsi <span class="text-danger">*</span></label>
                        <input type="text" name="provinsi" class="form-control @error('provinsi') is-invalid @enderror" value="{{ old('provinsi', $ko->provinsi) }}" required>
                        @error('provinsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kode Pos</label>
                        <input type="text" name="kode_pos" class="form-control @error('kode_pos') is-invalid @enderror" value="{{ old('kode_pos', $ko->kode_pos) }}">
                        @error('kode_pos')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Link Google Maps <small class="text-muted">(Opsional)</small></label>
                    <input type="url" name="google_maps_link" class="form-control @error('google_maps_link') is-invalid @enderror" 
                           value="{{ old('google_maps_link', $ko->google_maps_link) }}" 
                           placeholder="https://maps.google.com/...">
                    @error('google_maps_link')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">
                        <i class="fa fa-info-circle me-1"></i>
                        Buka Google Maps, cari lokasi kos, klik "Bagikan" lalu salin link
                    </small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Peraturan Kos</label>
                    <textarea name="peraturan" class="form-control @error('peraturan') is-invalid @enderror" rows="5">{{ old('peraturan', $ko->peraturan) }}</textarea>
                    @error('peraturan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Fasilitas</label>
                    <div class="row">
                        @foreach($fasilitas as $item)
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="fasilitas[]" value="{{ $item->id }}" id="fasilitas{{ $item->id }}" 
                                    {{ in_array($item->id, old('fasilitas', $ko->fasilitas->pluck('id')->toArray())) ? 'checked' : '' }}>
                                <label class="form-check-label" for="fasilitas{{ $item->id }}">
                                    {{ $item->nama_fasilitas }}
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto Utama Saat Ini</label>
                    @if($ko->foto_utama)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $ko->foto_utama) }}" alt="{{ $ko->nama_kos }}" style="max-width: 200px;" class="rounded">
                        </div>
                    @endif
                    <input type="file" name="foto_utama" class="form-control @error('foto_utama') is-invalid @enderror" accept="image/*">
                    @error('foto_utama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Kosongkan jika tidak ingin mengubah. Format: JPG, JPEG, PNG. Maksimal 2MB</small>
                </div>

                @if($ko->foto->count() > 0)
                <div class="mb-3">
                    <label class="form-label">Foto Tambahan Saat Ini</label>
                    <div class="row">
                        @foreach($ko->foto as $foto)
                        <div class="col-md-2 mb-2">
                            <div class="position-relative">
                                <img src="{{ asset('storage/' . $foto->foto) }}" alt="Foto" class="img-fluid rounded">
                                <button type="button" onclick="deleteFoto({{ $ko->id }}, {{ $foto->id }})" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="mb-3">
                    <label class="form-label">Tambah Foto Baru</label>
                    <input type="file" name="foto_tambahan[]" class="form-control @error('foto_tambahan.*') is-invalid @enderror" accept="image/*" multiple>
                    @error('foto_tambahan.*')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Bisa pilih beberapa foto sekaligus. Format: JPG, JPEG, PNG. Maksimal 2MB per foto</small>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="aktif" value="1" id="aktif" {{ old('aktif', $ko->aktif) ? 'checked' : '' }}>
                        <label class="form-check-label" for="aktif">
                            Aktifkan kos ini
                        </label>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('pemilik.kos.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left me-2"></i>Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save me-2"></i>Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<!-- Hidden forms for delete foto (outside main form) -->
@if($ko->foto->count() > 0)
    @foreach($ko->foto as $foto)
    <form id="delete-foto-form-{{ $foto->id }}" action="{{ route('pemilik.kos.foto.delete', ['koId' => $ko->id, 'fotoId' => $foto->id]) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
    @endforeach
@endif

@push('scripts')
<script>
function deleteFoto(kosId, fotoId) {
    if (confirm('Apakah Anda yakin ingin menghapus foto ini?')) {
        document.getElementById('delete-foto-form-' + fotoId).submit();
    }
}
</script>
@endpush

