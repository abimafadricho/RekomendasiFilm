<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RekomendasiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

// =========================================================
// AUTH — Login, Register, Logout (tidak perlu login)
// =========================================================
Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',   [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register',[AuthController::class, 'register'])->name('register.post');
Route::post('/logout',  [AuthController::class, 'logout'])->name('logout');

// Halaman Utama - Daftar Film
Route::get('/', [FilmController::class, 'index'])->name('home');
Route::get('/films', [FilmController::class, 'index'])->name('films.index');
Route::get('/films/{id}', [FilmController::class, 'detail'])->name('films.detail');

// Halaman Film
Route::get('/films', [FilmController::class, 'index'])->name('films.index');
Route::get('/films/{id}', [FilmController::class, 'detail'])->name('films.detail');

// Halaman Rekomendasi
Route::middleware('auth.user')->group(function () {
    // Rekomendasi
    Route::get('/rekomendasi', [RekomendasiController::class, 'show'])->name('rekomendasi.index');
    Route::get('/rekomendasi/kandidat', [RekomendasiController::class, 'show'])->name('rekomendasi.show');
 
    // Rating
    Route::post('/rating', [RatingController::class, 'simpan'])->name('rating.simpan');
    Route::get('/rating/{user_id}', [RatingController::class, 'riwayat'])->name('rating.riwayat');
});
// Rating Film
Route::post('/rating', [RatingController::class, 'simpan'])->name('rating.simpan');
Route::get('/rating/{user_id}', [RatingController::class, 'riwayat'])->name('rating.riwayat');

// Dashboard Admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/films', [AdminController::class, 'films'])->name('films');
    Route::post('/films', [AdminController::class, 'tambahFilm'])->name('films.tambah');
    Route::delete('/films/{id}', [AdminController::class, 'hapusFilm'])->name('films.hapus');
});