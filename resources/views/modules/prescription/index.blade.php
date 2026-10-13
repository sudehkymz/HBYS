@extends('layouts.app')

@section('title', 'Doktor E-Reçete Düzenleme & İlaç Güvenlik Paneli')

@push('styles')
<style>
    body { background-color: #f8fafc; color: #0f172a; }

    .card-clean {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.03), 0 1px 2px rgba(15, 23, 42, 0.02);
    }

    /* Soft & Modern Renk Rozetleri */
    .bg-indigo-soft { background-color: #eef2ff; color: #4338ca; border: 1px solid #c7d2fe; }
    .bg-emerald-soft { background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
    .text-emerald { color: #059669 !important; }
    .bg-amber-soft { background-color: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
    .bg-rose-soft { background-color: #fff1f2; color: #be123c; border: 1px solid #fecdd3; }
    .bg-sky-soft { background-color: #f0f9ff; color: #0369a1; border: 1px solid #bae6fd; }
    .bg-slate-soft { background-color: #f8fafc; color: #334155; border: 1px solid #e2e8f0; }

    .stat-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.35rem 0.85rem;
        border-radius: 9999px;
        font-size: 0.82rem;
        font-weight: 600;
    }

    .btn-gradient-success {
        background: linear-gradient(135deg, #059669 0%, #10b981 100%);
        border: none;
        color: #ffffff;
    }
    .btn-gradient-success:hover {
        background: linear-gradient(135deg, #047857 0%, #059669 100%);
        color: #ffffff;
    }

    .form-control:focus, .form-select:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 0.2rem rgba(16, 185, 129, 0.15);
    }
</style>
@endpush

@section('content')

    <!-- 1. ÜST BAŞLIK VE HIZLI NAVİGASYON -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 pb-2 border-bottom">
        <div>
            <h4 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                <i class="bi bi-capsule-pill text-emerald"></i> E-Reçete Masası & İlaç Güvenlik Paneli
            </h4>
            <p class="text-muted mb-0 small">AI İlaç Danışmanlığı, Alerji Çapraz Kontrolü & SGK Medula E-Reçete Üretimi</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="stat-pill bg-emerald-soft">
                <i class="bi bi-shield-check"></i> SGK Medula Entegre
            </span>
            <a href="{{ route('medical_report.chief_physician', !empty($activePatient) ? ['patient_id' => $activePatient['patient_id']] : []) }}" class="btn btn-outline-primary btn-sm fw-semibold rounded-pill px-3">
                <i class="bi bi-person-workspace me-1"></i> Klinik Masa &rarr;
            </a>
        </div>
    </div>

    <!-- 2. CANLI HASTA ARAMA VE SEÇİM BARI (TEK SATIR SADE DÜZEN) -->
    <div class="card-clean p-2.5 mb-3 bg-white border shadow-sm rounded-3">
        <form action="{{ route('prescription.index') }}" method="GET" id="patientSearchForm">
            <div class="row g-2 align-items-center">
                <div class="col-md-7 position-relative">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light text-emerald border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" id="patient_search_input" name="search_query" class="form-control form-control-sm border-start-0 border-end-0 fw-semibold" placeholder="Reçete yazılacak hasta adı, TC Kimlik No veya protokol..." value="{{ $searchQuery ?? '' }}" autocomplete="off" oninput="handlePatientSearchInput(this.value)" onfocus="handlePatientSearchInput(this.value)">
                        <select name="patient_id" class="form-select form-select-sm fw-semibold border-start-0" style="max-width:260px;" onchange="this.form.submit()">
                            <option value="" {{ empty($activePatient) ? 'selected' : '' }}>-- Lütfen Hasta Seçiniz --</option>
                            @foreach($patients as $id => $p)
                                <option value="{{ $id }}" {{ (!empty($activePatient) && ($activePatient['patient_id'] ?? 0) == $id) ? 'selected' : '' }}>
                                    {{ $p['first_name'] }} {{ $p['last_name'] }} (TC: {{ $p['national_id'] }})
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-gradient-success btn-sm fw-semibold px-3">
                            <i class="bi bi-arrow-right-circle me-1"></i> Getir
                        </button>
                        @if(!empty($activePatient))
                            <a href="{{ route('prescription.index') }}" class="btn btn-outline-secondary btn-sm px-2.5" title="Hasta Seçimini Temizle">
                                <i class="bi bi-x-circle me-1"></i> Temizle
                            </a>
                        @endif
                    </div>

                    <!-- CANLI AUTOCOMPLETE DÜŞÜM MENÜSÜ -->
                    <div id="patient_search_dropdown" class="dropdown-menu shadow-lg w-100 p-0 border-0 mt-1" style="display:none; max-height:380px; overflow-y:auto; z-index:1050; position:absolute; top:100%; left:0;">
                        <div class="p-2 bg-slate-soft text-muted small fw-bold border-bottom d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-person-lines-fill me-1 text-emerald"></i> Eşleşen Hasta Adayları:</span>
                            <span class="badge bg-success" id="search_match_count">0</span>
                        </div>
                        <div class="list-group list-group-flush small" id="search_results_list">
                            <!-- Dynamic items injected via JS -->
                        </div>
                    </div>
                </div>

                <div class="col-md-5 text-end">
                    @if(!empty($activePatient))
                        <div class="d-inline-flex align-items-center gap-2 bg-emerald-soft px-3 py-1.5 rounded-pill small">
                            <i class="bi bi-person-check-fill text-emerald fs-6"></i>
                            <span class="fw-bold text-dark">{{ $activePatient['first_name'] }} {{ $activePatient['last_name'] }}</span>
                            <span class="badge bg-white text-dark border font-monospace" style="font-size:0.75rem;">TC: {{ $activePatient['national_id'] }}</span>
                            <span class="badge bg-emerald-soft text-emerald font-monospace" style="font-size:0.75rem;">{{ $activePatient['gender'] ?? 'Erkek' }}</span>
                        </div>
                    @else
                        <div class="d-inline-flex align-items-center gap-2 bg-slate-soft px-3 py-1.5 rounded-pill small text-muted border">
                            <i class="bi bi-person-exclamation fs-6 text-warning"></i>
                            <span class="fw-bold text-dark">Hasta Seçilmedi</span>
                        </div>
                    @endif
                </div>
            </div>
        </form>
    </div>

    @if(!empty($searchError))
        <div class="alert alert-warning border-start border-4 border-warning d-flex align-items-center gap-2 mb-3 py-2 shadow-sm rounded-3" role="alert">
            <i class="bi bi-exclamation-triangle-fill fs-5 text-warning"></i>
            <div class="small">
                <strong>Hasta Bulunamadı:</strong> {{ $searchError }}
            </div>
        </div>
    @endif

    <!-- BİLDİRİM VE UYARI MESAJLARI -->
    @if(session('success'))
        <div class="alert alert-success border-start border-4 border-success d-flex align-items-center gap-2 mb-3 py-2 shadow-sm rounded-3" role="alert">
            <i class="bi bi-check-circle-fill fs-5 text-success"></i>
            <div class="small fw-semibold">{{ session('success') }}</div>
        </div>
    @endif

    @if(session('safety_warnings'))
        <div class="alert alert-warning border-start border-4 border-warning mb-3 shadow-sm py-2 rounded-3" role="alert">
            <h6 class="fw-bold text-dark mb-1 small"><i class="bi bi-exclamation-triangle-fill text-warning me-1"></i> İlaç Güvenlik ve Alerji Uyarıları:</h6>
            <ul class="mb-0 small text-dark">
                @foreach(session('safety_warnings') as $w)
                    <li>
                        @if(is_array($w))
                            <strong>{{ $w['title'] ?? 'Uyarı' }}:</strong> {{ $w['description'] ?? '' }}
                        @else
                            {{ $w }}
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger border-start border-4 border-danger mb-3 shadow-sm py-2 rounded-3" role="alert">
            <h6 class="fw-bold text-danger mb-1 small"><i class="bi bi-exclamation-octagon-fill me-1"></i> Lütfen Aşağıdaki Alanları Kontrol Ediniz:</h6>
            <ul class="mb-0 small">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- 3. ANA E-REÇETE DÜZENLEME ALANI (TAM GENİŞLİK / SADE VE MERKEZİ TASARIM) -->
    <div class="row mb-4">
        <div class="col-12">
            @if(empty($activePatient))
                <div class="card-clean p-5 text-center text-muted shadow-sm rounded-3">
                    <i class="bi bi-person-bounding-box fs-1 text-success d-block mb-3 opacity-75"></i>
                    <h5 class="fw-bold text-dark mb-1">Henüz Reçete Yazılacak Hasta Seçilmedi</h5>
                    <p class="small text-muted mb-3" style="max-width: 540px; margin: 0 auto;">
                        E-Reçete yazmak, AI ilaç & alerji danışmanlığını başlatmak ve ilaç reçete etmek için lütfen yukarıdaki açılır listeden bir hasta seçiniz veya isim/TC Kimlik ile aratınız.
                    </p>
                    <div class="d-inline-block">
                        <button type="button" class="btn btn-gradient-success btn-sm rounded-pill px-4 fw-semibold" onclick="document.getElementById('patient_search_input').focus()">
                            <i class="bi bi-search me-1"></i> Hasta Ara / Seç
                        </button>
                    </div>
                </div>
            @else
                <!-- AI İLAÇ & DANIŞMANLIK BARI (TEŞHİSE ÖZEL DİNAMİK İLAÇ ÖNERİSİ) -->
                <div class="bg-emerald-soft p-3 rounded-3 mb-3 border shadow-sm" style="border-top: 3px solid #059669 !important;">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold text-emerald small d-flex align-items-center gap-1.5">
                            <i class="bi bi-robot text-emerald fs-6"></i> AI Klinik İlaç Danışmanı &bull; Teşhise Özel Reçete Protokolü (%98 Güven)
                        </span>
                        <span class="badge bg-white text-dark border font-monospace">Tanı: {{ $activeDiagnosisTitle }}</span>
                    </div>
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                        <p class="small text-dark mb-0">
                            Hastanın klinik teşhisi (<strong>{{ $activeDiagnosisTitle }}</strong>) ve öyküsüne özel AI ilaç seçenekleri:
                        </p>
                        <div class="d-flex flex-wrap gap-1.5">
                            @forelse($aiRecommendedDrugs as $drug)
                                <button type="button" class="btn btn-sm btn-white bg-white text-emerald border border-emerald-subtle rounded-pill py-1 px-3 shadow-sm font-monospace" style="font-size:0.78rem;" onclick="selectDrug('{{ $drug['name'] }}', '{{ $drug['frequency'] ?? '1x1' }}', 1, '{{ $drug['route'] ?? 'oral' }}')">
                                    <i class="bi bi-plus-circle-fill me-1 text-emerald"></i> {{ $drug['name'] }} ({{ $drug['purpose'] ?? 'Teşhis Tedavisi' }})
                                </button>
                            @empty
                                <button type="button" class="btn btn-sm btn-white bg-white text-emerald border border-emerald-subtle rounded-pill py-1 px-3 shadow-sm font-monospace" style="font-size:0.78rem;" onclick="selectDrug('Parol 500mg Tablet', '3x1', 1, 'oral')">
                                    <i class="bi bi-plus-circle-fill me-1 text-emerald"></i> Parol 500mg (Semptomatik Tedavi)
                                </button>
                            @endforelse
                        </div>
                    </div>
                    @if(!empty($activePatient['allergies']) && count($activePatient['allergies']) > 0)
                        <div class="text-danger small font-monospace mt-2" style="font-size:0.75rem;">
                            <i class="bi bi-shield-exclamation me-1"></i> Alerji Uyarısı: <strong>{{ implode(', ', $activePatient['allergies']) }}</strong> alerjisine dikkat ediniz.
                        </div>
                    @endif
                </div>

                <!-- E-REÇETE OLUŞTURMA FORMU (ÇOKLU İLAÇ DESTEKLİ) -->
                <div class="card-clean p-4 border shadow-sm rounded-3">
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                        <h6 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                            <i class="bi bi-pencil-square text-emerald fs-5"></i> Reçete Yaz ve SGK'ya Gönder
                        </h6>
                        <span class="badge bg-emerald-soft text-emerald border font-monospace px-3 py-1">E-Reçete Masası &bull; Çoklu İlaç Destekli</span>
                    </div>
                    
                    <form action="{{ route('prescription.store') }}" method="POST" id="prescriptionMultiForm">
                        @csrf
                        <input type="hidden" name="patient_id" value="{{ $activePatient['patient_id'] }}">

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-muted">Hasta Bilgisi</label>
                                <input type="text" class="form-control form-control-sm bg-slate-soft fw-bold text-dark" value="{{ $activePatient['first_name'] }} {{ $activePatient['last_name'] }} (TC: {{ $activePatient['national_id'] }})" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-muted">Tanı (ICD-10 Kodu)</label>
                                <input type="text" id="diagnosis_code" name="diagnosis_code" class="form-control form-control-sm fw-semibold" value="{{ $activeDiagnosisTitle ?? ($activePatient['recent_encounters'][0]['diagnosis'] ?? 'I10 - Essansiyel Hipertansiyon') }}" required>
                            </div>
                        </div>

                        {{-- DİNAMİK ÇOKLU İLAÇ LİSTESİ TABLOSU --}}
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label small fw-bold text-dark mb-0 d-flex align-items-center gap-1.5">
                                    <i class="bi bi-capsule-pill text-emerald"></i> Reçete Edilecek İlaç Kalemleri (<span id="drug_count_badge">1</span> İlaç)
                                </label>
                                <button type="button" class="btn btn-sm btn-outline-success font-monospace rounded-pill px-3 py-1 fw-bold" onclick="addDrugRow('', '1x1', 1, 'oral')">
                                    <i class="bi bi-plus-circle me-1"></i> + Reçeteye İlaç Ekle
                                </button>
                            </div>

                            <div class="table-responsive border rounded-3 bg-white shadow-sm">
                                <table class="table table-sm align-middle mb-0" id="multi_drug_table">
                                    <thead class="bg-slate-soft text-muted small">
                                        <tr>
                                            <th class="ps-3 py-2" style="width:40px;">#</th>
                                            <th class="py-2" style="min-width:240px;">İlaç Adı / Dozaj Tanımı</th>
                                            <th class="py-2" style="width:130px;">Dozaj</th>
                                            <th class="py-2" style="width:100px;">Kutu Sayısı</th>
                                            <th class="py-2" style="width:140px;">Kullanım Yolu</th>
                                            <th class="text-center py-2" style="width:50px;">Sil</th>
                                        </tr>
                                    </thead>
                                    <tbody id="multi_drug_tbody">
                                        <!-- Javascript ile Dinamik Satırlar Eklenecek -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted">Hekim Kullanım Açıklaması / Reçete Notu</label>
                            <textarea name="notes" class="form-control form-control-sm" rows="2" placeholder="Örn: Yemeklerden sonra tok karnına düzenli kullanılacaktır.">Hastanın klinik durumu doğrultusunda reçete düzenlendi.</textarea>
                        </div>

                        <button type="submit" class="btn btn-gradient-success w-100 py-2.5 fw-bold shadow-sm rounded-pill d-flex align-items-center justify-content-center gap-2 fs-6">
                            <i class="bi bi-shield-check fs-5"></i> Reçeteyi Kaydet & SGK E-Reçete Sistemine Gönder
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <!-- 4. SİSTEMDEKİ E-REÇETELER (ALTA TAŞINDI & AÇILIR/KAPANIR DÜZEN) -->
    <div class="card-clean mb-4 overflow-hidden border shadow-sm rounded-3">
        <div class="card-header bg-white p-3 d-flex justify-content-between align-items-center border-bottom-0" data-bs-toggle="collapse" data-bs-target="#collapsePrescriptionsHistory" aria-expanded="true" aria-controls="collapsePrescriptionsHistory" style="cursor: pointer;" onclick="toggleChevronIcon(this)">
            <div class="d-flex align-items-center gap-2.5">
                <div class="p-2 rounded-circle bg-emerald-soft text-emerald d-flex align-items-center justify-content-center" style="width:38px; height:38px;">
                    <i class="bi bi-journal-medical fs-5"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                        Sistemdeki E-Reçete Geçmişi
                    </h6>
                    <span class="text-muted small">SGK Medula entegrasyonu ile kaydedilen hastaya ait tüm e-reçeteler</span>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-emerald-soft text-emerald font-monospace px-3 py-1.5 rounded-pill" style="font-size:0.78rem;">
                    <i class="bi bi-check2-all me-1"></i> {{ count($prescriptions) }} Kayıtlı E-Reçete
                </span>
                <button type="button" class="btn btn-sm btn-light border rounded-circle py-1 px-2 text-muted">
                    <i id="accordionChevron" class="bi bi-chevron-up transition-icon"></i>
                </button>
            </div>
        </div>

        <div id="collapsePrescriptionsHistory" class="collapse show">
            <div class="card-body p-0 border-top">
                <div class="table-responsive dynamic-table-scroll" style="max-height: 450px;">
                    <table class="table table-hover align-middle small mb-0" data-dynamic-filter="true">
                        <thead class="bg-slate-soft sticky-table-header">
                            <tr>
                                <th class="ps-3 py-2.5">E-Reçete No</th>
                                <th class="py-2.5">Tanı (ICD-10)</th>
                                <th class="py-2.5">Reçete Edilen İlaçlar</th>
                                <th class="py-2.5">SGK Medula Durumu</th>
                                <th class="text-end pe-3 py-2.5">İşlem</th>
                            </tr>
                            <tr class="table-filter-row">
                                <th class="ps-3"><input type="text" class="form-control table-filter-input" data-col-index="0" placeholder="Reçete no ara..."></th>
                                <th><input type="text" class="form-control table-filter-input" data-col-index="1" placeholder="ICD tanı ara..."></th>
                                <th><input type="text" class="form-control table-filter-input" data-col-index="2" placeholder="İlaç adı ara..."></th>
                                <th>
                                    <select class="form-select table-filter-select" data-col-index="3">
                                        <option value="">Tüm Durumlar</option>
                                        <option value="sgk onaylı">SGK Onaylı</option>
                                        <option value="taslak">Taslak / Bekliyor</option>
                                    </select>
                                </th>
                                <th class="text-end pe-3"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($prescriptions as $p)
                            <tr>
                                <td class="ps-3 fw-bold text-dark">
                                    <div class="d-flex align-items-center gap-1.5">
                                        <i class="bi bi-file-earmark-code text-primary"></i>
                                        <span>{{ $p->prescription_code }}</span>
                                    </div>
                                    @if($p->status === 'sent_to_sgk' || $p->status === 'signed')
                                        <div class="small text-success font-monospace" style="font-size:0.73rem;">E-Reçete No: {{ $p->erecepta_no ?? $p->prescription_code }}</div>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-indigo-soft font-monospace">{{ $p->diagnosis_code }}</span>
                                </td>
                                <td>
                                    <div class="text-dark fw-semibold">
                                        @foreach($p->items as $item)
                                            <div class="d-flex align-items-center gap-1">
                                                <i class="bi bi-capsule text-emerald small"></i>
                                                <span>{{ $item->drug_name }}</span>
                                                <span class="text-muted font-monospace small">({{ $item->dosage }}, {{ $item->box_count }} Kutu)</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td>
                                    @if($p->status === 'signed' || $p->status === 'sent_to_sgk')
                                        <span class="badge bg-emerald-soft text-emerald border border-emerald-subtle rounded-pill px-2.5 py-1"><i class="bi bi-check-circle-fill me-1"></i> SGK Onaylı</span>
                                    @else
                                        <span class="badge bg-amber-soft border rounded-pill px-2.5 py-1"><i class="bi bi-clock-history me-1"></i> Taslak / Bekliyor</span>
                                    @endif
                                </td>
                                <td class="text-end pe-3">
                                    @if($p->status !== 'signed' && $p->status !== 'sent_to_sgk')
                                        <form action="{{ route('prescription.send_erecepta', $p->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-gradient-success btn-sm py-1 px-3 rounded-pill fw-semibold shadow-sm" style="font-size:0.75rem;">
                                                <i class="bi bi-send me-1"></i> SGK'ya Gönder
                                            </button>
                                        </form>
                                    @else
                                        <span class="badge bg-light text-success border px-2.5 py-1 rounded-pill"><i class="bi bi-cloud-check-fill me-1"></i> Medula'ya İletildi</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-3 d-block text-muted opacity-50 mb-1"></i>
                                    Henüz bu hasta için kaydedilmiş e-reçete bulunmuyor.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    let searchDebounceTimer = null;

    function handlePatientSearchInput(query) {
        clearTimeout(searchDebounceTimer);
        const dropdown = document.getElementById('patient_search_dropdown');
        const resultsList = document.getElementById('search_results_list');
        const matchCountBadge = document.getElementById('search_match_count');

        if (!query || query.trim().length < 1) {
            if (dropdown) dropdown.style.display = 'none';
            return;
        }

        searchDebounceTimer = setTimeout(() => {
            fetch("{{ route('prescription.search_patients_ajax') }}?q=" + encodeURIComponent(query.trim()))
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success' && data.patients && data.patients.length > 0) {
                        let html = '';
                        data.patients.forEach(p => {
                            html += `
                                <a href="{{ route('prescription.index') }}?patient_id=${p.patient_id}" class="list-group-item list-group-item-action p-2.5 border-0 border-bottom d-flex justify-content-between align-items-center hover-bg-light">
                                    <div>
                                        <div class="fw-bold text-dark d-flex align-items-center gap-2">
                                            <i class="bi bi-person-circle text-emerald fs-6"></i> ${p.first_name} ${p.last_name}
                                            <span class="badge bg-emerald-soft text-emerald border font-monospace">TC: ${p.national_id}</span>
                                        </div>
                                        <div class="text-muted small mt-1" style="font-size:0.75rem;">
                                            <i class="bi bi-calendar-event me-1"></i> Doğum: <strong>${p.birth_date}</strong> | Cinsiyet: <strong>${p.gender}</strong> | Kan: <strong>${p.blood_type}</strong>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-light text-dark border mb-1 d-block"><i class="bi bi-building me-1"></i> ${p.clinic}</span>
                                        <span class="btn btn-gradient-success btn-sm py-0 px-2 fw-semibold" style="font-size:0.72rem;">Seç & Reçete Yaz &rarr;</span>
                                    </div>
                                </a>
                            `;
                        });
                        resultsList.innerHTML = html;
                        matchCountBadge.innerText = data.patients.length;
                        dropdown.style.display = 'block';
                    } else {
                        resultsList.innerHTML = `<div class="p-3 text-center text-muted small"><i class="bi bi-exclamation-circle me-1"></i> "${query}" kriterine uygun hasta bulunamadı.</div>`;
                        matchCountBadge.innerText = '0';
                        dropdown.style.display = 'block';
                    }
                })
                .catch(err => {
                    console.error("Search AJAX error:", err);
                });
        }, 150);
    }

    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('patient_search_dropdown');
        const input = document.getElementById('patient_search_input');
        if (dropdown && input && !dropdown.contains(e.target) && !input.contains(e.target)) {
            dropdown.style.display = 'none';
        }
    });

    let drugRowIndex = 0;

    document.addEventListener('DOMContentLoaded', function() {
        const tbody = document.getElementById('multi_drug_tbody');
        if (tbody && tbody.children.length === 0) {
            @if(!empty($aiRecommendedDrugs[0]))
                addDrugRow(@json($aiRecommendedDrugs[0]['name']), @json($aiRecommendedDrugs[0]['frequency'] ?? '1x1'), 1, @json($aiRecommendedDrugs[0]['route'] ?? 'oral'));
            @else
                addDrugRow('Parol 500mg Tablet', '3x1', 1, 'oral');
            @endif
        }
    });

    function addDrugRow(name = '', dosage = '1x1', box = 1, route = 'oral') {
        const tbody = document.getElementById('multi_drug_tbody');
        if (!tbody) return;

        drugRowIndex++;
        const tr = document.createElement('tr');
        tr.id = 'drug_row_' + drugRowIndex;

        tr.innerHTML = `
            <td class="ps-3 fw-bold text-muted small row-num">${tbody.children.length + 1}</td>
            <td>
                <input type="text" name="items[${drugRowIndex}][drug_name]" class="form-control form-control-sm fw-bold border-emerald-subtle" placeholder="Örn: Candesartan 16mg Tablet" value="${name}" required>
            </td>
            <td>
                <input type="text" name="items[${drugRowIndex}][dosage]" class="form-control form-control-sm fw-semibold" value="${dosage}" required>
            </td>
            <td>
                <input type="number" name="items[${drugRowIndex}][box_count]" class="form-control form-control-sm fw-semibold" value="${box}" min="1" required>
            </td>
            <td>
                <select name="items[${drugRowIndex}][usage_route]" class="form-select form-select-sm fw-semibold">
                    <option value="oral" ${route === 'oral' ? 'selected' : ''}>Oral (Ağızdan)</option>
                    <option value="iv" ${route === 'iv' ? 'selected' : ''}>İntravenöz (İV)</option>
                    <option value="inhaler" ${route === 'inhaler' ? 'selected' : ''}>İnhaler / Solunum</option>
                    <option value="topikal" ${route === 'topikal' ? 'selected' : ''}>Topikal (Ciltten)</option>
                </select>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-outline-danger border-0 rounded-circle px-2 py-1" onclick="removeDrugRow(${drugRowIndex})" title="Bu İlacı Reçeteden Çıkar">
                    <i class="bi bi-trash-fill"></i>
                </button>
            </td>
        `;

        tbody.appendChild(tr);
        updateRowIndices();
    }

    function removeDrugRow(index) {
        const tbody = document.getElementById('multi_drug_tbody');
        const tr = document.getElementById('drug_row_' + index);
        if (tr && tbody.children.length > 1) {
            tr.remove();
            updateRowIndices();
        } else {
            Swal.fire({
                icon: 'info',
                title: 'Bilgi',
                text: 'Reçetede en az 1 adet ilaç kalemi bulunmalıdır.',
                timer: 1500,
                showConfirmButton: false
            });
        }
    }

    function updateRowIndices() {
        const tbody = document.getElementById('multi_drug_tbody');
        if (!tbody) return;
        const rows = tbody.querySelectorAll('tr');
        rows.forEach((row, idx) => {
            const numTd = row.querySelector('.row-num');
            if (numTd) numTd.innerText = idx + 1;
        });
        const badge = document.getElementById('drug_count_badge');
        if (badge) badge.innerText = rows.length;
    }

    function selectDrug(name, dosage, box, route) {
        const tbody = document.getElementById('multi_drug_tbody');
        if (tbody && tbody.children.length === 1) {
            const firstInput = tbody.querySelector('input[name*="[drug_name]"]');
            if (firstInput && firstInput.value.trim() === '') {
                firstInput.value = name;
                const dosageInput = tbody.querySelector('input[name*="[dosage]"]');
                if (dosageInput) dosageInput.value = dosage;
                const boxInput = tbody.querySelector('input[name*="[box_count]"]');
                if (boxInput) boxInput.value = box;
                const routeSelect = tbody.querySelector('select[name*="[usage_route]"]');
                if (routeSelect) routeSelect.value = route;
                
                Swal.fire({
                    icon: 'success',
                    title: 'İlaç Reçeteye Eklendi',
                    text: name + ' reçete listesine aktarıldı.',
                    timer: 1200,
                    showConfirmButton: false
                });
                return;
            }
        }

        addDrugRow(name, dosage, box, route);

        Swal.fire({
            icon: 'success',
            title: 'İlaç Eklendi',
            text: name + ' reçeteye ilave kalem olarak eklendi.',
            timer: 1200,
            showConfirmButton: false
        });
    }

    function toggleChevronIcon(element) {
        const icon = element.querySelector('#accordionChevron');
        if (icon) {
            if (icon.classList.contains('bi-chevron-up')) {
                icon.classList.remove('bi-chevron-up');
                icon.classList.add('bi-chevron-down');
            } else {
                icon.classList.remove('bi-chevron-down');
                icon.classList.add('bi-chevron-up');
            }
        }
    }
</script>
@endpush
