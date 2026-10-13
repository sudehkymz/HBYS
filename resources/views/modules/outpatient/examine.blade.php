@extends('layouts.app')

@section('title', 'Doktor Poliklinik Muayene Ekranı')

@section('content')
<div class="container-fluid px-0">

    {{-- Başlık ve Hasta Özet Barı --}}
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h3 class="fw-bold mb-1 text-dark">
                <i class="fa-solid fa-notes-medical text-primary me-2"></i>Doktor Poliklinik Muayene Ekranı
            </h3>
            <p class="text-muted small mb-0">
                Hasta: <strong>{{ $patient->full_name }}</strong> (T.C.: {{ $patient->national_id }}) | Yaş: {{ $patient->birth_date ? $patient->birth_date->age : '-' }} | Cinsiyet: {{ $patient->gender === 'male' ? 'Erkek' : 'Kadın' }}
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('ehr.show', $patient) }}" target="_blank" class="btn btn-outline-primary">
                <i class="fa-solid fa-folder-open me-1"></i> Tüm Tıbbi Geçmiş (EHR)
            </a>
            <a href="{{ route('prescription.index') }}?patient_id={{ $patient->id }}" target="_blank" class="btn btn-purple text-white" style="background:#8b5cf6;">
                <i class="fa-solid fa-pills me-1"></i> E-Reçete Yaz
            </a>
            <a href="{{ route('ai.index') }}" target="_blank" class="btn btn-info text-white">
                <i class="fa-solid fa-robot me-1"></i> AI Karar Desteği
            </a>
            <a href="{{ route('outpatient.index') }}" class="btn btn-outline-secondary">
                <i class="fa-solid fa-arrow-left me-1"></i> Poliklinik Sırasına Dön
            </a>
        </div>
    </div>

    <form action="{{ route('outpatient.complete', $examination) }}" method="POST">
        @csrf

        <div class="row g-4">

            {{-- Sol Kolon: Şikayet & Anamnez & ICD-10 Tanı --}}
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm mb-4" style="border-radius:14px;">
                    <div class="card-header bg-white border-0 fw-bold py-3">
                        <i class="fa-solid fa-user-pen text-primary me-2"></i>1. Şikayet & Anamnez (Chief Complaint)
                    </div>
                    <div class="card-body">
                        <textarea name="chief_complaint" class="form-control" rows="3" placeholder="Hastanın polikliniğe geliş sebebi, ana şikayetleri ve hikayesi...">{{ old('chief_complaint', $examination->chief_complaint) }}</textarea>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4" style="border-radius:14px;">
                    <div class="card-header bg-white border-0 fw-bold py-3">
                        <i class="fa-solid fa-stethoscope text-primary me-2"></i>2. Fiziki Muayene Bulguları (Physical Examination)
                    </div>
                    <div class="card-body">
                        <textarea name="physical_examination" class="form-control" rows="3" placeholder="Sistemik fiziki muayene bulguları, palpasyon, oskültasyon vb...">{{ old('physical_examination', $examination->physical_examination) }}</textarea>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4" style="border-radius:14px;">
                    <div class="card-header bg-white border-0 fw-bold py-3 d-flex justify-content-between align-items-center">
                        <span><i class="fa-solid fa-disease text-danger me-2"></i>3. Teşhis / ICD-10 Tanı Kodu <span class="text-danger">*</span></span>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <input type="text" name="icd10_code" id="icd10_input" class="form-control form-control-lg fw-bold" placeholder="Örn: I10 - Esansiyel Hipertansiyon" value="{{ old('icd10_code', $examination->icd10_code) }}" required>
                        </div>
                        <div class="small text-muted mb-2 fw-semibold"><i class="fa-solid fa-bolt text-warning me-1"></i>Hızlı Sık Kullanılan Tanı Seçici:</div>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($icd10Codes as $code)
                                <button type="button" class="btn btn-sm btn-outline-secondary icd-btn" data-code="{{ $code }}">
                                    {{ $code }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sağ Kolon: Tedavi Planı & Muayene Sonlandırma Aksiyonu --}}
            <div class="col-lg-5">

                <div class="card border-0 shadow-sm mb-4" style="border-radius:14px;">
                    <div class="card-header bg-white border-0 fw-bold py-3">
                        <i class="fa-solid fa-clipboard-list text-success me-2"></i>4. Tedavi Planı & Öneriler
                    </div>
                    <div class="card-body">
                        <textarea name="treatment_plan" class="form-control" rows="4" placeholder="Hastaya verilen öneriler, reçete edilen ilaç talimatları, kontrol tarihi...">{{ old('treatment_plan', $examination->treatment_plan) }}</textarea>
                    </div>
                </div>

                {{-- Sonlandırma Aksiyon Kartı --}}
                <div class="card border-0 shadow-sm border-start border-4 border-success" style="border-radius:14px;">
                    <div class="card-header bg-white border-0 fw-bold py-3">
                        <i class="fa-solid fa-check-double text-success me-2"></i>5. Muayene Kararı & Sonlandırma
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Muayene Sonuç Kararı <span class="text-danger">*</span></label>
                            <select name="status" class="form-select form-select-lg fw-semibold" required>
                                <option value="completed" {{ old('status', $examination->status) == 'completed' ? 'selected' : '' }}>
                                    ✅ Muayene Tamamlandı (Şifa / Reçete Düzenlendi)
                                </option>
                                <option value="referred" {{ old('status', $examination->status) == 'referred' ? 'selected' : '' }}>
                                    ↪️ Başka Kliniğe / Üst Merkeze Sevk
                                </option>
                                <option value="admitted" {{ old('status', $examination->status) == 'admitted' ? 'selected' : '' }}>
                                    🛏️ Hasta Yatış İstemi Verildi (Inpatient)
                                </option>
                            </select>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg fw-bold py-3">
                                <i class="fa-solid fa-floppy-disk me-2"></i>Muayeneyi Kaydet ve Sonlandır
                            </button>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </form>

</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const icdInput = document.getElementById('icd10_input');
        document.querySelectorAll('.icd-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                icdInput.value = this.getAttribute('data-code');
            });
        });
    });
</script>
@endpush
@endsection
