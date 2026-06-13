@extends('layouts.app')
@section('title', 'Manajemen Artikel')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="fas fa-newspaper me-2"></i> Daftar Artikel</h3>
    <a href="{{ route('artikel.create') }}" class="btn btn-primary btn-custom">
        <i class="fas fa-plus me-1"></i> Artikel Baru
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:80px">Gambar</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Penulis</th>
                        <th>Tanggal</th>
                        <th style="width:100px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($artikel as $item)
                    <tr>
                        <td>
                            @php 
                                $gambarPath = 'storage/gambar/'.$item->gambar;
                                $hasImage = $item->gambar && file_exists(public_path($gambarPath));
                            @endphp
                            @if($hasImage)
                                <img src="{{ asset($gambarPath) }}" width="60" height="60" style="object-fit: cover; border-radius: 8px;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center" style="width:60px; height:60px; border-radius:8px;">
                                    <i class="fas fa-image text-secondary fs-4"></i>
                                </div>
                            @endif
                        </td>
                        <td><strong>{{ $item->judul }}</strong></td>
                        <td><span class="badge-category">{{ $item->kategori->nama_kategori ?? '-' }}</span></td>
                        <td>{{ $item->penulis->nama_depan ?? '' }} {{ $item->penulis->nama_belakang ?? '' }}</td>
                        <td><small>{{ $item->hari_tanggal }}</small></td>
                        <td>
                            <a href="{{ route('artikel.edit', $item->id) }}" class="btn btn-sm btn-warning me-1">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('artikel.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus artikel ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-4">Belum ada artikel. <a href="{{ route('artikel.create') }}">Buat artikel pertama</a></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection