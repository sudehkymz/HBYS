@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h2><i class="fa-solid fa-user-plus text-primary me-2"></i>Yeni Doktor Ekle</h2>
</div>

<div class="card border-0 shadow-sm col-md-8">
    <div class="card-body p-4">
        <form action="{{ route('personnel.doctors.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Ad Soyad <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="specialty" class="form-label">Uzmanlık Alanı <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('specialty') is-invalid @enderror" id="specialty" name="specialty" value="{{ old('specialty') }}" placeholder="Örn: Kardiyoloji, Dahiliye, Genel Cerrahi" required>
                @error('specialty')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">E-posta Adresi <span class="text-danger">*</span></label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Telefon</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}">
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="clinic_id" class="form-label">Bağlı Olduğu Klinik</label>
                <select class="form-select @error('clinic_id') is-invalid @enderror" id="clinic_id" name="clinic_id">
                    <option value="">-- Klinik Seçiniz (Opsiyonel) --</option>
                    @foreach($clinics as $clinic)
                        <option value="{{ $clinic->id }}" {{ old('clinic_id') == $clinic->id ? 'selected' : '' }}>
                            {{ $clinic->name }}
                        </option>
                    @endforeach
                </select>
                @error('clinic_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('personnel.doctors.index') }}" class="btn btn-secondary">İptal</a>
                <button type="submit" class="btn btn-primary">Kaydet</button>
            </div>
        </form>
    </div>
</div>
@endsection
