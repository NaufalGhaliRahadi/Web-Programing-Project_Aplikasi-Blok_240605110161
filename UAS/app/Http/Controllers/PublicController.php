<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\KategoriArtikel;

class PublicController extends Controller
{
    // Halaman utama: 5 artikel terbaru + widget kategori
    public function home()
    {
        $artikels = Artikel::with('kategori', 'penulis')
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        $kategoris = KategoriArtikel::withCount('artikel')->get();

        return view('public.home', compact('artikels', 'kategoris'));
    }
    

    // Filter artikel berdasarkan kategori
    public function filterByCategory($id)
    {
        $artikels = Artikel::with('kategori', 'penulis')
            ->where('id_kategori', $id)
            ->orderBy('id', 'desc')
            ->get();

        $kategoris = KategoriArtikel::withCount('artikel')->get();
        $selectedKategori = KategoriArtikel::findOrFail($id);

        return view('public.home', compact('artikels', 'kategoris', 'selectedKategori'));
    }
}