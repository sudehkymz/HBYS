<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Kök URL → Kimliği doğrulanmış kullanıcıları panele, diğerlerini giriş sayfasına veya varsayılan moda gönder
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    if (\Illuminate\Support\Facades\Route::has('login')) {
        return redirect()->route('login');
    }
    if (\Illuminate\Support\Facades\Route::has('patient.index')) {
        return redirect()->route('patient.index');
    }
    return redirect()->route('ai.index');
});

Route::get('/auto-login', function () {
    $user = \App\Modules\Identity\Models\User::where('email', 'admin@hbys.com')->first();
    if ($user) {
        Auth::login($user);
        return redirect()->route('dashboard');
    }
    return 'Admin user not found!';
});


