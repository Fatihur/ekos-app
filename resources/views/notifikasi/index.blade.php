@extends('layouts.admin')

@section('title', 'Notifikasi')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Notifikasi</h4>
            @if(auth()->user()->notifikasiBelumDibaca()->count() > 0)
                <form action="{{ route('notifikasi.read-all') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fa fa-check-double me-1"></i>Tandai Semua Sudah Dibaca
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-12">
        <div class="bg-light rounded p-3 p-md-4">
            @forelse($notifikasi as $item)
                <div class="card mb-3 {{ $item->dibaca ? '' : 'border-primary border-2' }} shadow-sm">
                    <div class="card-body p-3">
                        <div class="row g-2">
                            <!-- Icon -->
                            <div class="col-auto d-none d-sm-block">
                                <div class="rounded-circle bg-{{ $item->tipe == 'success' ? 'success' : ($item->tipe == 'warning' ? 'warning' : ($item->tipe == 'danger' ? 'danger' : 'primary')) }} text-white d-flex align-items-center justify-content-center" 
                                     style="width: 50px; height: 50px;">
                                    <i class="fa fa-{{ $item->tipe == 'success' ? 'check-circle' : ($item->tipe == 'warning' ? 'exclamation-triangle' : ($item->tipe == 'danger' ? 'times-circle' : 'info-circle')) }} fa-lg"></i>
                                </div>
                            </div>
                            
                            <!-- Content -->
                            <div class="col">
                                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start mb-2">
                                    <div class="d-flex align-items-center flex-wrap mb-2 mb-sm-0">
                                        <h6 class="mb-0 me-2">{{ $item->judul }}</h6>
                                        @if(!$item->dibaca)
                                            <span class="badge bg-primary">Baru</span>
                                        @endif
                                    </div>
                                    <div class="d-flex gap-1">
                                        @if(!$item->dibaca)
                                            <form action="{{ route('notifikasi.read', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-primary" title="Tandai sudah dibaca">
                                                    <i class="fa fa-check"></i>
                                                    <span class="d-none d-md-inline ms-1">Tandai Dibaca</span>
                                                </button>
                                            </form>
                                        @endif
                                        @if($item->link)
                                            <a href="{{ $item->link }}" class="btn btn-sm btn-primary">
                                                <i class="fa fa-arrow-right"></i>
                                                <span class="d-none d-md-inline ms-1">Lihat Detail</span>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <p class="mb-2 text-break">{{ $item->pesan }}</p>
                                <small class="text-muted">
                                    <i class="fa fa-clock me-1"></i>
                                    {{ $item->created_at->diffForHumans() }}
                                    @if($item->dibaca && $item->dibaca_pada)
                                        <span class="d-none d-sm-inline">
                                            • <i class="fa fa-check me-1"></i>Dibaca {{ $item->dibaca_pada->diffForHumans() }}
                                        </span>
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <i class="fa fa-bell-slash fa-4x text-muted mb-3 d-block"></i>
                    <h5 class="mb-2">Tidak Ada Notifikasi</h5>
                    <p class="text-muted mb-0">Anda belum memiliki notifikasi</p>
                </div>
            @endforelse

            @if($notifikasi->hasPages())
                <div class="mt-4 d-flex justify-content-center">
                    {{ $notifikasi->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
