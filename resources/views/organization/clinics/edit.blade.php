@extends('layouts.app')

@section('title', 'Klinik Düzenle')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold mb-0"><i class="fa-solid fa-pen-to-square text-primary me-2"></i>Klinik Düzenle</h3>
            <a href="{{ route('organization.clinics.index') }}" class="btn btn-outline-secondary">
                <i class="fa-solid fa-arrow-left me-1"></i> Geri Dön
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <form action="{{ route('organization.clinics.update', $clinic) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="floor_id" class="form-label fw-semibold">Kat Seçin <span class="text-danger">*</span></label>
                        <select name="floor_id" id="floor_id" class="form-select @error('floor_id') is-invalid @enderror" required>
                            <option value="">-- Kat Seçin --</option>
                            @foreach($floors as $floor)
                                <option value="{{ $floor->id }}" {{ old('floor_id', $clinic->floor_id) == $floor->id ? 'selected' : '' }}>
                                    {{ $floor->name }} ({{ $floor->building->name ?? 'Bina yok' }})
                                </option>
                            @endforeach
                        </select>
                        @error('floor_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="name" class="form-label fw-semibold">Klinik Adı <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $clinic->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('organization.clinics.index') }}" class="btn btn-light">İptal</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-save me-1"></i> Güncelle
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
