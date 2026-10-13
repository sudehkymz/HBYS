@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 fw-bold mb-1"><i class="fa-solid fa-user-pen text-warning me-2"></i>Hasta Bilgilerini Düzenle</h2>
        <p class="text-muted small mb-0">Hasta kaydını ve iletişim bilgilerini güncelleyin.</p>
    </div>
    <a href="{{ route('patients.show', $patient) }}" class="btn btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Hasta Kartına Dön
    </a>
</div>

<div class="card border-0 shadow-sm col-12 col-xl-10">
    <div class="card-body p-3 p-md-4">
        <form action="{{ route('patients.update', $patient) }}" method="POST">
            @csrf
            @method('PUT')
            
            <h5 class="text-primary border-bottom pb-2 mb-3"><i class="fa-solid fa-id-card me-1"></i> Demografik & Temel Bilgiler</h5>
            
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label for="national_id" class="form-label">T.C. Kimlik No <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('national_id') is-invalid @enderror" id="national_id" name="national_id" value="{{ old('national_id', $patient->national_id) }}" maxlength="11" required>
                    @error('national_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="first_name" class="form-label">Ad <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name', $patient->first_name) }}" required>
                    @error('first_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="last_name" class="form-label">Soyad <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name', $patient->last_name) }}" required>
                    @error('last_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label for="birth_date" class="form-label">Doğum Tarihi <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('birth_date') is-invalid @enderror" id="birth_date" name="birth_date" value="{{ old('birth_date', $patient->birth_date ? $patient->birth_date->format('Y-m-d') : '') }}" required>
                    @error('birth_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="gender" class="form-label">Cinsiyet <span class="text-danger">*</span></label>
                    <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                        <option value="male" {{ old('gender', $patient->gender) == 'male' ? 'selected' : '' }}>Erkek</option>
                        <option value="female" {{ old('gender', $patient->gender) == 'female' ? 'selected' : '' }}>Kadın</option>
                        <option value="other" {{ old('gender', $patient->gender) == 'other' ? 'selected' : '' }}>Diğer</option>
                    </select>
                    @error('gender')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="blood_type" class="form-label">Kan Grubu</label>
                    <select class="form-select @error('blood_type') is-invalid @enderror" id="blood_type" name="blood_type">
                        <option value="">-- Seçiniz --</option>
                        @foreach(['A Rh+', 'A Rh-', 'B Rh+', 'B Rh-', 'AB Rh+', 'AB Rh-', '0 Rh+', '0 Rh-'] as $bt)
                            <option value="{{ $bt }}" {{ old('blood_type', $patient->blood_type) == $bt ? 'selected' : '' }}>{{ $bt }}</option>
                        @endforeach
                    </select>
                    @error('blood_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <h5 class="text-primary border-bottom pb-2 mb-3 mt-4"><i class="fa-solid fa-address-book me-1"></i> İletişim & Yakın Bilgisi</h5>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="phone" class="form-label">Telefon</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $patient->phone) }}">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="emergency_contact" class="form-label">Acil Durum İrtibatı</label>
                    <input type="text" class="form-control @error('emergency_contact') is-invalid @enderror" id="emergency_contact" name="emergency_contact" value="{{ old('emergency_contact', $patient->emergency_contact) }}">
                    @error('emergency_contact')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="address" class="form-label">Adres</label>
                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="2">{{ old('address', $patient->address) }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <h5 class="text-primary border-bottom pb-2 mb-3 mt-4"><i class="fa-solid fa-notes-medical me-1"></i> Tıbbi Geçmiş Özeti</h5>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="allergies" class="form-label">Alerjiler</label>
                    <textarea class="form-control @error('allergies') is-invalid @enderror" id="allergies" name="allergies" rows="2">{{ old('allergies', $patient->allergies) }}</textarea>
                    @error('allergies')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="chronic_conditions" class="form-label">Kronik Hastalıklar</label>
                    <textarea class="form-control @error('chronic_conditions') is-invalid @enderror" id="chronic_conditions" name="chronic_conditions" rows="2">{{ old('chronic_conditions', $patient->chronic_conditions) }}</textarea>
                    @error('chronic_conditions')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('patients.show', $patient) }}" class="btn btn-secondary">İptal</a>
                <button type="submit" class="btn btn-warning">Bilgileri Güncelle</button>
            </div>
        </form>
    </div>
</div>
@endsection
