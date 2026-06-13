<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriArtikelController;
use App\Http\Controllers\PenulisController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\PublicArticleController;
use Illuminate\Support\Facades\Route;

// ========== ROUTE PUBLIK (tanpa login) ==========
Route::get('/', [PublicController::class, 'home'])->name('public.home');
Route::get('/kategori-publik/{id}', [PublicController::class, 'filterByCategory'])->name('public.category');
// Route publik untuk detail artikel: gunakan prefix /p/ agar tidak bentrok dengan resource
Route::get('/p/artikel/{id}', [PublicArticleController::class, 'show'])->name('public.article.show');

// ========== ROUTE UNTUK TAMU (BELUM LOGIN) ==========
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'proses'])->name('login.proses');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
});

// ========== ROUTE YANG MEMERLUKAN LOGIN (CMS) ==========
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Resource CRUD
    Route::resource('kategori', KategoriArtikelController::class);
    Route::resource('penulis', PenulisController::class);
    Route::resource('artikel', ArtikelController::class);
});
