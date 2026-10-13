@extends('layouts.app')

@section('title', 'Yeni Acil Giriş & Triyaj Kaydı')

@section('content')
<div class="container-fluid px-0">

    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h3 class="fw-bold mb-1 text-dark">
                <i class="fa-solid fa-truck-medical text-danger me-2"></i>Yeni Acil Servis Başvurusu & Triyaj Kaydı
            </h3>
            <p class="text-muted small mb-0">Acil servise gelen hastanın vitallerini girin ve triyaj kodunu belirleyin.</p>
        </div>
        <a href="{{ route('emergency.index') }}" class="btn btn-outline-secondary">
            <i class="fa-solid fa-arrow-left me-1"></i> Acil Paneline Dön
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

            <form action="{{ route('emergency.store') }}" method="POST">
                @csrf

                <div class="row g-4">

                    {{-- Hasta Seçimi --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">1. Hasta Seçimi <span class="text-danger">*</span></label>
                        <select name="patient_id" class="form-select select2" required>
                            <option value="">-- Acil Kaydı Yapılacak Hastayı Seçin --</option>
                            @foreach($patients as $p)
                                <option value="{{ $p->id }}" {{ ($selectedPatientId == $p->id || old('patient_id') == $p->id) ? 'selected' : '' }}>
                                    {{ $p->full_name }} (T.C.: {{ $p->national_id }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Triyaj Kategorisi Seçimi --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold d-block">2. Triyaj Kategorisi (Aciliyet Seviyesi) <span class="text-danger">*</span></label>
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="triage_category" id="cat_red" value="red" required>
                            <label class="btn btn-outline-danger py-2 fw-bold" for="cat_red">
                                🔴 KIRMIZI KOD (Kritik / Acil)
                            </label>

                            <input type="radio" class="btn-check" name="triage_category" id="cat_yellow" value="yellow" checked required>
                            <label class="btn btn-outline-warning py-2 fw-bold text-dark" for="cat_yellow">
                                🟡 SARI KOD (Orta Derece Acil)
                            </label>

                            <input type="radio" class="btn-check" name="triage_category" id="cat_green" value="green" required>
                            <label class="btn btn-outline-success py-2 fw-bold" for="cat_green">
                                🟢 YEŞİL KOD (Ayaktan / Hafif)
                            </label>
                        </div>
                    </div>

                    {{-- Şikayet / Travma Notu --}}
                    <div class="col-12">
                        <label class="form-label fw-bold">3. Başvuru Şikayeti / Travma Notu <span class="text-danger">*</span></label>
                        <textarea name="chief_complaint" class="form-control" rows="3" placeholder="Hastanın acil başvuru şikayeti, travma mekanizması veya semptomları..." required>{{ old('chief_complaint') }}</textarea>
                    </div>

                    {{-- Vitaller --}}
                    <div class="col-12">
                        <div class="p-3 bg-light rounded border">
                            <label class="form-label fw-bold text-primary mb-3"><i class="fa-solid fa-heart-pulse me-2"></i>4. İlk Kabul Hayati Bulguları (Vitals)</label>
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label small fw-semibold">Tansiyon (mmHg)</label>
                                    <input type="text" name="blood_pressure" class="form-control" placeholder="120/80" value="{{ old('blood_pressure', '120/80') }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small fw-semibold">Nabız (/dk)</label>
                                    <input type="number" name="pulse" class="form-control" placeholder="75" value="{{ old('pulse', 80) }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small fw-semibold">Vücut Ateşi (°C)</label>
                                    <input type="number" step="0.1" name="fever" class="form-control" placeholder="36.6" value="{{ old('fever', 36.6) }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small fw-semibold">SpO2 (%)</label>
                                    <input type="number" name="spo2" class="form-control" placeholder="98" value="{{ old('spo2', 98) }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Doktor Atama --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">5. Sorumlu Acil Hekimi Atama (Opsiyonel)</label>
                        <select name="assigned_doctor_id" class="form-select">
                            <option value="">-- Hekim Atama (Sonra Atanabilir) --</option>
                            @foreach($doctors as $d)
                                <option value="{{ $d->id }}" {{ old('assigned_doctor_id') == $d->id ? 'selected' : '' }}>
                                    {{ $d->name }} ({{ $d->specialty ?? 'Acil Tıp' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="mt-4 pt-3 border-top text-end">
                    <a href="{{ route('emergency.index') }}" class="btn btn-light me-2">İptal</a>
                    <button type="submit" class="btn btn-danger px-5 fw-bold"><i class="fa-solid fa-truck-medical me-2"></i>Acil Kaydı Oluştur & Triyaja Al</button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
