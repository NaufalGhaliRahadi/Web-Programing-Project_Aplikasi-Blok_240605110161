@extends('layouts.app')
@section('title', 'Daftar Kategori')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3><i class="fas fa-tags me-2"></i> Daftar Kategori</h3>
    <a href="{{ route('kategori.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i> Tambah Kategori</a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:50px">No</th>
                        <th>Nama Kategori</th>
                        <th>Keterangan</th>
                        <th style="width:100px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategori as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $item->nama_kategori }}</strong></td>
                        <td>{{ $item->keterangan ?? '-' }}</td>
                        <td>
                            <a href="{{ route('kategori.edit', $item->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('kategori.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus kategori ini?')"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                        <tr><td colspan="4" class="text-center py-4">Belum ada kategori. <a href="{{ route('kategori.create') }}">Tambah kategori pertama</a></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection