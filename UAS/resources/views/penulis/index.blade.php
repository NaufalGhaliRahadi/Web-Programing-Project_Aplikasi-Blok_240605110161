@extends('layouts.app')
@section('title', 'Manajemen Penulis')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="fas fa-users me-2"></i> Daftar Penulis</h3>
    <a href="{{ route('penulis.create') }}" class="btn btn-primary btn-custom">
        <i class="fas fa-user-plus me-1"></i> Tambah Penulis
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:70px">Foto</th>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th style="width:100px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penulis as $item)
                    <tr>
                        <td>
                            <img src="{{ asset('storage/foto/'.($item->foto ?? 'default.png')) }}" 
                                 width="45" height="45" style="object-fit: cover; border-radius: 50%;">
                        </td>
                        <td><strong>{{ $item->nama_depan }} {{ $item->nama_belakang }}</strong></td>
                        <td>{{ $item->user_name }}</td>
                        <td>
                            <a href="{{ route('penulis.edit', $item->id) }}" class="btn btn-sm btn-warning me-1">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('penulis.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus penulis ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center py-4">Belum ada penulis.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection