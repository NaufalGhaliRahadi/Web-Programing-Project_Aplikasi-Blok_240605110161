@extends('layouts.public')
@section('title', $artikel->judul ?? 'Detail Artikel')

@section('content')
    <nav aria-label="breadcrumb" class="breadcrumb-custom">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('public.home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="#">{{ $artikel->kategori->nama_kategori ?? 'Kategori' }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ Illuminate\Support\Str::limit($artikel->judul ?? '', 40) }}</li>
        </ol>
    </nav>

    <div class="card-artikel">
        <div class="card-body">
            <h2 class="card-title mb-3">{{ $artikel->judul ?? 'Judul tidak tersedia' }}</h2>
            <div class="meta-info mb-3">
                <i class="fas fa-user"></i> {{ $artikel->penulis->nama_depan ?? 'Admin' }} {{ $artikel->penulis->nama_belakang ?? '' }} &nbsp;|&nbsp;
                <i class="far fa-calendar-alt"></i> {{ $artikel->hari_tanggal ?? date('d M Y H:i') }}
            </div>

            @if(!empty($artikel->gambar) && file_exists(public_path('storage/gambar/'.$artikel->gambar)))
                <img src="{{ asset('storage/gambar/'.$artikel->gambar) }}" class="img-fluid rounded mb-4" alt="{{ $artikel->judul }}">
            @endif

            <div class="artikel-content">
                {!! nl2br(e($artikel->isi ?? '')) !!}
            </div>
        </div>
        <div class="card-footer bg-white border-0 pt-0">
            <a href="{{ route('public.home') }}" class="btn btn-outline-secondary rounded-pill">
                <i class="fas fa-home me-1"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
@endsection

@section('sidebar')
    <div class="widget">
    <div class="widget-title">📌 Artikel Terkait</div>
    @forelse($artikelTerkait ?? [] as $related)
    <div class="artikel-terkait-item d-flex align-items-start gap-3 mb-3">
        {{-- Gambar thumbnail --}}
        <div class="flex-shrink-0" style="width: 60px; height: 60px;">
            @if(!empty($related->gambar) && file_exists(public_path('storage/gambar/'.$related->gambar)))
                <img src="{{ asset('storage/gambar/'.$related->gambar) }}" 
                     class="rounded" 
                     style="width: 60px; height: 60px; object-fit: cover;">
            @else
                <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                     style="width: 60px; height: 60px;">
                    <i class="fas fa-image text-secondary fa-2x"></i>
                </div>
            @endif
        </div>
        {{-- Info artikel --}}
        <div>
            <a href="{{ route('public.article.show', $related->id) }}" 
               class="fw-semibold text-decoration-none">{{ $related->judul }}</a>
            @if(!empty($related->hari_tanggal))
                <br>
                <small class="text-muted">
                    <i class="far fa-calendar-alt me-1"></i> {{ $related->hari_tanggal }}
                </small>
            @endif
        </div>
    </div>
    @empty
        <p class="text-muted">Tidak ada artikel terkait dalam kategori ini.</p>
    @endforelse
</div>

    <div class="widget">
        <div class="widget-title">🏷️ Kategori</div>
        <ul class="list-kategori">
            @foreach($kategorisSidebar ?? \App\Models\KategoriArtikel::withCount('artikel')->get() as $kat)
            <li><a href="{{ route('public.category', $kat->id) }}">{{ $kat->nama_kategori }} <span class="badge-count">{{ $kat->artikel_count }}</span></a></li>
            @endforeach
        </ul>
    </div>
@endsection