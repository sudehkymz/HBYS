@extends('layouts.app')

@section('title', 'Yeni Poliklinik Ekle')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold mb-0"><i class="fa-solid fa-plus-circle text-primary me-2"></i>Yeni Poliklinik Ekle</h3>
            <a href="{{ route('organization.polikliniks.index') }}" class="btn btn-outline-secondary">
                <i class="fa-solid fa-arrow-left me-1"></i> Geri Dön
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <form action="{{ route('organization.polikliniks.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="clinic_id" class="form-label fw-semibold">Klinik Seçin <span class="text-danger">*</span></label>
                        <select name="clinic_id" id="clinic_id" class="form-select @error('clinic_id') is-invalid @enderror" required>
                            <option value="">-- Klinik Seçin --</option>
                            @foreach($clinics as $clinic)
                                <option value="{{ $clinic->id }}" {{ old('clinic_id') == $clinic->id ? 'selected' : '' }}>
                                    {{ $clinic->name }} ({{ $clinic->floor->name ?? '' }})
                                </option>
                            @endforeach
                        </select>
                        @error('clinic_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="name" class="form-label fw-semibold">Poliklinik Adı <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Örn: Göz Hastalıkları Polikliniği 1" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('organization.polikliniks.index') }}" class="btn btn-light">İptal</a>
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
