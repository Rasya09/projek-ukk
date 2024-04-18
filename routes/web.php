<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FotoController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FotoController::class, 'index'])->name('home');

// Route untuk menampilkan form login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// Route untuk proses login
Route::post('/proseslogin', [LoginController::class, 'login'])->name('prosseslogin');

// Route untuk proses logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route untuk menampilkan form register
Route::get('/register', [LoginController::class, 'indexregis'])->name('register');

// Route untuk proses register
Route::post('/register', [LoginController::class, 'register'])->name('prosesregister');

Route::get('/tambah-foto', [FotoController::class, 'create'])->name('tambah-foto');

Route::post('/upload-photo', [FotoController::class, 'store'])->name('kirim-foto');

Route::get('/photos/{id}', [FotoController::class, 'show'])->name('photo.detail');

Route::get('/photos/{id}/edit', [FotoController::class, 'edit'])->name('edit-foto');

Route::put('/foto/{id}', [FotoController::class, 'update'])->name('update-foto');

Route::post('/photo/{id}/like', [FotoController::class, 'toggleLike'])->name('photo.like');

Route::post('/komentar/{id}/kirim', [FotoController::class, 'kirimKomentar'])->name('kirim-komentar');

Route::delete('/photo/{id}', [FotoController::class, 'destroy'])->name('hapus-foto');

Route::get('/user/{id}', [UserController::class, 'show'])->name('user.profile');

Route::get('/albums/create', [AlbumController::class, 'create'])->name('albums.create');

Route::post('/albums', [AlbumController::class, 'store'])->name('store-album');

