<?php

namespace App\Http\Controllers;

use App\Models\KategoriArtikel;
use Illuminate\Http\Request;

class KategoriArtikelController extends Controller
{
    public function index()
    {
        $kategori = KategoriArtikel::orderBy('nama_kategori')->get();
        return view('kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
{
    // Cek apakah request masuk (untuk debugging)
    // dd($request->all()); // Hapus komentar untuk test, lalu komentar lagi

    $request->validate([
        'nama_kategori' => 'required|string|max:100|unique:kategori_artikel,nama_kategori',
        'keterangan' => 'nullable|string'
    ]);

    KategoriArtikel::create([
        'nama_kategori' => $request->nama_kategori,
        'keterangan' => $request->keterangan
    ]);

    return redirect()->route('kategori.index')->with('sukses', 'Kategori berhasil ditambahkan.');
}

    public function edit($id)
    {
        $kategori = KategoriArtikel::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $kategori = KategoriArtikel::findOrFail($id);
        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori_artikel,nama_kategori,' . $id,
            'keterangan' => 'nullable|string'
        ]);
        $kategori->update($request->only('nama_kategori', 'keterangan'));
        return redirect()->route('kategori.index')->with('sukses', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kategori = KategoriArtikel::findOrFail($id);
        try {
            $kategori->delete();
            return redirect()->route('kategori.index')->with('sukses', 'Kategori dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('kategori.index')->with('gagal', 'Kategori tidak bisa dihapus karena masih memiliki artikel.');
        }
    }
}