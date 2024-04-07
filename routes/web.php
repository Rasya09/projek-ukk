<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FotoController;
use App\Http\Controllers\HomeController;
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
