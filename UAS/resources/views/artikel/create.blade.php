@extends('layouts.app')
@section('title', 'Tambah Artikel')
@section('content')
<div class="card">
    <div class="card-header">Tambah Artikel</div>
    <div class="card-body">
        <form action="{{ route('artikel.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label>Judul</label>
                <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul') }}">
                @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label>Kategori</label>
                <select name="id_kategori" class="form-control @error('id_kategori') is-invalid @enderror">
                    <option value="">Pilih Kategori</option>
                    @foreach($kategori as $kat)
                        <option value="{{ $kat->id }}" {{ old('id_kategori') == $kat->id ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                    @endforeach
                </select>
                @error('id_kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label>Isi Artikel</label>
                <textarea name="isi" rows="8" class="form-control @error('isi') is-invalid @enderror">{{ old('isi') }}</textarea>
                @error('isi') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label>Gambar Artikel</label>
                <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg">
                @error('gambar') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('artikel.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection