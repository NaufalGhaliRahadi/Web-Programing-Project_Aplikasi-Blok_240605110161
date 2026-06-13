@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="row">
    <!-- Profil Card -->
    <div class="col-md-5 col-lg-4 mb-4">
        <div class="card text-center p-3">
            <div class="card-body">
                <img src="{{ asset('storage/foto/' . (Auth::user()->foto ?? 'default.png')) }}" 
                     class="rounded-circle mb-3 border border-3 border-primary" 
                     width="130" height="130" style="object-fit: cover;">
                <h3 class="mt-2">{{ Auth::user()->nama_depan }} {{ Auth::user()->nama_belakang }}</h3>
                <p class="text-muted">
                    <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->user_name }}
                </p>
                <hr>
                <div class="text-start">
                    
                    <p><i class="fas fa-clock text-success me-2"></i> 
                        <strong>Waktu Login:</strong><br>
                        {{ session('waktu_login', 'Belum tercatat') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik & Artikel Terbaru -->
    <div class="col-md-7 col-lg-8">
        <!-- Stat Cards -->
        <div class="row g-3 mb-4">
            <div class="col-sm-4">
                <div class="stat-card">
                    <i class="fas fa-newspaper mb-2"></i>
                    <h2 class="fw-bold mb-0">{{ \App\Models\Artikel::count() }}</h2>
                    <p class="text-muted mb-0">Total Artikel</p>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="stat-card">
                    <i class="fas fa-users mb-2"></i>
                    <h2 class="fw-bold mb-0">{{ \App\Models\Penulis::count() }}</h2>
                    <p class="text-muted mb-0">Penulis</p>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="stat-card">
                    <i class="fas fa-tags mb-2"></i>
                    <h2 class="fw-bold mb-0">{{ \App\Models\KategoriArtikel::count() }}</h2>
                    <p class="text-muted mb-0">Kategori</p>
                </div>
            </div>
        </div>

        <!-- Artikel Terbaru -->
        <div class="card">
            <div class="card-header bg-white fw-bold">
                <i class="fas fa-star text-warning me-2"></i> 5 Artikel Terbaru
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @php $artikelTerbaru = \App\Models\Artikel::with('kategori')->orderBy('id','desc')->take(5)->get(); @endphp
                    @forelse($artikelTerbaru as $art)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-file-alt text-secondary me-2"></i>
                                <strong>{{ $art->judul }}</strong>
                                <br>
                                <small class="text-muted">{{ $art->hari_tanggal ?? '' }}</small>
                            </div>
                            <span class="badge-category">{{ $art->kategori->nama_kategori ?? 'Umum' }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-center">Belum ada artikel.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection