@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 fw-bold mb-1"><i class="fa-solid fa-user-plus text-primary me-2"></i>Yeni Hasta Kaydı</h2>
        <p class="text-muted small mb-0">Sisteme yeni hasta demografik ve iletişim bilgilerini tanımlayın.</p>
    </div>
    <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Listeye Dön
    </a>
</div>

<div class="card border-0 shadow-sm col-12 col-xl-10">
    <div class="card-body p-3 p-md-4">
        <form action="{{ route('patients.store') }}" method="POST">
            @csrf
            <h5 class="text-primary border-bottom pb-2 mb-3"><i class="fa-solid fa-id-card me-1"></i> Demografik & Temel Bilgiler</h5>
            
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label for="national_id" class="form-label">T.C. Kimlik No <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('national_id') is-invalid @enderror" id="national_id" name="national_id" value="{{ old('national_id') }}" maxlength="11" required>
                    @error('national_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="first_name" class="form-label">Ad <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                    @error('first_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="last_name" class="form-label">Soyad <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                    @error('last_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label for="birth_date" class="form-label">Doğum Tarihi <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('birth_date') is-invalid @enderror" id="birth_date" name="birth_date" value="{{ old('birth_date') }}" required>
                    @error('birth_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="gender" class="form-label">Cinsiyet <span class="text-danger">*</span></label>
                    <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                        <option value="">-- Seçiniz --</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Erkek</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Kadın</option>
                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Diğer</option>
                    </select>
                    @error('gender')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="blood_type" class="form-label">Kan Grubu</label>
                    <select class="form-select @error('blood_type') is-invalid @enderror" id="blood_type" name="blood_type">
                        <option value="">-- Seçiniz --</option>
                        <option value="A Rh+" {{ old('blood_type') == 'A Rh+' ? 'selected' : '' }}>A Rh+</option>
                        <option value="A Rh-" {{ old('blood_type') == 'A Rh-' ? 'selected' : '' }}>A Rh-</option>
                        <option value="B Rh+" {{ old('blood_type') == 'B Rh+' ? 'selected' : '' }}>B Rh+</option>
                        <option value="B Rh-" {{ old('blood_type') == 'B Rh-' ? 'selected' : '' }}>B Rh-</option>
                        <option value="AB Rh+" {{ old('blood_type') == 'AB Rh+' ? 'selected' : '' }}>AB Rh+</option>
                        <option value="AB Rh-" {{ old('blood_type') == 'AB Rh-' ? 'selected' : '' }}>AB Rh-</option>
                        <option value="0 Rh+" {{ old('blood_type') == '0 Rh+' ? 'selected' : '' }}>0 Rh+</option>
                        <option value="0 Rh-" {{ old('blood_type') == '0 Rh-' ? 'selected' : '' }}>0 Rh-</option>
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
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" placeholder="05XXXXXXXXX">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="emergency_contact" class="form-label">Acil Durum İrtibatı</label>
                    <input type="text" class="form-control @error('emergency_contact') is-invalid @enderror" id="emergency_contact" name="emergency_contact" value="{{ old('emergency_contact') }}" placeholder="Ad Soyad - Yakınlık - Telefon">
                    @error('emergency_contact')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="address" class="form-label">Adres</label>
                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="2">{{ old('address') }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <h5 class="text-primary border-bottom pb-2 mb-3 mt-4"><i class="fa-solid fa-notes-medical me-1"></i> Tıbbi Geçmiş Özeti</h5>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="allergies" class="form-label">Alerjiler</label>
                    <textarea class="form-control @error('allergies') is-invalid @enderror" id="allergies" name="allergies" rows="2" placeholder="Örn: Penisilin, Arı Sütü">{{ old('allergies') }}</textarea>
                    @error('allergies')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="chronic_conditions" class="form-label">Kronik Hastalıklar</label>
                    <textarea class="form-control @error('chronic_conditions') is-invalid @enderror" id="chronic_conditions" name="chronic_conditions" rows="2" placeholder="Örn: Hipertansiyon, Tip 2 Diyabet">{{ old('chronic_conditions') }}</textarea>
                    @error('chronic_conditions')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('patients.index') }}" class="btn btn-secondary">İptal</a>
                <button type="submit" class="btn btn-primary">Kaydet & Hasta Kartını Aç</button>
            </div>
        </form>
    </div>
</div>
@endsection
