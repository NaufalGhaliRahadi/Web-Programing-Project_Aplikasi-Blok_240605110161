<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Penulis;
use App\Models\KategoriArtikel;
use Illuminate\Support\Facades\Auth; // ← perbaikan: jangan pakai Facades\Auth

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // penulis yang login
        $userId = $user->id;

        // Total artikel milik penulis ini
        $totalArtikel = Artikel::where('id_penulis', $userId)->count();

        // Total semua penulis (bisa tetap untuk admin)
        $totalPenulis = Penulis::count();

        // Total semua kategori
        $totalKategori = KategoriArtikel::count();

        // 5 artikel terbaru milik penulis ini
        $artikelTerbaru = Artikel::with('kategori')
            ->where('id_penulis', $userId)
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        $waktuLogin = session('waktu_login', 'Belum tercatat');

        return view('dashboard.index', compact('user', 'totalArtikel', 'totalPenulis', 'totalKategori', 'artikelTerbaru', 'waktuLogin'));
    }
}