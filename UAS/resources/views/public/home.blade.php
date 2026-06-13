@extends('layouts.public')

@section('title', 'Beranda - Blog Kami')

@section('content')
    <h3 class="mb-4 fw-bold">📰 Artikel Terbaru</h3>

    @forelse($artikels ?? [] as $artikel)
    <div class="card-artikel">
        @if(!empty($artikel->gambar) && file_exists(public_path('storage/gambar/'.$artikel->gambar)))
            <img src="{{ asset('storage/gambar/'.$artikel->gambar) }}" class="card-img-top" alt="{{ $artikel->judul }}">
        @else
            <div class="bg-light text-center pt-5 pb-4" style="height: 220px;">
                <i class="fas fa-image fa-3x text-secondary"></i>
                <p class="small text-muted mt-2">Tidak ada gambar</p>
            </div>
        @endif
        <div class="card-body">
            <h5 class="card-title">{{ $artikel->judul ?? 'Judul tidak tersedia' }}</h5>
            <div class="meta-info">
    <i class="fas fa-user"></i> {{ $artikel->penulis->nama_depan ?? 'Admin' }} {{ $artikel->penulis->nama_belakang ?? '' }} &nbsp;|&nbsp;
    <i class="far fa-calendar-alt"></i> {{ $artikel->hari_tanggal ?? date('d M Y H:i') }} &nbsp;|&nbsp;
    <span class="badge-kategori">{{ $artikel->kategori->nama_kategori ?? 'Umum' }}</span>
</div>
            <p class="card-text">{{ Illuminate\Support\Str::limit(strip_tags($artikel->isi ?? ''), 120) }}</p>
            <a href="{{ route('public.article.show', $artikel->id) }}" class="btn btn-baca">Baca Selengkapnya →</a>
        </div>
    </div>
    @empty
        <div class="alert alert-info">Belum ada artikel. Silakan cek lagi nanti.</div>
    @endforelse
@endsection

@section('sidebar')
    <div class="widget">
        <div class="widget-title">📂 Kategori Artikel</div>
        <ul class="list-kategori">
            <li>
                <a href="{{ route('public.home') }}">
                    Semua Artikel 
                    <span class="badge-count">{{ $totalArtikel ?? \App\Models\Artikel::count() }}</span>
                </a>
            </li>
            @foreach($kategoris ?? [] as $kat)
            <li>
                <a href="{{ route('public.category', $kat->id) }}">
                    {{ $kat->nama_kategori }}
                    <span class="badge-count">{{ $kat->artikel_count ?? $kat->artikel()->count() }}</span>
                </a>
            </li>
            @endforeach
        </ul>
    </div>

    @if(isset($selectedKategori))
    <div class="widget">
        <div class="widget-title">🔍 Menampilkan: {{ $selectedKategori->nama_kategori ?? 'Kategori' }}</div>
        <a href="{{ route('public.home') }}" class="btn-back">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Beranda
        </a>
    </div>
    @endif
@endsection