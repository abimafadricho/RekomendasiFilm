<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RekomendasiController;
use App\Http\Controllers\AdminController;

// Halaman Utama - Daftar Film
Route::get('/', [FilmController::class, 'index'])->name('home');

// Halaman Film
Route::get('/films', [FilmController::class, 'index'])->name('films.index');
Route::get('/films/{id}', [FilmController::class, 'detail'])->name('films.detail');

// Halaman Rekomendasi
Route::get('/rekomendasi', [RekomendasiController::class, 'index'])->name('rekomendasi.index');
Route::get('/rekomendasi/{user_id}', [RekomendasiController::class, 'show'])->name('rekomendasi.show');

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