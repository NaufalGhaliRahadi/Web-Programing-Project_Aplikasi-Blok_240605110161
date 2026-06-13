@extends('layouts.app')
@section('title', 'Edit Penulis')
@section('content')
<div class="card">
    <div class="card-header">Edit Penulis</div>
    <div class="card-body">
        <form action="{{ route('penulis.update', $penulis->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Nama Depan</label>
                    <input type="text" name="nama_depan" class="form-control @error('nama_depan') is-invalid @enderror" value="{{ old('nama_depan', $penulis->nama_depan) }}">
                    @error('nama_depan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label>Nama Belakang</label>
                    <input type="text" name="nama_belakang" class="form-control @error('nama_belakang') is-invalid @enderror" value="{{ old('nama_belakang', $penulis->nama_belakang) }}">
                    @error('nama_belakang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="user_name" class="form-control @error('user_name') is-invalid @enderror" value="{{ old('user_name', $penulis->user_name) }}">
                @error('user_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label>Password (Kosongkan jika tidak diubah)</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label>Foto Saat Ini</label><br>
                <img src="{{ asset('storage/foto/'.$penulis->foto) }}" width="80" class="img-thumbnail mb-2">
                <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg">
                <small class="text-muted">Upload baru jika ingin mengganti foto</small>
                @error('foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('penulis.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection