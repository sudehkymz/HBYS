@extends('layouts.auth')

@section('title', 'Giriş Yap')

@section('content')
    <h4>Tekrar Hoş Geldiniz</h4>
    <p class="subtitle">Sisteme erişmek için bilgilerinizi giriniz.</p>

    <form method="POST" action="{{ route('login') }}" novalidate>
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">E-posta Adresi</label>
            <input
                type="email"
                id="email"
                name="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}"
                placeholder="ornek@hastane.com"
                autocomplete="email"
                required
                autofocus
            >
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <label for="password" class="form-label mb-0">Şifre</label>
            </div>
            <input
                type="password"
                id="password"
                name="password"
                class="form-control @error('password') is-invalid @enderror"
                placeholder="••••••••"
                autocomplete="current-password"
                required
            >
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4 d-flex align-items-center">
            <input type="checkbox" id="remember" name="remember" class="form-check-input me-2">
            <label for="remember" class="form-label mb-0" style="cursor:pointer;">Beni hatırla</label>
        </div>

        <button type="submit" class="btn btn-primary w-100">
            <i class="fa-solid fa-arrow-right-to-bracket me-2"></i>Giriş Yap
        </button>
    </form>
@endsection
