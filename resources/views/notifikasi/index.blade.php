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
        <div class="bg-light rounded p-4">
            @forelse($notifikasi as $item)
                <div class="card mb-3 {{ $item->dibaca ? '' : 'border-primary' }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center mb-2">
                                    <h6 class="mb-0 me-2">{{ $item->judul }}</h6>
                                    @if(!$item->dibaca)
                                        <span class="badge bg-primary">Baru</span>
                                    @endif
                                </div>
                                <p class="mb-2">{{ $item->pesan }}</p>
                                <small class="text-muted">
                                    <i class="fa fa-clock me-1"></i>
                                    {{ $item->created_at->diffForHumans() }}
                                </small>
                            </div>
                            <div class="ms-3">
                                @if(!$item->dibaca)
                                    <form action="{{ route('notifikasi.read', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-primary" title="Tandai sudah dibaca">
                                            <i class="fa fa-check"></i>
                                        </button>
                                    </form>
                                @endif
                                @if($item->link)
                                    <a href="{{ $item->link }}" class="btn btn-sm btn-primary ms-1">
                                        <i class="fa fa-arrow-right"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <i class="fa fa-bell-slash fa-4x text-muted mb-3"></i>
                    <h5>Tidak Ada Notifikasi</h5>
                    <p class="text-muted">Anda belum memiliki notifikasi</p>
                </div>
            @endforelse

            @if($notifikasi->hasPages())
                <div class="mt-4">
                    {{ $notifikasi->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
