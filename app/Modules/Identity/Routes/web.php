<?php

use App\Modules\Identity\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// ─── Misafir Rotaları (Giriş yapılmamış kullanıcılar) ──────────────
Route::middleware('guest')->group(function () {
    Route::get('/giris',   [AuthController::class, 'showLogin'])->name('login');
    Route::post('/giris',  [AuthController::class, 'login']);
});

// ─── Kimlik Doğrulamalı Rotalar ─────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::post('/cikis',  [AuthController::class, 'logout'])->name('logout');
    Route::get('/panel',   [AuthController::class, 'dashboard'])->name('dashboard');
});