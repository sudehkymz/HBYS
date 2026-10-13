@extends('layouts.app')

@section('title', 'Yeni Muayene Odası Ekle')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold mb-0"><i class="fa-solid fa-plus-circle text-primary me-2"></i>Yeni Muayene Odası Ekle</h3>
            <a href="{{ route('organization.examination-rooms.index') }}" class="btn btn-outline-secondary">
                <i class="fa-solid fa-arrow-left me-1"></i> Geri Dön
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <form action="{{ route('organization.examination-rooms.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="poliklinik_id" class="form-label fw-semibold">Poliklinik Seçin <span class="text-danger">*</span></label>
                        <select name="poliklinik_id" id="poliklinik_id" class="form-select @error('poliklinik_id') is-invalid @enderror" required>
                            <option value="">-- Poliklinik Seçin --</option>
                            @foreach($polikliniks as $poliklinik)
                                <option value="{{ $poliklinik->id }}" {{ old('poliklinik_id') == $poliklinik->id ? 'selected' : '' }}>
                                    {{ $poliklinik->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('poliklinik_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Muayene Odası Adı / Kodu <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Örn: Oda 101, Muayene Odası A" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="capacity" class="form-label fw-semibold">Kapasite (Hasta Sayısı) <span class="text-danger">*</span></label>
                        <input type="number" name="capacity" id="capacity" class="form-control @error('capacity') is-invalid @enderror" value="{{ old('capacity', 1) }}" min="1" max="100" required>
                        @error('capacity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('organization.examination-rooms.index') }}" class="btn btn-light">İptal</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-save me-1"></i> Kaydet
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
