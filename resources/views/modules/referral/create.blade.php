@extends('layouts.app')

@section('title', 'Yeni Sevk Kaydı Oluştur')

@section('content')
<div class="container-fluid px-0">

    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h3 class="fw-bold mb-1 text-dark">
                <i class="fa-solid fa-share-nodes text-primary me-2"></i>Yeni Sevk Talebi & Kaydı Oluştur
            </h3>
            <p class="text-muted small mb-0">Hasta için klinik içi (İç Sevk) veya harici hastane/üst merkez (Dış Sevk) kaydı başlatın.</p>
        </div>
        <a href="{{ route('referrals.index') }}" class="btn btn-outline-secondary">
            <i class="fa-solid fa-arrow-left me-1"></i> Sevk Paneline Dön
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm" style="border-radius:14px;">
        <div class="card-body p-4">

            <form action="{{ route('referrals.store') }}" method="POST">
                @csrf

                <div class="row g-4">

                    {{-- Hasta Seçimi --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">1. Sevk Edilecek Hasta <span class="text-danger">*</span></label>
                        <select name="patient_id" class="form-select select2" required>
                            <option value="">-- Hastayı Seçin --</option>
                            @foreach($patients as $p)
                                <option value="{{ $p->id }}" {{ ($selectedPatientId == $p->id || old('patient_id') == $p->id) ? 'selected' : '' }}>
                                    {{ $p->full_name }} (T.C.: {{ $p->national_id }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Sevk Yapan Hekim --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">2. Sevk Edem / Sevk İsteyen Hekim</label>
                        <select name="referring_doctor_id" class="form-select">
                            <option value="">-- Hekim Seçin --</option>
                            @foreach($doctors as $d)
                                <option value="{{ $d->id }}" {{ old('referring_doctor_id') == $d->id ? 'selected' : '' }}>
                                    {{ $d->name }} ({{ $d->specialty ?? 'Klinik Hekimi' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Sevk Türü (İç Sevk / Dış Sevk) --}}
                    <div class="col-12">
                        <label class="form-label fw-bold d-block">3. Sevk Türü <span class="text-danger">*</span></label>
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="referral_type" id="type_internal" value="internal" checked required>
                            <label class="btn btn-outline-purple py-2 fw-bold" for="type_internal" style="border-color:#8b5cf6;">
                                🏥 İÇ SEVK (Hastane İçi Klinikler Arası)
                            </label>

                            <input type="radio" class="btn-check" name="referral_type" id="type_external" value="external" required>
                            <label class="btn btn-outline-info py-2 fw-bold" for="type_external">
                                🚑 DIŞ SEVK (Hastaneler Arası / Üst Merkez)
                            </label>
                        </div>
                    </div>

                    {{-- Hedef Klinik (İç Sevk için) --}}
                    <div class="col-md-6" id="internal_target_box">
                        <label class="form-label fw-bold">Hedef Klinik / Servis <span class="text-danger">*</span></label>
                        <select name="target_clinic_id" class="form-select">
                            <option value="">-- Hedef Kliniği Seçin --</option>
                            @foreach($clinics as $c)
                                <option value="{{ $c->id }}" {{ old('target_clinic_id') == $c->id ? 'selected' : '' }}>
                                    {{ $c->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Hedef Hastane (Dış Sevk için) --}}
                    <div class="col-md-6 d-none" id="external_target_box">
                        <label class="form-label fw-bold">Sevk Edilecek Hastane / Kurum <span class="text-danger">*</span></label>
                        <input type="text" name="target_hospital" class="form-control" placeholder="Örn: Ankara Şehir Hastanesi veya Üniversite Hastanesi" value="{{ old('target_hospital') }}">
                    </div>

                    {{-- Nakil / Ulaşım Tipi --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Ulaşım / Nakil Şekli <span class="text-danger">*</span></label>
                        <select name="transport_type" class="form-select" required>
                            <option value="self" {{ old('transport_type') == 'self' ? 'selected' : '' }}>🚶 Ayaktan / Kendi İmkânıyla</option>
                            <option value="ambulance" {{ old('transport_type') == 'ambulance' ? 'selected' : '' }}>🚑 Ambulans / 112 Acil Ekip Escortlu</option>
                        </select>
                    </div>

                    {{-- Gerekçe --}}
                    <div class="col-12">
                        <label class="form-label fw-bold">4. Sevk Gerekçesi / Tıbbi Nedeni <span class="text-danger">*</span></label>
                        <textarea name="reason" class="form-control" rows="3" placeholder="Hastanın sevk edilme tıbbi gerekçesi, yoğun bakım veya ek tetkik ihtiyacı..." required>{{ old('reason') }}</textarea>
                    </div>

                </div>

                <div class="mt-4 pt-3 border-top text-end">
                    <a href="{{ route('referrals.index') }}" class="btn btn-light me-2">İptal</a>
                    <button type="submit" class="btn btn-primary px-5 fw-bold"><i class="fa-solid fa-share-nodes me-2"></i>Sevk Talebini Oluştur</button>
                </div>

            </form>

        </div>
    </div>

</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const typeInternal = document.getElementById('type_internal');
        const typeExternal = document.getElementById('type_external');
        const internalBox = document.getElementById('internal_target_box');
        const externalBox = document.getElementById('external_target_box');

        function toggleType() {
            if (typeExternal.checked) {
                internalBox.classList.add('d-none');
                externalBox.classList.remove('d-none');
            } else {
                internalBox.classList.remove('d-none');
                externalBox.classList.add('d-none');
            }
        }

        typeInternal.addEventListener('change', toggleType);
        typeExternal.addEventListener('change', toggleType);
        toggleType();
    });
</script>
@endpush
@endsection
