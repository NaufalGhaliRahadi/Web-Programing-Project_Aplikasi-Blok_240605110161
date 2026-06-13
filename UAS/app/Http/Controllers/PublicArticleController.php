<?php

namespace App\Http\Controllers;

use App\Models\Artikel;

class PublicArticleController extends Controller
{
    // Halaman detail artikel + 5 artikel terkait
    public function show($id)
    {
        $artikel = Artikel::with('kategori', 'penulis')->findOrFail($id);

        // 5 artikel terkait (kategori sama, kecuali artikel ini)
        $artikelTerkait = Artikel::with('kategori')
            ->where('id_kategori', $artikel->id_kategori)
            ->where('id', '!=', $artikel->id)
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        return view('public.show', compact('artikel', 'artikelTerkait'));
    }
}