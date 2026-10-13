@extends('layouts.app')

@section('title', 'Doktor Paneli & AI Klinik Karar Destek Masası')

@push('styles')
<style>
    body { background-color: #f8fafc; color: #0f172a; }
    
    .card-clean {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.03), 0 1px 2px rgba(15, 23, 42, 0.02);
    }
    
    .card-clean-header {
        background: #ffffff;
        border-bottom: 1px solid #f1f5f9;
        padding: 0.9rem 1.2rem;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }

    /* Soft Renk Rozetleri & Metin Tonları */
    .bg-indigo-soft { background-color: #eef2ff; color: #4338ca; border: 1px solid #c7d2fe; }
    .bg-emerald-soft { background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
    .bg-amber-soft { background-color: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
    .bg-rose-soft { background-color: #fff1f2; color: #be123c; border: 1px solid #fecdd3; }
    .bg-sky-soft { background-color: #f0f9ff; color: #0369a1; border: 1px solid #bae6fd; }
    .bg-slate-soft { background-color: #f8fafc; color: #334155; border: 1px solid #e2e8f0; }

    /* Minimalist Pills Navigasyonu */
    .nav-pills-custom .nav-link {
        color: #64748b;
        font-weight: 600;
        font-size: 0.84rem;
        padding: 0.45rem 0.9rem;
        border-radius: 8px;
        transition: all 0.15s ease;
    }
    .nav-pills-custom .nav-link.active {
        background-color: #2563eb;
        color: #ffffff;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.2);
    }
    .nav-pills-custom .nav-link:hover:not(.active) {
        background-color: #f1f5f9;
        color: #0f172a;
    }

    /* AI Olası Tanı Önerileri Kaydırma Alanı (Scrollable Container) */
    #aiDiagnosesList {
        max-height: 220px;
        overflow-y: auto;
        padding-right: 4px;
        scroll-behavior: smooth;
    }
    #aiDiagnosesList::-webkit-scrollbar {
        width: 5px;
    }
    #aiDiagnosesList::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 4px;
    }
    #aiDiagnosesList::-webkit-scrollbar-thumb {
        background: #10b981;
        border-radius: 4px;
    }
    #aiDiagnosesList::-webkit-scrollbar-thumb:hover {
        background: #059669;
    }

    .nav-tabs-subtle .nav-link {
        color: #64748b;
        font-weight: 600;
        font-size: 0.82rem;
        border: none;
        border-bottom: 2px solid transparent;
        padding: 0.45rem 0.75rem;
    }
    .nav-tabs-subtle .nav-link.active {
        color: #2563eb;
        background: transparent;
        border-bottom: 2px solid #2563eb;
    }

    .pipeline-step {
        font-size: 0.73rem;
        padding: 0.25rem 0.6rem;
        border-radius: 6px;
        font-weight: 600;
    }

    /* Devlet Standartında Resmi Belge Önizleme Kartı */
    .official-report-card {
        border: 2px solid #334155;
        background: #ffffff;
        padding: 1.5rem;
        font-family: 'Times New Roman', Times, serif;
    }

    .stat-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.35rem 0.85rem;
        border-radius: 9999px;
        font-size: 0.82rem;
        font-weight: 600;
    }
</style>
@endpush

@section('content')

    <!-- 1. ŞIK VE KOMPAKT ÜST HEADER (KARTSIZ - METRİKLERLE ENTEGRE) -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 pb-2 border-bottom">
        <div>
            <h4 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                <i class="bi bi-person-workspace text-primary"></i> Doktor Paneli & Klinik Çalışma Masası
            </h4>
            <p class="text-muted mb-0 small">Entegre Hasta Tıbbi Dosyası, AI Teşhis Asistanı & e-Rapor Yönetim Portalı</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="stat-pill bg-amber-soft">
                <i class="bi bi-hourglass-split"></i> Onay Bekleyen: <strong>{{ $pendingCount }}</strong>
            </span>
            <span class="stat-pill bg-emerald-soft">
                <i class="bi bi-check-circle"></i> SGK e-Rapor: <strong>{{ $approvedCount }}</strong>
            </span>
            <span class="stat-pill bg-indigo-soft">
                <i class="bi bi-file-earmark-text"></i> Toplam Rapor: <strong>{{ $totalCount }}</strong>
            </span>
        </div>
    </div>

    <!-- 2. CANLI HASTA ARAMA VE SEÇİM BARI (ŞIK, TEK SATIR DÜZEN) -->
    <div class="card-clean p-2.5 mb-3 bg-white border shadow-sm rounded-3">
        <form action="{{ route('medical_report.chief_physician') }}" method="GET" id="patientSearchForm">
            <div class="row g-2 align-items-center">
                <div class="col-md-7 position-relative">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light text-primary border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" id="patient_search_input" name="search_query" class="form-control form-control-sm border-start-0 border-end-0 fw-semibold" placeholder="Hasta adı, TC Kimlik No veya protokol yazın..." value="{{ $searchQuery ?? '' }}" autocomplete="off" oninput="handlePatientSearchInput(this.value)" onfocus="handlePatientSearchInput(this.value)">
                        <select name="patient_id" class="form-select form-select-sm fw-semibold border-start-0" style="max-width:240px;" onchange="this.form.submit()">
                            <option value="" {{ empty($activePatient) ? 'selected' : '' }}>-- Lütfen Hasta Seçiniz --</option>
                            @foreach($patients as $id => $p)
                                <option value="{{ $id }}" {{ (!empty($activePatient) && ($activePatient['patient_id'] ?? 0) == $id) ? 'selected' : '' }}>
                                    {{ $p['first_name'] }} {{ $p['last_name'] }} (TC: {{ $p['national_id'] }})
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary btn-sm fw-semibold px-3">
                            <i class="bi bi-arrow-right-circle me-1"></i> Getir
                        </button>
                    </div>

                    <!-- CANLI AUTOCOMPLETE DÜŞÜM MENÜSÜ -->
                    <div id="patient_search_dropdown" class="dropdown-menu shadow-lg w-100 p-0 border-0 mt-1" style="display:none; max-height:380px; overflow-y:auto; z-index:1050; position:absolute; top:100%; left:0;">
                        <div class="p-2 bg-slate-soft text-muted small fw-bold border-bottom d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-person-lines-fill me-1 text-primary"></i> Eşleşen Hasta Kayıtları:</span>
                            <span class="badge bg-primary" id="search_match_count">0</span>
                        </div>
                        <div class="list-group list-group-flush small" id="search_results_list">
                            <!-- Dynamic items injected via JS -->
                        </div>
                    </div>
                </div>
                <div class="col-md-5 text-end">
                    @if(!empty($activePatient))
                        <div class="d-inline-flex align-items-center gap-2 bg-primary-subtle border border-primary-subtle px-3 py-1 rounded-pill small">
                            <i class="bi bi-person-check-fill text-primary"></i>
                            <span class="fw-bold text-primary">{{ $activePatient['first_name'] }} {{ $activePatient['last_name'] }}</span>
                            <span class="text-muted font-monospace" style="font-size:0.75rem;">TC: {{ $activePatient['national_id'] }}</span>
                            <span class="badge bg-white text-dark border ms-1">{{ $activePatient['gender'] }}</span>
                        </div>
                    @else
                        <div class="d-inline-flex align-items-center gap-2 bg-slate-soft border px-3 py-1 rounded-pill small text-muted">
                            <i class="bi bi-person-dash text-secondary"></i>
                            <span class="fw-semibold">Hasta Seçilmedi</span>
                        </div>
                    @endif
                </div>
            </div>
        </form>
    </div>

    @if(!empty($searchError))
        <div class="alert alert-warning border-start border-4 border-warning d-flex align-items-center gap-2 mb-3 py-2 shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill fs-5 text-warning"></i>
            <div class="small">
                <strong>Hasta Bulunamadı:</strong> {{ $searchError }}
            </div>
        </div>
    @endif

    <!-- 3. ANA ÇALIŞMA ALANI -->
    <div class="row g-3">

        <!-- 1. ÜST ALAN: TEŞHİS, AI KARAR DESTEK & DOKTOR ÇALIŞMA MASASI -->
        <div class="col-12 mb-3">
            <div class="card-clean h-100 border-0 shadow-sm rounded-3">
                <div class="card-clean-header pb-0 border-bottom-0 py-2 px-3 bg-white rounded-top-3 border-bottom">
                    <ul class="nav nav-pills nav-pills-custom gap-1" id="doctorWorkTabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active fw-bold px-3" id="tab-ai-assistant-tab" data-bs-toggle="tab" data-bs-target="#tab-ai-assistant" type="button">
                                <i class="bi bi-cpu-fill text-primary me-1.5"></i> Klinik Teşhis & AI Masası
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link fw-semibold px-3 text-secondary" id="tab-create-report-tab" data-bs-toggle="tab" data-bs-target="#tab-create-report" type="button">
                                <i class="bi bi-pencil-square text-success me-1.5"></i> Yeni Rapor Düzenle
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link fw-semibold px-3 text-secondary" id="tab-approval-desk-tab" data-bs-toggle="tab" data-bs-target="#tab-approval-desk" type="button">
                                <i class="bi bi-card-checklist text-warning me-1.5"></i> Onay Masası ({{ count($reports) }})
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="p-3">
                    <div class="tab-content" id="doctorWorkTabsContent">

                        <!-- Sekme 1: TEŞHİS & KLİNİK ÇALIŞMA MASASI (SİMETRİK KARTLAR) -->
                        <div class="tab-pane fade show active" id="tab-ai-assistant" role="tabpanel">
                            
                            <!-- BİLGİLENDİRME & AKSİYON BARI (ŞIK SLATE/PRIMARY TINT) -->
                            <div class="d-flex justify-content-between align-items-center mb-3 p-2.5 rounded-3 border bg-slate-50">
                                <div class="small text-dark d-flex align-items-center gap-2">
                                    <span class="badge bg-primary-subtle text-primary p-2 rounded-circle"><i class="bi bi-stethoscope fs-6"></i></span>
                                    <div>
                                        <div class="fw-bold text-dark" style="font-size:0.85rem;">Doktor Teşhis, Tanı & Reçete Formu</div>
                                        <div class="text-muted" style="font-size:0.75rem;">Metin alanlarına manuel yazabilir veya AI desteğinden faydalanabilirsiniz.</div>
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-primary btn-sm fw-bold px-3 shadow-sm rounded-pill d-flex align-items-center gap-1.5" style="background: linear-gradient(135deg, #2563eb 0%, #4f46e5 100%); border:none;" onclick="fetchPatientAiSupport()">
                                        <i class="bi bi-magic"></i> AI İle Doldur / Öneri Al
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm fw-semibold px-3 rounded-pill" onclick="clearDiagnosisForm()">
                                        <i class="bi bi-eraser me-1"></i> Temizle
                                    </button>
                                </div>
                            </div>

                            <!-- 3 EŞİT / SİMETRİK FORM KARTI -->
                            <div class="row g-3 mb-3 align-items-stretch">
                                <!-- 1. HASTA ŞİKAYETİ KARTI -->
                                <div class="col-md-4">
                                    <div class="card h-100 border rounded-3 p-3 bg-white shadow-none position-relative" style="border-top: 3px solid #2563eb !important;">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="fw-bold text-dark small d-flex align-items-center gap-1.5">
                                                <i class="bi bi-chat-left-text-fill text-primary"></i> 1. Hasta Şikayeti & Anamnez
                                            </span>
                                            <span class="badge bg-primary-subtle text-primary font-monospace" style="font-size:0.68rem;">Giriş Metni</span>
                                        </div>
                                        <textarea id="patient_complaint" class="form-control form-control-sm bg-slate-50 border-1 flex-grow-1" rows="5" style="resize:none; font-size:0.83rem;" placeholder="Hasta şikayetini ve anamnez bilgisini buraya yazınız...">{{ !empty($activePatient) ? ($activePatient['recent_encounters'][0]['complaint'] ?? '') : '' }}</textarea>
                                    </div>
                                </div>

                                <!-- 2. DOKTOR TEŞHİSİ KARTI -->
                                <div class="col-md-4">
                                    <div class="card h-100 border rounded-3 p-3 bg-white shadow-none position-relative" style="border-top: 3px solid #059669 !important;">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="fw-bold text-dark small d-flex align-items-center gap-1.5">
                                                <i class="bi bi-journal-medical text-success"></i> 2. Doktor Teşhisi (ICD-10)
                                            </span>
                                            <span class="badge bg-success-subtle text-success font-monospace" style="font-size:0.68rem;">Tanı Kodu</span>
                                        </div>
                                        <div class="position-relative mb-1">
                                            <input type="text" id="ai_diagnosis_input" class="form-control form-control-sm fw-bold text-success bg-slate-50 border-1" style="font-size:0.85rem;" placeholder="Kod veya tanı adı yazarak arayın (Örn: I10)..." value="" autocomplete="off">
                                            <div id="ai_diagnosis_autocomplete_list" class="dropdown-menu shadow-lg border rounded-3 w-100 p-0 overflow-hidden mt-1" style="display:none; max-height:280px; overflow-y:auto; position:absolute; z-index:1060; top:100%; left:0;"></div>
                                        </div>
                                        
                                        <button type="button" class="btn btn-outline-success btn-sm w-100 mb-2 py-1 px-2 fw-bold d-flex align-items-center justify-content-center gap-1.5 shadow-xs" style="font-size:0.76rem;" data-bs-toggle="modal" data-bs-target="#icd10BrowserModal" onclick="loadAllIcd10Codes()">
                                            <i class="bi bi-card-checklist fs-6"></i> Tüm ICD-10 Kodlarını Listele / Kendim Seç
                                        </button>
                                        
                                        <div class="mt-auto">
                                            <div class="small text-muted mb-1.5 fw-semibold d-flex justify-content-between align-items-center" style="font-size:0.73rem;">
                                                <span><i class="bi bi-stars text-success me-1"></i> AI Olası Tanı Önerileri:</span>
                                                <span class="text-muted" style="font-size:0.68rem;">Tıklayınca aktarılır</span>
                                            </div>
                                            <div id="aiDiagnosesList" class="d-flex flex-wrap gap-1" style="max-height: 220px; overflow-y: auto; padding-right: 4px;">
                                                <span class="text-muted small"><i class="bi bi-info-circle me-1 text-primary"></i> Doktor "AI İle Doldur / Öneri Al" butonuna tıkladığında şikayete uygun tanı önerileri listelenir.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- 3. REÇETE & TEDAVİ PLANI KARTI -->
                                <div class="col-md-4">
                                    <div class="card h-100 border rounded-3 p-3 bg-white shadow-none position-relative" style="border-top: 3px solid #d97706 !important;">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="fw-bold text-dark small d-flex align-items-center gap-1.5">
                                                <i class="bi bi-capsule-pill text-warning"></i> 3. Reçete & Tedavi Planı
                                            </span>
                                            <span class="badge bg-warning-subtle text-warning font-monospace" style="font-size:0.68rem;">Tedavi Notu</span>
                                        </div>
                                        <textarea id="ai_treatment_input" class="form-control form-control-sm bg-slate-50 border-1 flex-grow-1" rows="5" style="resize:none; font-size:0.83rem;" placeholder="Reçete edilecek ilaçları ve kullanım talimatını yazınız..."></textarea>
                                    </div>
                                </div>

                            </div>

                            <!-- HEKİM AKSİYON & GÜVENLİK BARI -->
                            <div class="d-flex align-items-center justify-content-between p-2.5 bg-white rounded-3 border shadow-sm">
                                <div class="small text-muted d-flex align-items-center gap-2">
                                    <i class="bi bi-shield-check text-success fs-6"></i>
                                    @if(!empty($activePatient))
                                        <span id="aiDisclaimerText">Hastaya ait alerji (<strong>{{ implode(', ', $activePatient['allergies']) }}</strong>) ve kronik tanı kontrolü otomatik yapılır.</span>
                                    @else
                                        <span id="aiDisclaimerText">Hasta seçildiğinde alerji ve kronik tanı kontrolü otomatik yapılır.</span>
                                    @endif
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-success btn-sm py-1.5 px-4 fw-bold shadow-sm rounded-pill d-flex align-items-center gap-1.5" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%); border:none;" onclick="submitDoctorFeedback('kabul')">
                                        <i class="bi bi-check-circle-fill"></i> Teşhis & Reçeteyi Kaydet
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Sekme 2: YENİ RAPOR DÜZENLE & AI TASLAK -->
                        <div class="tab-pane fade" id="tab-create-report" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-file-earmark-plus me-1 text-primary"></i> Yeni Tıbbi Rapor Düzenle</h6>
                                <button type="button" class="btn btn-outline-primary btn-sm fw-semibold" onclick="autoFillAiDraft()">
                                    <i class="bi bi-magic me-1"></i> AI İle Otomatik Doldur
                                </button>
                            </div>

                            <div class="bg-slate-50 p-2 rounded mb-3 border d-flex justify-content-between align-items-center text-center">
                                <span class="pipeline-step bg-slate-soft">1. Taslak</span> &rarr;
                                <span class="pipeline-step bg-sky-soft">2. Hekim Kontrolü</span> &rarr;
                                <span class="pipeline-step bg-indigo-soft">3. İmza</span> &rarr;
                                <span class="pipeline-step bg-amber-soft">4. Doktor Onayı</span> &rarr;
                                <span class="pipeline-step bg-emerald-soft">5. e-Rapor Kodu</span>
                            </div>

                            <form action="{{ route('medical_report.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="patient_id" value="{{ $activePatient['patient_id'] ?? '' }}">

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Rapor Türü (SGK & Kurul)</label>
                                        <select id="report_type" name="report_type" class="form-select form-select-sm" required>
                                            <option value="Ayaktan İstirahat Raporu">Ayaktan İstirahat Raporu</option>
                                            <option value="SGK İlaç Kullanım Raporu">SGK İlaç Kullanım Raporu</option>
                                            <option value="Durum Bildirir Sağlık Kurulu Raporu">Durum Bildirir Sağlık Kurulu Raporu</option>
                                            <option value="Geçici İş Göremezlik Raporu">Geçici İş Göremezlik Raporu</option>
                                            <option value="İş Kazası & Meslek Hastalığı Raporu">İş Kazası & Meslek Hastalığı Raporu</option>
                                            <option value="Analık Raporu">Analık Raporu</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">İstirahat Süresi (Gün)</label>
                                        <input type="number" id="rest_days" name="rest_days" class="form-control form-control-sm" value="5" min="1" max="30" required>
                                    </div>
                                </div>

                                <div class="mb-3 position-relative">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <label class="form-label small fw-semibold mb-0"><i class="bi bi-search text-success me-1"></i>Tanı (ICD-10 Kodu Arama)</label>
                                        <button type="button" class="btn btn-link btn-sm p-0 text-success fw-bold text-decoration-none" style="font-size:0.75rem;" data-bs-toggle="modal" data-bs-target="#icd10BrowserModal" onclick="loadAllIcd10Codes()">
                                            <i class="bi bi-list-stars me-1"></i> Tüm ICD-10 Kodlarını İncele & Seç
                                        </button>
                                    </div>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                                        <input type="text" id="diagnosis" name="diagnosis" class="form-control form-control-sm border-start-0 ps-0 fw-semibold" value="" placeholder="Kod veya hastalık adı yazarak canlı arayın (Örn: J90 veya Plevra)..." autocomplete="off" required>

                                    </div>
                                    <div id="diagnosis_autocomplete_list" class="dropdown-menu shadow-lg border rounded-3 w-100 p-0 overflow-hidden mt-1" style="display:none; max-height:300px; overflow-y:auto; position:absolute; z-index:1060; top:100%; left:0;"></div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Rapor Klinik İçeriği & Hekim Açıklaması</label>
                                    <textarea id="report_content" name="report_content" class="form-control form-control-sm" rows="3" placeholder="Rapor açıklamasını giriniz..." required>{{ !empty($activePatient) ? 'Hastanın klinik muayenesi sonucunda ayaktan istirahat ve ilaç tedavisi takibi uygun görülmüştür.' : '' }}</textarea>
                                </div>

                                <button type="submit" class="btn btn-primary btn-sm w-100 fw-semibold shadow-sm">
                                    <i class="bi bi-file-earmark-check me-1"></i> Raporu Oluştur & Doktor Onay Listesine Kaydet
                                </button>
                            </form>
                        </div>

                        <!-- Sekme 3: DOKTOR RAPOR ONAY MASASI -->
                        <div class="tab-pane fade" id="tab-approval-desk" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-card-checklist me-1 text-primary"></i> Doktor Rapor Onay & e-Rapor Masası</h6>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-primary-subtle text-primary border font-monospace"><i class="bi bi-file-earmark-text me-1"></i> {{ count($reports) }} Kayıtlı Rapor</span>
                                    <span class="badge bg-slate-soft"><i class="bi bi-robot text-primary me-1"></i> AI Karar Destek Aktif</span>
                                </div>
                            </div>

                            <div class="table-responsive border rounded-3 shadow-sm" style="max-height: 360px; overflow-y: auto;">
                                <table class="table table-hover align-middle small mb-0">
                                    <thead class="table-light position-sticky top-0 shadow-sm" style="z-index: 10;">
                                        <tr>
                                            <th>Rapor No</th>
                                            <th>Tür / Tanı</th>
                                            <th>Onay Durumu</th>
                                            <th>İşlem</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($reports as $r)
                                        <tr>
                                            <td class="fw-bold text-dark">{{ $r->report_number }}</td>
                                            <td>
                                                <div class="fw-semibold">{{ $r->report_type }}</div>
                                                <small class="text-muted">{{ $r->diagnosis }} ({{ $r->rest_days }} Gün)</small>
                                            </td>
                                            <td>
                                                @if($r->chief_physician_approval_status === 'approved')
                                                    <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Doktor Onaylı</span>
                                                    <div class="small text-success font-monospace fw-bold" style="font-size:0.7rem;">{{ $r->e_rapor_no }}</div>
                                                @elseif($r->chief_physician_approval_status === 'rejected')
                                                    <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i> Reddedildi</span>
                                                @else
                                                    <span class="badge bg-warning text-dark"><i class="bi bi-clock me-1"></i> Onay Bekliyor</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($r->chief_physician_approval_status === 'approved')
                                                    <button type="button" class="btn btn-outline-success btn-sm p-1 px-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#reportModal{{ $r->id }}">
                                                        <i class="bi bi-file-earmark-check me-1"></i> Raporu İncele / İçeriği Gör
                                                    </button>
                                                @elseif($r->chief_physician_approval_status === 'rejected')
                                                    <button type="button" class="btn btn-outline-secondary btn-sm p-1 px-2" data-bs-toggle="modal" data-bs-target="#reportModal{{ $r->id }}">
                                                        <i class="bi bi-file-earmark-x me-1"></i> Raporu Gör
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-outline-primary btn-sm p-1 px-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#reportModal{{ $r->id }}">
                                                        <i class="bi bi-file-earmark-text me-1"></i> İncele & Onayla
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-3">Henüz onay bekleyen veya kayıtlı doktor raporu bulunmuyor.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- 2. ALT ALAN: HASTA TIBBİ DOSYASI, LAB (LIS) & TETKİKLER -->
        <div class="col-12 mb-3">
            <div class="card-clean h-100">
                <div class="card-clean-header d-flex justify-content-between align-items-center py-2 px-3">
                    <h6 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-folder2-open text-primary me-1.5"></i>
                        Hasta Tıbbi Dosyası
                    </h6>
                    <span class="badge bg-slate-soft">{{ !empty($activePatient) ? ($activePatient['first_name'] . ' ' . $activePatient['last_name']) : 'Hasta Seçilmedi' }}</span>
                </div>

                <div class="p-3">
                    @if(empty($activePatient))
                        <div class="p-4 text-center text-muted">
                            <i class="bi bi-person-bounding-box fs-1 d-block mb-2 text-primary opacity-50"></i>
                            <strong class="text-dark">Henüz hasta seçilmedi.</strong>
                            <p class="small mb-0">Hastanın vital bulgularını, laboratuvar sonuçlarını, reçetelerini ve e-raporlarını görüntülemek için lütfen yukarıdaki arama/seçim alanından bir hasta seçiniz.</p>
                        </div>
                    @else
                        <!-- Sekme Navigasyonu -->
                        <ul class="nav nav-tabs nav-tabs-subtle mb-3" id="patientTabs" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active" id="tab-vitals-tab" data-bs-toggle="tab" data-bs-target="#tab-vitals" type="button">
                                    <i class="bi bi-heart-pulse me-1 text-danger"></i> Özeti & Vitals
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="tab-labs-tab" data-bs-toggle="tab" data-bs-target="#tab-labs" type="button">
                                    <i class="bi bi-card-checklist me-1 text-success"></i> Lab (LIS)
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="tab-rad-tab" data-bs-toggle="tab" data-bs-target="#tab-rad" type="button">
                                    <i class="bi bi-x-diamond-fill me-1 text-primary"></i> Röntgen
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="tab-encounters-tab" data-bs-toggle="tab" data-bs-target="#tab-encounters" type="button">
                                    <i class="bi bi-journal-medical me-1 text-primary"></i> Teşhisler
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="tab-meds-tab" data-bs-toggle="tab" data-bs-target="#tab-meds" type="button">
                                    <i class="bi bi-capsule me-1 text-warning"></i> İlaçlar
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="tab-pastrep-tab" data-bs-toggle="tab" data-bs-target="#tab-pastrep" type="button">
                                    <i class="bi bi-file-earmark-text me-1 text-info"></i> Raporlar
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content small" id="patientTabsContent">
                            <!-- Sekme 1: Özeti & Vitals -->
                            <div class="tab-pane fade show active" id="tab-vitals" role="tabpanel">
                                <div class="bg-slate-50 p-2.5 rounded-3 mb-3 border">
                                    <div class="row g-2 text-center">
                                        <div class="col-6 col-md-3">
                                            <div class="text-muted small">Tansiyon</div>
                                            <div class="fw-bold text-danger">{{ $activePatient['vitals']['blood_pressure'] ?? '-' }}</div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="text-muted small">Nabız</div>
                                            <div class="fw-bold text-primary">{{ $activePatient['vitals']['pulse'] ?? '-' }}</div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="text-muted small">Ateş</div>
                                            <div class="fw-bold text-warning">{{ $activePatient['vitals']['temperature'] ?? '-' }}</div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="text-muted small">SpO2</div>
                                            <div class="fw-bold text-success">{{ $activePatient['vitals']['oxygen_saturation'] ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-2 p-2 rounded border bg-white">
                                    <strong class="text-dark d-block mb-1"><i class="bi bi-shield-slash text-danger me-1"></i> İlaç Alerjileri:</strong>
                                    <div>
                                        @forelse($activePatient['allergies'] ?? [] as $allergy)
                                            <span class="badge bg-rose-soft me-1 mb-1">{{ $allergy }}</span>
                                        @empty
                                            <span class="text-muted">Kayıtlı Alerji Bulunmuyor</span>
                                        @endforelse
                                    </div>
                                </div>

                                <div class="p-2 rounded border bg-white">
                                    <strong class="text-dark d-block mb-1"><i class="bi bi-activity text-warning me-1"></i> Kronik Tanılar:</strong>
                                    <div>
                                        @forelse($activePatient['chronic_diseases'] ?? [] as $disease)
                                            <span class="badge bg-amber-soft me-1 mb-1">{{ $disease }}</span>
                                        @empty
                                            <span class="text-muted">Kronik Tanı Yok</span>
                                        @endforelse
                                    </div>
                                </div>
                            </div>

                            <!-- Sekme 2: Laboratuvar Sonuçları -->
                            <div class="tab-pane fade" id="tab-labs" role="tabpanel">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-flask text-primary fs-5"></i>
                                        <strong class="text-dark">LIS Laboratuvar Parametreleri & Taraması</strong>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-primary rounded-pill px-3 fw-bold shadow-sm d-flex align-items-center gap-1 text-white" style="background: linear-gradient(135deg, #4338ca, #6366f1); border:none;" data-bs-toggle="modal" data-bs-target="#chiefAiLabModal" onclick="openChiefAiLabModal()">
                                        <i class="bi bi-cpu-fill text-warning me-1"></i> 🧪 Yapay Zekâ Lab Analizi & Risk Tahmini Göster
                                    </button>
                                </div>
                                <table class="table table-sm align-middle table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Parametre</th>
                                            <th>Sonuç</th>
                                            <th>Referans</th>
                                            <th>Durum</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($activePatient['lab_results'] ?? [] as $lab)
                                        <tr>
                                            <td class="fw-semibold text-dark">{{ $lab['test_name'] }}</td>
                                            <td class="fw-bold">{{ $lab['value'] }} {{ $lab['unit'] }}</td>
                                            <td class="text-muted">{{ $lab['reference'] }}</td>
                                            <td>
                                                @if(($lab['status'] ?? '') === 'Yüksek')
                                                    <span class="badge bg-danger">Yüksek</span>
                                                @else
                                                    <span class="badge bg-success">Normal</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-2">Laboratuvar sonucu bulunmuyor.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Sekme 3: Radyoloji & Röntgen Sonuçları (PACS) -->
                            <div class="tab-pane fade" id="tab-rad" role="tabpanel">
                                <div class="list-group list-group-flush">
                                    @forelse($activePatient['radiology_results'] ?? [] as $rad)
                                        <div class="list-group-item px-0 border-0 border-bottom py-2">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <strong class="text-dark"><i class="bi bi-x-diamond text-primary me-1"></i> {{ $rad['type'] }}</strong>
                                                <div>
                                                    @if(!empty($rad['is_new']))
                                                        <span class="badge bg-success me-1">Yeni Çekim</span>
                                                    @else
                                                        <span class="badge bg-secondary me-1">Eski Arşiv</span>
                                                    @endif
                                                    <span class="badge bg-light text-dark border">{{ $rad['date'] }}</span>
                                                </div>
                                            </div>
                                            <div class="text-muted small mb-1">
                                                <strong>Modalite:</strong> {{ $rad['modality'] }} | <strong>Radyolog:</strong> {{ $rad['radiologist'] }}
                                            </div>
                                            <div class="bg-light p-2 rounded border text-dark mb-1" style="font-size:0.78rem;">
                                                <strong>Rapor:</strong> {{ $rad['report'] }}
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="badge bg-indigo-soft text-primary font-monospace" style="font-size:0.7rem;"><i class="bi bi-image me-1"></i> {{ $rad['image_badge'] }}</span>
                                                <button type="button" class="btn btn-outline-primary btn-sm py-0 px-2" style="font-size:0.75rem;" onclick="Swal.fire({icon: 'info', title: '{{ $rad['type'] }} (PACS Görüntüleyici)', html: '<strong>Rapor Kodu:</strong> {{ $rad['id'] }}<br><strong>Çekim Tarihi:</strong> {{ $rad['date'] }}<br><strong>Radyolog Notu:</strong> {{ $rad['report'] }}<br><br><div class=\'p-3 bg-dark text-white rounded font-monospace\'><i class=\'bi bi-display me-2\'></i> HBYS PACS Dicom Web Viewer Aktif (1024x768 Dicom Matrix)</div>', confirmButtonColor: '#2563eb'})">
                                                    <i class="bi bi-eye me-1"></i> PACS Görüntüle
                                                </button>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-muted py-3 text-center">Hastaya ait kaydolmuş röntgen / radyoloji çekimi bulunmuyor.</div>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Sekme 4: Geçmiş Teşhisler -->
                            <div class="tab-pane fade" id="tab-encounters" role="tabpanel">
                                <div class="list-group list-group-flush">
                                    @forelse($activePatient['recent_encounters'] ?? [] as $enc)
                                        <div class="list-group-item px-0 border-0 border-bottom py-2">
                                            <div class="d-flex justify-content-between font-weight-bold">
                                                <strong class="text-primary">{{ $enc['diagnosis'] }}</strong>
                                                <small class="text-muted">{{ $enc['date'] }}</small>
                                            </div>
                                            <div class="text-muted small mt-1">
                                                <i class="bi bi-building me-1"></i> {{ $enc['clinic'] }} ({{ $enc['physician'] }})
                                            </div>
                                            <div class="text-dark small mt-1"><strong>Şikayet:</strong> {{ $enc['complaint'] }}</div>
                                            <div class="text-secondary small mt-1"><em>Not: {{ $enc['notes'] }}</em></div>
                                        </div>
                                    @empty
                                        <div class="text-muted py-3 text-center">Önceki muayene kaydı bulunmuyor.</div>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Sekme 5: İlaçlar -->
                            <div class="tab-pane fade" id="tab-meds" role="tabpanel">
                                <ul class="list-group list-group-flush mb-0">
                                    @forelse($activePatient['medication_history'] ?? [] as $med)
                                        <li class="list-group-item px-0 d-flex justify-content-between align-items-center py-2">
                                            <div>
                                                <strong class="text-dark">{{ $med['drug_name'] }}</strong>
                                                <div class="text-muted small">Dozaj: {{ $med['frequency'] }}</div>
                                            </div>
                                            <span class="badge bg-success">{{ $med['status'] }}</span>
                                        </li>
                                    @empty
                                        <div class="text-muted py-3 text-center">Aktif ilaç kaydı bulunmuyor.</div>
                                    @endforelse
                                </ul>
                            </div>

                            <!-- Sekme 6: Hastanın Geçmiş Raporları -->
                            <div class="tab-pane fade" id="tab-pastrep" role="tabpanel">
                                <div class="list-group list-group-flush">
                                    @forelse($activePatient['past_reports'] ?? [] as $pr)
                                        <div class="list-group-item px-0 border-0 border-bottom py-2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong class="text-dark">{{ $pr['report_number'] }}</strong> - {{ $pr['report_type'] }}
                                                    <div class="text-muted small">Tanı: {{ $pr['diagnosis'] }} | Tarih: {{ $pr['date'] }}</div>
                                                </div>
                                                <button type="button" class="btn btn-outline-info btn-sm py-1 px-2" data-bs-toggle="modal" data-bs-target="#pastReportModal{{ $pr['id'] }}">
                                                    <i class="bi bi-file-earmark-medical me-1"></i> Raporu İncele
                                                </button>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-muted py-3 text-center">Kayıtlı geçmiş rapor bulunmuyor.</div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- DEVLET STANDARTLARINDA E-RAPOR POPUP MODALLARI -->
    <!-- ========================================== -->

    <!-- 1. GEÇMİŞ RAPORLAR MODALLARI -->
    @foreach($activePatient['past_reports'] ?? [] as $pr)
    <div class="modal fade" id="pastReportModal{{ $pr['id'] }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white p-2 px-3">
                    <h6 class="modal-title fw-bold mb-0">
                        <i class="bi bi-shield-check text-success me-2"></i>
                        T.C. Sağlık Bakanlığı e-Rapor Resmi Belge Görünümü ({{ $pr['report_number'] }})
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-3 bg-light">
                    <!-- DEVLET STANDARTINDA RESMİ E-RAPOR KARTI -->
                    <div class="official-report-card shadow-sm rounded">
                        <div class="text-center border-bottom pb-2 mb-3">
                            <h5 class="fw-bold text-uppercase mb-1" style="color: #8b0000; font-family: serif;">T.C. SAĞLIK BAKANLIĞI</h5>
                            <h6 class="fw-bold text-dark mb-1">ANKARA ŞEHİR HASTANESİ DOKTOR ROLÜ TIBBİ E-RAPORU</h6>
                            <span class="badge bg-secondary">SGK MEDULA ENTEGRE E-RAPOR ADAPTÖRÜ</span>
                        </div>

                        <!-- Referans & Barkod -->
                        <div class="d-flex justify-content-between align-items-center bg-light p-2 rounded border mb-3 small font-monospace">
                            <div>
                                <strong>Rapor Takip No:</strong> {{ $pr['report_number'] }}<br>
                                <strong>SGK Medula Onay Kodu:</strong> <span class="text-success fw-bold">{{ $pr['e_rapor_no'] }}</span>
                            </div>
                            <div class="text-end">
                                <strong>Düzenlenme Tarihi:</strong> {{ $pr['date'] }}<br>
                                <span class="badge bg-success">Resmi E-İmzalı Doküman</span>
                            </div>
                        </div>

                        <!-- Hasta Kimlik Tablosu -->
                        <table class="table table-bordered table-sm mb-3 small">
                            <tr class="table-secondary"><th colspan="4" class="text-center">HASTA KİMLİK VE SİGORTA BİLGİLERİ</th></tr>
                            <tr>
                                <th width="20%">T.C. Kimlik No:</th><td width="30%">{{ $activePatient['national_id'] ?? '-' }}</td>
                                <th width="20%">Adı Soyadı:</th><td width="30%">{{ !empty($activePatient) ? ($activePatient['first_name'] . ' ' . $activePatient['last_name']) : 'Hasta Seçilmedi' }}</td>
                            </tr>
                            <tr>
                                <th>Doğum T. / Cinsiyet:</th><td>{{ $activePatient['birth_date'] ?? '-' }} / {{ $activePatient['gender'] ?? '-' }}</td>
                                <th>Sosyal Güvence:</th><td>SGK 4/a (SSK) - Aktif Sigortalı</td>
                            </tr>
                        </table>

                        <!-- Rapor Teşhis & İçerik Tablosu -->
                        <table class="table table-bordered table-sm mb-3 small">
                            <tr class="table-primary text-white"><th colspan="4" class="text-center bg-primary">KLİNİK TEŞHİS VE RAPOR KARARI</th></tr>
                            <tr>
                                <th width="20%">Rapor Türü:</th><td colspan="3" class="fw-bold text-primary">{{ $pr['report_type'] }}</td>
                            </tr>
                            <tr>
                                <th>ICD-10 Tanısı:</th><td colspan="3" class="fw-bold text-dark">{{ $pr['diagnosis'] }}</td>
                            </tr>
                            <tr>
                                <th>İstirahat Süresi:</th><td colspan="3"><span class="badge bg-warning text-dark">{{ $pr['rest_days'] }} Gün İstirahat</span></td>
                            </tr>
                            <tr>
                                <th>Klinik Karar Metni:</th><td colspan="3" class="text-muted" style="white-space: pre-line;">{{ $pr['content'] }}</td>
                            </tr>
                        </table>

                        <!-- E-İmza Ve Hekim Onayı -->
                        <div class="row g-2 text-center small mt-3 border-top pt-2">
                            <div class="col-6">
                                <div class="p-2 border rounded bg-light">
                                    <div class="text-muted" style="font-size:0.7rem;">DÜZENLEYEN HEKİM</div>
                                    <div class="fw-bold text-dark">{{ $pr['physician'] }}</div>
                                    <small class="text-success"><i class="bi bi-shield-check me-1"></i> 5070 s.K. Güvenli E-İmza</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-2 border rounded bg-light">
                                    <div class="text-muted" style="font-size:0.7rem;">SGK MEDULA ONÂY MÜHRÜ</div>
                                    <div class="fw-bold text-success">✅ KABUL EDİLDİ ({{ $pr['e_rapor_no'] }})</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light p-2">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Kapat</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- 2. DOKTOR ONAY MASASI RAPOR MODALLARI -->
    @foreach($reports as $r)
    <div class="modal fade" id="reportModal{{ $r->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white p-2 px-3">
                    <h6 class="modal-title fw-bold mb-0">
                        <i class="bi bi-file-earmark-medical text-primary me-2"></i>
                        T.C. Sağlık Bakanlığı e-Rapor İnceleme & Doktor Onay Masası ({{ $r->report_number }})
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-3 bg-light">
                    <div class="official-report-card shadow-sm rounded mb-3">
                        <div class="text-center border-bottom pb-2 mb-3">
                            <h5 class="fw-bold text-uppercase mb-1" style="color: #8b0000; font-family: serif;">T.C. SAĞLIK BAKANLIĞI</h5>
                            <h6 class="fw-bold text-dark mb-1">DOKTOR PANELİ TIBBİ E-RAPOR BELGESİ</h6>
                            <span class="badge bg-dark">SGK SUT MEVZUATINA UYGUN</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center bg-light p-2 rounded border mb-3 small font-monospace">
                            <div>
                                <strong>Rapor Kodu:</strong> {{ $r->report_number }}<br>
                                <strong>SGK Medula Onay Kodu:</strong> <span class="text-success fw-bold">{{ $r->e_rapor_no ?? 'ERAP-2026-BEKLİYOR' }}</span>
                            </div>
                            <div class="text-end">
                                <strong>Tarih:</strong> {{ $r->created_at ? $r->created_at->format('d.m.Y H:i') : date('d.m.Y') }}<br>
                                <span class="badge bg-info text-dark">E-İmza Taslağı</span>
                            </div>
                        </div>

                        <table class="table table-bordered table-sm mb-3 small">
                            <tr class="table-secondary"><th colspan="4" class="text-center">HASTA KİMLİK VE SİGORTA BİLGİLERİ</th></tr>
                            <tr>
                                <th width="20%">T.C. Kimlik No:</th><td width="30%">{{ $activePatient['national_id'] ?? '-' }}</td>
                                <th width="20%">Adı Soyadı:</th><td width="30%">{{ !empty($activePatient) ? ($activePatient['first_name'] . ' ' . $activePatient['last_name']) : 'Hasta Seçilmedi' }}</td>
                            </tr>
                            <tr>
                                <th>Doğum T. / Cinsiyet:</th><td>{{ $activePatient['birth_date'] ?? '-' }} / {{ $activePatient['gender'] ?? '-' }}</td>
                                <th>Sosyal Güvence:</th><td>SGK 4/a (SSK) - Aktif Sigortalı</td>
                            </tr>
                        </table>

                        <table class="table table-bordered table-sm mb-3 small">
                            <tr class="table-primary text-white"><th colspan="4" class="text-center bg-primary">KLİNİK TEŞHİS VE RAPOR KARARI</th></tr>
                            <tr>
                                <th width="20%">Rapor Türü:</th><td colspan="3" class="fw-bold text-primary">{{ $r->report_type }}</td>
                            </tr>
                            <tr>
                                <th>ICD-10 Tanısı:</th><td colspan="3" class="fw-bold text-dark">{{ $r->diagnosis }}</td>
                            </tr>
                            <tr>
                                <th>İstirahat Süresi:</th><td colspan="3"><span class="badge bg-warning text-dark">{{ $r->rest_days }} Gün İstirahat</span></td>
                            </tr>
                            <tr>
                                <th>Klinik Karar Metni:</th><td colspan="3" class="text-muted" style="white-space: pre-line;">{{ $r->report_content }}</td>
                            </tr>
                        </table>

                        <div class="row g-2 text-center small border-top pt-2">
                            <div class="col-6">
                                <div class="p-2 border rounded bg-light">
                                    <div class="text-muted" style="font-size:0.7rem;">DÜZENLEYEN HEKİM E-İMZA</div>
                                    <div class="fw-bold text-dark">{{ auth()->user()->name ?? 'Dr. Sude Hekim' }}</div>
                                    <small class="text-success"><i class="bi bi-shield-check me-1"></i> 5070 s.K. E-İmzalanacaktır</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-2 border rounded bg-light">
                                    <div class="text-muted" style="font-size:0.7rem;">SGK E-RAPOR ONÂY MÜHRÜ</div>
                                    <div class="fw-bold">
                                        @if($r->chief_physician_approval_status === 'approved')
                                            <span class="text-success">✅ ONAYLANDI ({{ $r->e_rapor_no }})</span>
                                        @elseif($r->chief_physician_approval_status === 'rejected')
                                            <span class="text-danger">❌ REDDEDİLDİ</span>
                                        @else
                                            <span class="text-warning">⏳ HEKİM ONAYI BEKLİYOR</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer bg-light p-2">
                    @if($r->chief_physician_approval_status !== 'approved' && $r->chief_physician_approval_status !== 'rejected')
                        <form action="{{ route('medical_report.approve', $r->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm fw-bold">
                                <i class="bi bi-check-circle me-1"></i> Doktor Onayı Ver & e-Rapor Kodu Al
                            </button>
                        </form>
                        <form action="{{ route('medical_report.reject', $r->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm fw-semibold">
                                <i class="bi bi-x-circle me-1"></i> Reddet
                            </button>
                        </form>
                    @else
                        <span class="badge bg-secondary p-2">Bu Rapor Onaylanmıştır</span>
                    @endif
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Kapat</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- ICD-10 KODLARI BROWSER VE MANUEL SEÇİM MODALI -->
    <div class="modal fade" id="icd10BrowserModal" tabindex="-1" aria-labelledby="icd10BrowserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-dark text-white py-3">
                    <div>
                        <h5 class="modal-title fw-bold text-emerald d-flex align-items-center gap-2" id="icd10BrowserModalLabel">
                            <i class="bi bi-journal-bookmark-fill text-success fs-4"></i>
                            T.C. Sağlık Bakanlığı ICD-10 Hastalık Kataloğu (Doktor Manuel Teşhis Seçimi)
                        </h5>
                        <small class="text-white-50">Tüm resmi ICD-10 hastalık kodlarını filtreleyebilir, arayabilir ve hastanın teşhis/reçete kartına anında aktarabilirsiniz.</small>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Kapat"></button>
                </div>
                <div class="modal-body p-3 bg-light">
                    <!-- Arama ve Kategori Filtreleme Barı -->
                    <div class="card border-0 shadow-sm p-3 mb-3 bg-white rounded-3">
                        <div class="row g-2 align-items-center mb-2">
                            <div class="col-md-7">
                                <div class="input-group">
                                    <span class="input-group-text bg-success text-white border-success"><i class="bi bi-search"></i></span>
                                    <input type="text" id="icd10ModalSearchInput" onkeyup="filterIcd10ModalList()" class="form-control form-control-lg border-success fw-semibold" placeholder="Hastalık adı veya ICD-10 kodu ile arayın (Örn: J30, Alerjik Rinit, Aritmi, Bel Ağrısı)...">
                                </div>
                            </div>
                            <div class="col-md-5 text-end">
                                <span id="icd10TotalCountBadge" class="badge bg-emerald-soft text-emerald fs-6 py-2 px-3 border border-emerald-subtle fw-bold">
                                    <i class="bi bi-list-check me-1"></i> Yükleniyor...
                                </span>
                            </div>
                        </div>
                        
                        <!-- Hızlı Kategori Filtre Butonları -->
                        <div class="d-flex flex-wrap gap-1" id="icd10CategoryFilterButtons">
                            <button type="button" class="btn btn-sm btn-dark fw-bold rounded-pill px-2.5 icd-cat-btn active" onclick="filterIcd10Category('', this)">Tümü</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-2.5 icd-cat-btn" onclick="filterIcd10Category('J', this)">Solunum (J)</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-2.5 icd-cat-btn" onclick="filterIcd10Category('I', this)">Kardiyovasküler (I)</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-2.5 icd-cat-btn" onclick="filterIcd10Category('M', this)">Kas-İskelet (M)</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-2.5 icd-cat-btn" onclick="filterIcd10Category('K', this)">Sindirim (K)</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-2.5 icd-cat-btn" onclick="filterIcd10Category('A', this)">Gastro-Enfeksiyon (A)</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-2.5 icd-cat-btn" onclick="filterIcd10Category('G', this)">Nöroloji (G)</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-2.5 icd-cat-btn" onclick="filterIcd10Category('F', this)">Psikiyatri (F)</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-2.5 icd-cat-btn" onclick="filterIcd10Category('L', this)">Dermatoloji (L)</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-2.5 icd-cat-btn" onclick="filterIcd10Category('R', this)">Genel/Semptom (R)</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-2.5 icd-cat-btn" onclick="filterIcd10Category('N', this)">Üroloji (N)</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-2.5 icd-cat-btn" onclick="filterIcd10Category('H', this)">Göz & KBB (H)</button>
                        </div>
                    </div>

                    <!-- ICD-10 Kodları Tablosu -->
                    <div class="card border-0 shadow-sm bg-white rounded-3 overflow-hidden">
                        <div class="table-responsive" style="max-height: 480px;">
                            <table class="table table-hover align-middle mb-0" id="icd10ModalTable">
                                <thead class="bg-slate-100 text-dark sticky-top" style="z-index: 2;">
                                    <tr>
                                        <th style="width: 140px;" class="ps-3 py-2.5">ICD-10 Kodu</th>
                                        <th class="py-2.5">Resmi Hastalık / Tanı Açıklaması</th>
                                        <th class="py-2.5">Önerilen Tedavi & İlaç Reçetesi</th>
                                        <th style="width: 190px;" class="text-end pe-3 py-2.5">Seçim Aksiyonu</th>
                                    </tr>
                                </thead>
                                <tbody id="icd10ModalTableBody">
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <div class="spinner-border text-success mb-2" role="status"></div>
                                            <div>ICD-10 Hastalık Kodları Yükleniyor...</div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-white py-2 px-3 justify-content-between">
                    <span class="text-muted small"><i class="bi bi-info-circle me-1"></i> T.C. Sağlık Bakanlığı SBSGM Resmi ICD-10 Kod Kataloğu</span>
                    <button type="button" class="btn btn-secondary btn-sm px-4" data-bs-dismiss="modal">Kapat</button>
                </div>
            </div>
        </div>
    </div>

    <!-- YAPAY ZEKÂ TIBBİ DOSYA & LAB ANALİZ MODALI (Sade, Yalın & Yüksek Okunabilirlikte) -->
    <div class="modal fade" id="chiefAiLabModal" tabindex="-1" aria-labelledby="chiefAiLabModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 14px;">
                <div class="modal-header bg-white border-bottom px-4 py-3">
                    <div class="d-flex align-items-center gap-2">
                        <div class="p-2 bg-indigo-soft rounded-circle text-indigo">
                            <i class="bi bi-cpu-fill fs-5"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold text-dark mb-0" id="chiefAiLabModalLabel">
                                Yapay Zekâ Lab Analizi & Risk Tahmini
                            </h5>
                            <small class="text-muted" id="modal-patient-name">Hasta LIS Taraması & Klinik Değerlendirme</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                </div>

                <div class="modal-body p-4 bg-light">
                    <!-- Yükleniyor Göstergesi -->
                    <div id="chief-ai-lab-loading" class="text-center py-5">
                        <div class="spinner-border text-primary mb-3" role="status"></div>
                        <h6 class="fw-bold text-dark mb-1">Yapay Zekâ Lab Verilerini Taramakta...</h6>
                        <p class="small text-muted mb-0">Teşhis tahminleri, gelecek riskler ve düzeltme önerileri hesaplanıyor.</p>
                    </div>

                    <!-- Analiz İçeriği -->
                    <div id="chief-ai-lab-content" style="display: none;">

                        <!-- 1. Olası Teşhisler -->
                        <div class="card-clean p-3 mb-3 bg-white">
                            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                                    <i class="bi bi-activity text-primary"></i> Mevcut Olası Teşhisler
                                </h6>
                                <span class="badge bg-indigo-soft" id="c-count-diagnoses">0 Teşhis</span>
                            </div>
                            <div id="c-container-diagnoses" class="d-flex flex-column gap-2"></div>
                        </div>

                        <!-- 2. Gelecek Riskler -->
                        <div class="card-clean p-3 mb-3 bg-white">
                            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                                    <i class="bi bi-exclamation-triangle-fill text-warning"></i> Gelecekte Oluşabilecek Riskler (1-5 Yıl)
                                </h6>
                                <span class="badge bg-rose-soft">Komplikasyon Projeksiyonu</span>
                            </div>
                            <div id="c-container-risks" class="d-flex flex-column gap-2"></div>
                        </div>

                        <!-- 3. İyileştirme Önerileri -->
                        <div class="card-clean p-3 bg-white">
                            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                                    <i class="bi bi-check-circle-fill text-success"></i> Değerleri Düzeltme & Klinik Öneriler
                                </h6>
                                <span class="badge bg-emerald-soft">Aksiyon Planı</span>
                            </div>

                            <div class="mb-3">
                                <div class="fw-semibold text-indigo small mb-1"><i class="bi bi-capsule me-1"></i> Medikal / Reçete Revizyonu:</div>
                                <div id="c-container-med-recs" class="small text-secondary ps-2"></div>
                            </div>

                            <div class="mb-3">
                                <div class="fw-semibold text-amber small mb-1" style="color:#b45309;"><i class="bi bi-apple me-1"></i> Beslenme & Yaşam Tarzı:</div>
                                <div id="c-container-lifestyle-recs" class="small text-secondary ps-2"></div>
                            </div>

                            <div>
                                <div class="fw-semibold text-teal small mb-1" style="color:#0d9488;"><i class="bi bi-calendar-event me-1"></i> Takip & İleri Tetkik:</div>
                                <div id="c-container-followup-recs" class="small text-secondary ps-2"></div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer bg-white px-4 py-2 d-flex justify-content-between border-top">
                    <button type="button" class="btn btn-outline-success btn-sm rounded-pill px-3 fw-semibold" onclick="copyChiefAiLabToReport()">
                        <i class="bi bi-file-earmark-plus me-1"></i> 📋 Rapora Aktar
                    </button>
                    <button type="button" class="btn btn-secondary btn-sm rounded-pill px-3" data-bs-dismiss="modal">Kapat</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    let chiefCurrentAiLabSummary = '';

    document.addEventListener('DOMContentLoaded', function() {
        const modalEl = document.getElementById('chiefAiLabModal');
        if (modalEl) {
            modalEl.addEventListener('show.bs.modal', function () {
                fetchChiefAiLabData();
            });
        }
    });

    function openChiefAiLabModal() {
        const modalEl = document.getElementById('chiefAiLabModal');
        if (modalEl) {
            if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                modal.show();
            } else if (typeof $ !== 'undefined' && $.fn.modal) {
                $(modalEl).modal('show');
            }
        }
        fetchChiefAiLabData();
    }

    function fetchChiefAiLabData() {
        const loadingEl = document.getElementById('chief-ai-lab-loading');
        const contentEl = document.getElementById('chief-ai-lab-content');
        if (loadingEl) loadingEl.style.display = 'block';
        if (contentEl) contentEl.style.display = 'none';

        const urlParams = new URLSearchParams(window.location.search);
        let activePatientId = urlParams.get('patient_id') ? parseInt(urlParams.get('patient_id')) : 1;

        fetch("{{ route('ai.lab_analysis.analyze') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ patient_id: activePatientId })
        })
        .then(res => {
            if (!res.ok) {
                throw new Error('HTTP ' + res.status);
            }
            return res.json();
        })
        .then(data => {
            if (loadingEl) loadingEl.style.display = 'none';
            if (contentEl) contentEl.style.display = 'block';
            renderChiefAiLabModalData(data);
        })
        .catch(err => {
            if (loadingEl) {
                loadingEl.innerHTML = '<div class="alert alert-danger p-3 small mb-0"><i class="bi bi-exclamation-triangle-fill me-1"></i> Yapay Zekâ Analiz verileri yüklenirken hata oluştu (' + err.message + '). Lütfen tekrar deneyiniz.</div>';
            }
            console.error(err);
        });
    }

    function renderChiefAiLabModalData(data) {
        if (!data) return;

        if (data.patient_info && data.patient_info.name) {
            const nameEl = document.getElementById('modal-patient-name');
            if (nameEl) nameEl.textContent = 'Hasta: ' + data.patient_info.name + ' (' + data.patient_info.age + ' Yaş, ' + data.patient_info.gender + ')';
        }

        let summaryTxt = "=== YAPAY ZEKÂ LAB ANALİZ ÖZETİ ===\n";

        // 1. Olası Teşhisler
        const diagContainer = document.getElementById('c-container-diagnoses');
        if (diagContainer) {
            const countEl = document.getElementById('c-count-diagnoses');
            if (countEl) {
                countEl.textContent = (data.current_diagnoses || []).length + ' Teşhis';
            }
            diagContainer.innerHTML = '';

            (data.current_diagnoses || []).forEach(d => {
                summaryTxt += "- Teşhis: " + d.disease + " (ICD-10: " + d.icd10 + ", Olasılık: %" + d.probability + ")\n";
                summaryTxt += "  Gerekçe: " + d.clinical_summary + "\n";

                const div = document.createElement('div');
                div.className = 'p-2.5 rounded-3 bg-slate-soft border d-flex flex-column gap-1';
                div.innerHTML = `
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-dark font-size-sm"><span class="badge bg-secondary font-monospace me-1.5">${d.icd10}</span>${d.disease}</span>
                        <span class="badge bg-indigo-soft">%${d.probability} Olasılık</span>
                    </div>
                    <div class="small text-secondary" style="font-size:0.825rem;">${d.clinical_summary}</div>
                `;
                diagContainer.appendChild(div);
            });
        }

        summaryTxt += "\n=== GELECEK HASTALIK RİSKLERİ ===\n";
        // 2. Gelecek Riskler
        const riskContainer = document.getElementById('c-container-risks');
        if (riskContainer) {
            riskContainer.innerHTML = '';
            (data.future_risks || []).forEach(r => {
                summaryTxt += "- " + r.condition + " (" + r.timeline + " - Risk: %" + r.risk_score + ")\n";
                summaryTxt += "  Açıklama: " + r.description + "\n";

                const div = document.createElement('div');
                div.className = 'p-2.5 rounded-3 bg-rose-soft border border-rose-subtle d-flex flex-column gap-1';
                div.innerHTML = `
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-dark font-size-sm">${r.condition}</span>
                        <div>
                            <span class="badge bg-white text-danger border me-1">${r.timeline}</span>
                            <span class="badge bg-danger text-white">%${r.risk_score}</span>
                        </div>
                    </div>
                    <div class="small text-secondary" style="font-size:0.825rem;">${r.description}</div>
                `;
                riskContainer.appendChild(div);
            });
        }

        summaryTxt += "\n=== İYİLEŞTİRME & DÜZELTME ÖNERİLERİ ===\n";
        const recs = data.improvement_recommendations || {};
        
        // Medikal
        const medBox = document.getElementById('c-container-med-recs');
        if (medBox) {
            medBox.innerHTML = (recs.medical_adjustments || []).map(m => {
                summaryTxt += "* " + m.title + ": " + m.detail + "\n";
                return `<div class="mb-1.5"><strong class="text-dark">• ${m.title}:</strong> ${m.detail}</div>`;
            }).join('');
        }

        // Beslenme
        const lifeBox = document.getElementById('c-container-lifestyle-recs');
        if (lifeBox) {
            lifeBox.innerHTML = (recs.lifestyle_and_nutrition || []).map(l => {
                summaryTxt += "* " + l.title + ": " + l.detail + "\n";
                return `<div class="mb-1.5"><strong class="text-dark">• ${l.title}:</strong> ${l.detail}</div>`;
            }).join('');
        }

        // Takip
        const folBox = document.getElementById('c-container-followup-recs');
        if (folBox) {
            folBox.innerHTML = (recs.followup_schedule || []).map(f => {
                summaryTxt += "* " + f.title + ": " + f.detail + "\n";
                return `<div class="mb-1.5"><strong class="text-dark">• ${f.title}:</strong> ${f.detail}</div>`;
            }).join('');
        }

        chiefCurrentAiLabSummary = summaryTxt;
    }

    function copyChiefAiLabToReport() {
        const reportTextarea = document.getElementById('chief_report_content') || document.getElementById('report_content') || document.querySelector('textarea[name="report_content"]');
        if (reportTextarea && chiefCurrentAiLabSummary) {
            reportTextarea.value = (reportTextarea.value ? reportTextarea.value + "\n\n" : "") + chiefCurrentAiLabSummary;
            
            const modalEl = document.getElementById('chiefAiLabModal');
            if (modalEl) {
                if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                    const modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) modal.hide();
                } else if (typeof $ !== 'undefined' && $.fn.modal) {
                    $(modalEl).modal('hide');
                }
            }

            if (typeof Swal !== 'undefined') {
                const toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1500
                });
                toast.fire({
                    icon: 'success',
                    title: 'Metin rapora kopyalandı'
                });
            } else {
                alert('AI Lab Analizi rapor metnine eklendi!');
            }
        }
    }

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
            fetch("{{ route('medical_report.search_patients_ajax') }}?q=" + encodeURIComponent(query.trim()))
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success' && data.patients && data.patients.length > 0) {
                        let html = '';
                        data.patients.forEach(p => {
                            html += `
                                <a href="{{ route('medical_report.chief_physician') }}?patient_id=${p.patient_id}" class="list-group-item list-group-item-action p-2.5 border-0 border-bottom d-flex justify-content-between align-items-center hover-bg-light">
                                    <div>
                                        <div class="fw-bold text-dark d-flex align-items-center gap-2">
                                            <i class="bi bi-person-circle text-primary fs-6"></i> ${p.first_name} ${p.last_name}
                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle font-monospace">TC: ${p.national_id}</span>
                                        </div>
                                        <div class="text-muted small mt-1" style="font-size:0.75rem;">
                                            <i class="bi bi-calendar-event me-1"></i> Doğum: <strong>${p.birth_date}</strong> | Cinsiyet: <strong>${p.gender}</strong> | Kan: <strong>${p.blood_type}</strong>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-light text-dark border mb-1 d-block"><i class="bi bi-building me-1"></i> ${p.clinic}</span>
                                        <span class="btn btn-primary btn-sm py-0 px-2 fw-semibold" style="font-size:0.72rem;">Seç & Dosyayı Aç &rarr;</span>
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

    function clearDiagnosisForm() {
        if (document.getElementById('patient_complaint')) document.getElementById('patient_complaint').value = '';
        if (document.getElementById('ai_diagnosis_input')) document.getElementById('ai_diagnosis_input').value = '';
        if (document.getElementById('ai_treatment_input')) document.getElementById('ai_treatment_input').value = '';
        if (document.getElementById('diagnosis')) document.getElementById('diagnosis').value = '';
        if (document.getElementById('report_content')) document.getElementById('report_content').value = '';

        const suggestionsContainer = document.getElementById('ai_suggestions_container');
        if (suggestionsContainer) {
            suggestionsContainer.innerHTML = '';
        }

        const toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });
        toast.fire({
            icon: 'info',
            title: 'Form ve metin alanları temizlendi'
        });
    }

    function fetchPatientAiSupport() {
        const patientSelect = document.querySelector('select[name="patient_id"]');
        const patientId = patientSelect ? patientSelect.value : "{{ $activePatient['patient_id'] ?? '' }}";

        if (!patientId) {
            Swal.fire({
                icon: 'warning',
                title: 'Hasta Seçilmedi',
                text: 'AI karar desteği ve teşhis önerisi alabilmek için lütfen önce yukarıdaki alandan bir hasta seçiniz.',
                confirmButtonColor: '#f59e0b'
            });
            return;
        }

        const complaintInput = document.getElementById('patient_complaint');
        const complaint = complaintInput ? complaintInput.value.trim() : '';

        // EĞER HASTA ŞİKAYETİ KUTUSU BOŞ İSE: UYARI VER VE DUR!
        if (!complaint || complaint.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Hasta Şikayeti Girilmedi',
                text: 'AI klinik değerlendirmesi ve teşhis/reçete önerisi alabilmek için lütfen önce 1. alana hasta şikayeti & anamnez bilgisini yazınız.',
                confirmButtonColor: '#f59e0b',
                confirmButtonText: 'Anlaşıldı'
            });
            if (complaintInput) {
                complaintInput.focus();
            }
            return;
        }

        Swal.fire({
            title: 'AI Karar Destek Çalışıyor...',
            text: 'Girilen şikayete göre teşhis ve reçete önerileri hazırlanıyor.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        fetch("{{ route('medical_report.patient_ai_support') }}?patient_id=" + patientId + "&complaint=" + encodeURIComponent(complaint))
            .then(res => res.json())
            .then(data => {
                if (data.status === 'empty_complaint' || data.status === 'unrecognized_complaint') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Tıbbi Bulgu Saptanamadı',
                        text: data.message || 'Girilen metinde geçerli bir tıbbi şikayet saptanamadı. Lütfen hastanın yakınmasını (örn: baş ağrısı, öksürük, mide bulantısı, bel ağrısı) yazınız.',
                        confirmButtonColor: '#f59e0b'
                    });
                    if (complaintInput) complaintInput.focus();
                    return;
                }

                if (data.suggested_diagnosis) {
                    if (document.getElementById('ai_diagnosis_input')) document.getElementById('ai_diagnosis_input').value = data.suggested_diagnosis;
                    if (document.getElementById('diagnosis')) document.getElementById('diagnosis').value = data.suggested_diagnosis;
                }

                if (data.suggested_medications && data.suggested_medications.length > 0 && document.getElementById('ai_treatment_input')) {
                    let rxText = data.suggested_medications.map(m => m.drug + ' (' + m.dosage + ') - ' + m.warning).join('\n');
                    document.getElementById('ai_treatment_input').value = rxText;
                }

                if (document.getElementById('aiDiagnosesList') && data.suggested_diagnoses && data.suggested_diagnoses.length > 0) {
                    let diagHtml = '';
                    data.suggested_diagnoses.forEach(item => {
                        diagHtml += `<span class="badge bg-emerald-soft text-emerald border border-emerald-subtle p-2 text-wrap text-start" style="cursor:pointer; font-size:0.75rem;" onclick="selectDiagnosis('${item.icd} - ${item.name}', '${item.icd}')">
                            <i class="bi bi-plus-circle me-1"></i> ${item.icd} - ${item.name} (${item.confidence})
                        </span>`;
                    });
                    document.getElementById('aiDiagnosesList').innerHTML = diagHtml;
                }

                Swal.fire({
                    icon: 'success',
                    title: 'AI Önerileri Üretildi!',
                    text: 'Teşhis ve Reçete alanları hastaya özel AI analiz verileriyle otomatik dolduruldu.',
                    timer: 2000,
                    showConfirmButton: false
                });
            })
            .catch(err => {
                console.error("AI error:", err);
                Swal.fire({
                    icon: 'error',
                    title: 'AI Servis Hatası',
                    text: 'AI servisinden yanıt alınamadı. Lütfen tekrar deneyiniz.',
                    confirmButtonColor: '#ef4444'
                });
            });
    }

    function selectDiagnosis(diagText, icdCode) {
        if (document.getElementById('ai_diagnosis_input')) {
            document.getElementById('ai_diagnosis_input').value = diagText;
        }
        if (document.getElementById('diagnosis')) {
            document.getElementById('diagnosis').value = diagText;
        }

        if (!icdCode && diagText) {
            icdCode = diagText.split(' - ')[0].trim();
        }

        if (icdCode) {
            fetch("{{ route('medical_report.icd10_search') }}?q=" + encodeURIComponent(icdCode))
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success' && data.data && data.data.length > 0) {
                        let matched = data.data.find(d => d.code === icdCode) || data.data[0];
                        if (matched && matched.recommended_drugs && matched.recommended_drugs.length > 0 && document.getElementById('ai_treatment_input')) {
                            let rxText = matched.recommended_drugs.map(m => m.name + ' (' + (m.dosage || '') + ') - ' + (m.purpose || 'Klinik Tedavi')).join('\n');
                            document.getElementById('ai_treatment_input').value = rxText;
                        }
                    }
                })
                .catch(err => console.error("Drugs fetch error:", err));
        }

        Swal.fire({
            icon: 'success',
            title: 'Teşhis & İlaç Reçetesi Seçildi',
            text: 'Seçilen tanı (' + diagText + ') ve tedavi ilaçları otomatik aktarıldı.',
            timer: 1800,
            showConfirmButton: false
        });
    }


    function autoFillAiDraft() {
        const reportTypeInput = document.getElementById('report_type');
        const reportType = reportTypeInput ? reportTypeInput.value : 'Ayaktan İstirahat Raporu';
        const diagnosisInput = document.getElementById('ai_diagnosis_input') || document.getElementById('diagnosis');
        const diagnosis = diagnosisInput ? diagnosisInput.value : 'I10 - Essansiyel Hipertansiyon';
        const restDaysInput = document.getElementById('rest_days');
        const restDays = restDaysInput ? restDaysInput.value : 5;
        const patientSelect = document.querySelector('select[name="patient_id"]');
        const patientId = patientSelect ? patientSelect.value : "{{ $activePatient['patient_id'] ?? '' }}";
        const complaint = document.getElementById('patient_complaint') ? document.getElementById('patient_complaint').value : '';

        if (!patientId) {
            Swal.fire({
                icon: 'warning',
                title: 'Hasta Seçilmedi',
                text: 'AI otomatik taslak doldurma yapmak için lütfen önce yukarıdaki alandan bir hasta seçiniz.',
                confirmButtonColor: '#f59e0b'
            });
            return;
        }

        fetch("{{ route('medical_report.ai_autofill') }}", {
            method: "POST",
            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
            body: JSON.stringify({
                patient_id: patientId,
                report_type: reportType,
                diagnosis: diagnosis,
                rest_days: restDays,
                complaint: complaint
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.suggested_content && document.getElementById('report_content')) {
                document.getElementById('report_content').value = data.suggested_content;
            } else if (data.report_content && document.getElementById('report_content')) {
                document.getElementById('report_content').value = data.report_content;
            }

            Swal.fire({
                icon: 'success',
                title: 'AI Rapor Metni Dolduruldu',
                text: 'Seçilen tanı ve klinik verilere göre e-rapor metni otomatik üretildi.',
                timer: 2000,
                showConfirmButton: false
            });
        });
    }

    function acceptAiRecommendation(customDiagnosis = null, isEdited = false, customBadge = null, customNotes = null) {
        const patientSelect = document.querySelector('select[name="patient_id"]');
        const patientId = patientSelect ? patientSelect.value : "{{ $activePatient['patient_id'] ?? '' }}";
        const complaint = document.getElementById('patient_complaint') ? document.getElementById('patient_complaint').value : '';
        const diagnosis = customDiagnosis || (document.getElementById('diagnosis') ? document.getElementById('diagnosis').value : 'I10 - Essansiyel Hipertansiyon');

        if (!patientId) {
            Swal.fire({
                icon: 'warning',
                title: 'Hasta Seçilmedi',
                text: 'Teşhis ve reçeteyi kaydetmek için lütfen önce yukarıdaki alandan bir hasta seçiniz.',
                confirmButtonColor: '#f59e0b'
            });
            return;
        }

        fetch("{{ route('medical_report.accept_ai_recommendation') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                patient_id: patientId,
                diagnosis: diagnosis,
                complaint: complaint,
                is_edited: isEdited
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                if (document.getElementById('diagnosis')) {
                    document.getElementById('diagnosis').value = data.diagnosis;
                }
                if (data.suggested_content && document.getElementById('report_content')) {
                    document.getElementById('report_content').value = data.suggested_content;
                }

                const encountersList = document.querySelector('#tab-encounters .list-group');
                if (encountersList) {
                    const emptyMsg = encountersList.querySelector('.text-center');
                    if (emptyMsg) emptyMsg.remove();

                    const enc = data.encounter;
                    const badgeTitle = customBadge || (isEdited ? 'HEKİM DÜZENLEMESİ' : 'KAYDEDİLDİ (AI ONAYLI)');
                    const badgeBg = isEdited ? (customBadge && customBadge.includes('MANUEL') ? 'bg-danger text-white' : 'bg-warning text-dark') : 'bg-success';
                    const borderBg = isEdited ? (customBadge && customBadge.includes('MANUEL') ? 'border-danger' : 'border-warning') : 'border-success';
                    const iconType = isEdited ? (customBadge && customBadge.includes('MANUEL') ? 'pencil-fill text-danger' : 'pencil-square text-warning') : 'check-circle-fill';
                    const noteContent = customNotes || enc.notes;

                    const newHtml = `
                        <div class="list-group-item px-0 border-0 border-bottom p-2 rounded mb-1 bg-light border-start border-4 ${borderBg} animate__animated animate__fadeIn">
                            <div class="d-flex justify-content-between align-items-center">
                                <strong class="${isEdited ? 'text-dark fw-bold' : 'text-success'}"><i class="bi bi-${iconType} me-1"></i> ${enc.diagnosis}</strong>
                                <span class="badge ${badgeBg}">${enc.date} (${badgeTitle})</span>
                            </div>
                            <div class="text-muted small mt-1">
                                <i class="bi bi-building me-1"></i> ${enc.clinic} (${enc.physician})
                            </div>
                            <div class="text-dark small mt-1"><strong>Şikayet:</strong> ${enc.complaint}</div>
                            <div class="text-secondary small mt-1"><em>Not: ${noteContent}</em></div>
                        </div>
                    `;
                    encountersList.insertAdjacentHTML('afterbegin', newHtml);
                }

                const encountersTab = document.getElementById('tab-encounters-tab');
                if (encountersTab) {
                    encountersTab.click();
                }

                Swal.fire({
                    icon: 'success',
                    title: isEdited ? (customBadge && customBadge.includes('MANUEL') ? 'Manuel Teşhis Yazıldı & Kaydedildi!' : 'Teşhis Düzenlendi & Kaydedildi!') : 'Teşhis Başarıyla Kaydedildi!',
                    text: 'Teşhis (' + data.diagnosis + ') hasta tıbbi dosyasına eklendi ve rapor taslağına aktarıldı.',
                    confirmButtonText: 'Tamam',
                    confirmButtonColor: isEdited ? (customBadge && customBadge.includes('MANUEL') ? '#dc2626' : '#f59e0b') : '#16a34a'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Hata',
                    text: data.message || 'Teşhis kaydedilemedi.'
                });
            }
        })
        .catch(err => {
            console.error(err);
            Swal.fire({
                icon: 'error',
                title: 'Hata',
                text: 'Sunucu ile iletişim kurulurken bir sorun oluştu.'
            });
        });
    }

    function editDoctorDiagnosis() {
        const currentDiag = document.getElementById('diagnosis') ? document.getElementById('diagnosis').value : 'I10 - Essansiyel Hipertansiyon';

        Swal.fire({
            title: 'Teşhisi İstediğiniz Gibi Düzenleyin',
            html: `
                <div class="text-start small mb-3">
                    <p class="text-muted mb-2"><i class="bi bi-pencil-square text-warning me-1"></i> Teşhisin ICD-10 kodunu, tanı açıklamasını veya istediğiniz herhangi bir kısmını değiştirebilirsiniz:</p>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark mb-1">Teşhis Metni (İstediğiniz Kısmına Erişin & Düzenleyin)</label>
                        <input type="text" id="edit_diag_input" class="form-control form-control-sm font-monospace fw-bold" value="${currentDiag}">
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-semibold text-dark mb-1">Ek Klinik Hekim Notu</label>
                        <textarea id="edit_diag_notes" class="form-control form-control-sm" rows="2" placeholder="Örn: Muayene bulguları doğrultusunda teşhis güncellendi."></textarea>
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: '<i class="bi bi-save me-1"></i> Düzenlemeyi Kaydet & Dosyaya Aktar',
            cancelButtonText: 'İptal',
            confirmButtonColor: '#f59e0b',
            focusConfirm: false,
            preConfirm: () => {
                const diag = document.getElementById('edit_diag_input').value;
                const notes = document.getElementById('edit_diag_notes').value;
                if (!diag || !diag.trim()) {
                    Swal.showValidationMessage('Teşhis alanı boş bırakılamaz!');
                    return false;
                }
                return { diagnosis: diag.trim(), notes: notes ? notes.trim() : '' };
            }
        }).then((result) => {
            if (result.isConfirmed && result.value) {
                acceptAiRecommendation(result.value.diagnosis, true, 'HEKİM DÜZENLEMESİ', result.value.notes);
            }
        });
    }

    function rejectAndManualDiagnosis() {
        Swal.fire({
            title: 'AI Önerisini Reddet & Manuel Teşhis Yaz',
            html: `
                <div class="text-start small mb-3">
                    <p class="text-danger fw-bold mb-2"><i class="bi bi-x-circle me-1"></i> AI önerisi reddedildi. Lütfen hastanın teşhisini tam olarak kendiniz yazınız:</p>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark mb-1">Manuel Teşhis / ICD-10 Kodu ve Tanı Adı (*)</label>
                        <input type="text" id="manual_diag_input" class="form-control form-control-sm fw-bold" placeholder="Örn: J45.0 - Alerjik Astım & Akut Bronşit" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-semibold text-dark mb-1">Hekim Özel Muayene Notu</label>
                        <textarea id="manual_diag_notes" class="form-control form-control-sm" rows="2" placeholder="Örn: AI tanısı reddedildi, fizik muayene ve radyoloji bulgularına göre hekim tarafından manuel tanı konuldu."></textarea>
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: '<i class="bi bi-check-circle me-1"></i> Teşhisi Kaydet & Rapor Taslağına Aktar',
            cancelButtonText: 'İptal',
            confirmButtonColor: '#dc2626',
            focusConfirm: false,
            preConfirm: () => {
                const diag = document.getElementById('manual_diag_input').value;
                const notes = document.getElementById('manual_diag_notes').value;
                if (!diag || !diag.trim()) {
                    Swal.showValidationMessage('Lütfen geçerli bir teşhis tanısı yazınız!');
                    return false;
                }
                return { diagnosis: diag.trim(), notes: notes ? notes.trim() : '' };
            }
        }).then((result) => {
            if (result.isConfirmed && result.value) {
                acceptAiRecommendation(result.value.diagnosis, true, 'MANUEL HEKİM YAZIMI', result.value.notes);
            }
        });
    }

    function submitDoctorFeedback(action) {
        if (action === 'kabul') {
            acceptAiRecommendation();
            return;
        } else if (action === 'duzenle') {
            editDoctorDiagnosis();
            return;
        } else if (action === 'red') {
            rejectAndManualDiagnosis();
            return;
        }
    }

    // ICD-10 TÜM HASTALIK KODLARI KATALOĞU VE MANUEL HEKİM SEÇİM MANTIĞI
    let allIcd10CodesCache = [];
    let currentCategoryPrefix = '';

    function loadAllIcd10Codes() {
        const tbody = document.getElementById('icd10ModalTableBody');
        const badge = document.getElementById('icd10TotalCountBadge');

        if (allIcd10CodesCache.length > 0) {
            renderIcd10ModalTable(allIcd10CodesCache);
            return;
        }

        if (tbody) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="4" class="text-center py-5 text-muted">
                        <div class="spinner-border text-success mb-2" role="status"></div>
                        <div>T.C. Sağlık Bakanlığı ICD-10 Kataloğu Yükleniyor...</div>
                    </td>
                </tr>`;
        }

        fetch("{{ route('medical_report.icd10_search') }}")
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success' && data.data) {
                    allIcd10CodesCache = data.data;
                    renderIcd10ModalTable(allIcd10CodesCache);
                } else {
                    if (tbody) tbody.innerHTML = `<tr><td colspan="4" class="text-center py-4 text-danger">Katalog verileri yüklenirken bir sorun oluştu.</td></tr>`;
                }
            })
            .catch(err => {
                console.error("ICD-10 fetch error:", err);
                if (tbody) tbody.innerHTML = `<tr><td colspan="4" class="text-center py-4 text-danger">Bağlantı hatası: ICD-10 kodları yüklenemedi.</td></tr>`;
            });
    }

    function renderIcd10ModalTable(items) {
        const tbody = document.getElementById('icd10ModalTableBody');
        const badge = document.getElementById('icd10TotalCountBadge');
        if (!tbody) return;

        if (badge) badge.innerHTML = `<i class="bi bi-list-check me-1"></i> Toplam: <strong>${items.length}</strong> Tanı Kodu`;

        if (!items || items.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="4" class="text-center py-4 text-muted">
                        <i class="bi bi-exclamation-triangle fs-4 d-block mb-1 text-warning"></i>
                        Arama veya kategori kriterine uygun ICD-10 tanı kodu bulunamadı.
                    </td>
                </tr>`;
            return;
        }

        let html = '';
        items.forEach(item => {
            let drugsPreview = '';
            if (item.recommended_drugs && item.recommended_drugs.length > 0) {
                drugsPreview = item.recommended_drugs.map(d => `<span class="badge bg-warning-subtle text-dark border border-warning-subtle me-1 mb-1" style="font-size:0.7rem;"><i class="bi bi-capsule me-1 text-warning"></i>${d.name}</span>`).join('');
            } else {
                drugsPreview = '<span class="text-muted small">Semptomatik / Özel İlaç Yok</span>';
            }

            const drugsJsonEscaped = JSON.stringify(item.recommended_drugs || []).replace(/'/g, "&apos;").replace(/"/g, "&quot;");

            html += `
                <tr>
                    <td class="ps-3">
                        <span class="badge bg-success-subtle text-success font-monospace fs-6 px-2.5 py-1.5 border border-success-subtle fw-bold">${item.code}</span>
                    </td>
                    <td>
                        <strong class="text-dark d-block mb-0.5">${item.description}</strong>
                    </td>
                    <td>
                        <div class="d-flex flex-wrap align-items-center">${drugsPreview}</div>
                    </td>
                    <td class="text-end pe-3">
                        <button type="button" class="btn btn-success btn-sm fw-bold py-1 px-2.5 shadow-xs" onclick="applyIcd10FromModal('${item.code}', '${item.description.replace(/'/g, "\\'")}', '${drugsJsonEscaped}')">
                            <i class="bi bi-check2-circle me-1"></i> Teşhise Aktar
                        </button>
                    </td>
                </tr>`;
        });

        tbody.innerHTML = html;
    }

    function filterIcd10ModalList() {
        const query = (document.getElementById('icd10ModalSearchInput')?.value || '').trim().toLowerCase();
        let filtered = allIcd10CodesCache;

        if (currentCategoryPrefix) {
            filtered = filtered.filter(i => i.code.toUpperCase().startsWith(currentCategoryPrefix));
        }

        if (query) {
            filtered = filtered.filter(i => 
                i.code.toLowerCase().includes(query) || 
                i.description.toLowerCase().includes(query)
            );
        }

        renderIcd10ModalTable(filtered);
    }

    function filterIcd10Category(prefix, btnEl) {
        currentCategoryPrefix = prefix;
        document.querySelectorAll('.icd-cat-btn').forEach(b => {
            b.classList.remove('btn-dark', 'active');
            b.classList.add('btn-outline-secondary');
        });
        if (btnEl) {
            btnEl.classList.remove('btn-outline-secondary');
            btnEl.classList.add('btn-dark', 'active');
        }
        filterIcd10ModalList();
    }

    function applyIcd10FromModal(code, description, drugsJsonStr) {
        const fullDiagnosisText = `${code} - ${description}`;
        
        if (document.getElementById('ai_diagnosis_input')) {
            document.getElementById('ai_diagnosis_input').value = fullDiagnosisText;
        }
        if (document.getElementById('diagnosis')) {
            document.getElementById('diagnosis').value = fullDiagnosisText;
        }

        try {
            let drugs = JSON.parse(drugsJsonStr.replace(/&quot;/g, '"').replace(/&apos;/g, "'"));
            if (drugs && drugs.length > 0 && document.getElementById('ai_treatment_input')) {
                let rxText = drugs.map(m => m.name + ' (' + m.dosage + ' - ' + m.frequency + ') - ' + (m.purpose || '')).join('\n');
                document.getElementById('ai_treatment_input').value = rxText;
            }
        } catch (e) {
            console.error("Drugs parse error:", e);
        }

        const modalEl = document.getElementById('icd10BrowserModal');
        if (modalEl) {
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            if (modalInstance) modalInstance.hide();
        }

        Swal.fire({
            icon: 'success',
            title: 'Teşhis ve Reçete Aktarıldı!',
            html: `<strong>${fullDiagnosisText}</strong> tanısı ve önerilen ilaçlar 2. Teşhis ve 3. Reçete kartlarına aktarıldı.`,
            timer: 2000,
            showConfirmButton: false
        });
    }

    // ICD-10 CANLI ARAMA VE AUTOCOMPLETE YARDIMCISI
    function initIcd10LiveSearch(inputId, containerId) {
        const inputEl = document.getElementById(inputId);
        const containerEl = document.getElementById(containerId);
        if (!inputEl || !containerEl) return;

        let activeIndex = -1;

        function trNormalize(str) {
            if (!str) return '';
            return str
                .replace(/İ/g, 'i')
                .replace(/I/g, 'ı')
                .replace(/Ğ/g, 'ğ')
                .replace(/Ü/g, 'ü')
                .replace(/Ş/g, 'ş')
                .replace(/Ö/g, 'ö')
                .replace(/Ç/g, 'ç')
                .toLowerCase()
                .trim();
        }

        function fetchCatalogIfNeeded(callback) {
            if (allIcd10CodesCache && allIcd10CodesCache.length > 0) {
                if (callback) callback();
                return;
            }
            fetch("{{ route('medical_report.icd10_search') }}")
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success' && data.data) {
                        allIcd10CodesCache = data.data;
                    }
                    if (callback) callback();
                })
                .catch(err => console.error("ICD-10 search error:", err));
        }

        function renderResults(query) {
            const normQuery = trNormalize(query);
            if (!normQuery || normQuery.length < 1) {
                containerEl.style.display = 'none';
                containerEl.innerHTML = '';
                return;
            }

            const matches = (allIcd10CodesCache || []).filter(item => {
                const codeNorm = trNormalize(item.code);
                const descNorm = trNormalize(item.description);
                return codeNorm.includes(normQuery) || descNorm.includes(normQuery);
            }).slice(0, 15);

            if (matches.length === 0) {
                containerEl.innerHTML = `
                    <div class="p-3 text-center text-muted small">
                        <i class="bi bi-search text-warning fs-5 d-block mb-1"></i>
                        "<strong>${query}</strong>" için ICD-10 tanı kodu bulunamadı.
                    </div>`;
                containerEl.style.display = 'block';
                return;
            }

            let html = '<div class="list-group list-group-flush small" style="font-size:0.82rem;">';
            matches.forEach((item, idx) => {
                const fullText = `${item.code} - ${item.description}`;
                const drugsCount = item.recommended_drugs ? item.recommended_drugs.length : 0;
                const drugsBadge = drugsCount > 0 ? `<span class="badge bg-warning-subtle text-dark border ms-1" style="font-size:0.65rem;"><i class="bi bi-capsule me-0.5"></i>${drugsCount} İlaç</span>` : '';

                html += `
                    <button type="button" class="list-group-item list-group-item-action py-2 px-3 border-bottom d-flex align-items-center justify-content-between icd-auto-item text-start" data-fulltext="${fullText.replace(/"/g, '&quot;')}" data-code="${item.code}" data-index="${idx}">
                        <div>
                            <span class="badge bg-success-subtle text-success font-monospace fw-bold me-2 px-2 py-1 border border-success-subtle" style="font-size:0.75rem;">${item.code}</span>
                            <strong class="text-dark">${item.description}</strong>
                            ${drugsBadge}
                        </div>
                        <span class="badge bg-light text-muted border ms-2 py-1 px-2" style="font-size:0.68rem;"><i class="bi bi-check2 me-0.5"></i>Seç</span>
                    </button>`;
            });
            html += '</div>';
            containerEl.innerHTML = html;
            containerEl.style.display = 'block';
            activeIndex = -1;

            containerEl.querySelectorAll('.icd-auto-item').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    selectItem(this.getAttribute('data-fulltext'));
                });
            });
        }

        function selectItem(fullText) {
            inputEl.value = fullText;
            if (document.getElementById('diagnosis')) document.getElementById('diagnosis').value = fullText;
            if (document.getElementById('ai_diagnosis_input')) document.getElementById('ai_diagnosis_input').value = fullText;
            containerEl.style.display = 'none';

            inputEl.classList.add('is-valid');
            setTimeout(() => inputEl.classList.remove('is-valid'), 1500);
        }

        inputEl.addEventListener('focus', function() {
            fetchCatalogIfNeeded(() => {
                if (inputEl.value.trim().length >= 1) {
                    renderResults(inputEl.value);
                }
            });
        });

        inputEl.addEventListener('input', function() {
            fetchCatalogIfNeeded(() => {
                renderResults(inputEl.value);
            });
        });

        inputEl.addEventListener('keydown', function(e) {
            const items = containerEl.querySelectorAll('.icd-auto-item');
            if (!items || items.length === 0 || containerEl.style.display === 'none') return;

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                activeIndex = (activeIndex + 1) % items.length;
                updateHighlight(items);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                activeIndex = (activeIndex - 1 + items.length) % items.length;
                updateHighlight(items);
            } else if (e.key === 'Enter' && activeIndex >= 0) {
                e.preventDefault();
                items[activeIndex].click();
            } else if (e.key === 'Escape') {
                containerEl.style.display = 'none';
            }
        });

        function updateHighlight(items) {
            items.forEach((item, idx) => {
                if (idx === activeIndex) {
                    item.classList.add('active', 'bg-success-subtle', 'text-dark');
                    item.scrollIntoView({ block: 'nearest' });
                } else {
                    item.classList.remove('active', 'bg-success-subtle', 'text-dark');
                }
            });
        }

        document.addEventListener('click', function(e) {
            if (!inputEl.contains(e.target) && !containerEl.contains(e.target)) {
                containerEl.style.display = 'none';
            }
        });
    }

<!-- YAPAY ZEKÂ TIBBİ DOSYA & LAB ANALİZ MODALI (Temiz, Yalın & HBYS Genel Tasarımıyla Uyumlu) -->
<div class="modal fade" id="chiefAiLabModal" tabindex="-1" aria-labelledby="chiefAiLabModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header bg-white border-bottom px-4 py-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="p-2 bg-indigo-soft rounded-circle text-indigo">
                        <i class="bi bi-cpu-fill fs-5"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-dark mb-0" id="chiefAiLabModalLabel">
                            Yapay Zekâ Lab Analizi & Risk Tahmini
                        </h5>
                        <small class="text-muted" id="modal-patient-name">Hasta Tıbbi LIS Taraması & Değerlendirme</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
            </div>

            <div class="modal-body p-4 bg-light">
                <!-- Yükleniyor Göstergesi -->
                <div id="chief-ai-lab-loading" class="text-center py-5">
                    <div class="spinner-border text-primary mb-3" role="status"></div>
                    <h6 class="fw-bold text-dark mb-1">Yapay Zekâ Lab Verilerini Taramakta...</h6>
                    <p class="small text-muted mb-0">Teşhis tahminleri, gelecek riskler ve düzeltme önerileri hazırlanıyor.</p>
                </div>

                <!-- Analiz Sonuçları İçeriği -->
                <div id="chief-ai-lab-content" style="display: none;">

                    <!-- 1. Olası Teşhisler -->
                    <div class="card-clean p-3.5 mb-3 bg-white">
                        <div class="d-flex justify-content-between align-items-center mb-2.5 pb-2 border-bottom">
                            <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                                <i class="bi bi-activity text-primary"></i> Mevcut Olası Teşhisler
                            </h6>
                            <span class="badge bg-indigo-soft" id="c-count-diagnoses">0 Teşhis</span>
                        </div>
                        <div id="c-container-diagnoses" class="d-flex flex-column gap-2"></div>
                    </div>

                    <!-- 2. Gelecek Riskler -->
                    <div class="card-clean p-3.5 mb-3 bg-white">
                        <div class="d-flex justify-content-between align-items-center mb-2.5 pb-2 border-bottom">
                            <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                                <i class="bi bi-exclamation-triangle-fill text-warning"></i> Gelecekte Oluşabilecek Riskler (1-5 Yıl)
                            </h6>
                            <span class="badge bg-rose-soft">Komplikasyon Projeksiyonu</span>
                        </div>
                        <div id="c-container-risks" class="d-flex flex-column gap-2"></div>
                    </div>

                    <!-- 3. İyileştirme Önerileri -->
                    <div class="card-clean p-3.5 bg-white">
                        <div class="d-flex justify-content-between align-items-center mb-2.5 pb-2 border-bottom">
                            <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                                <i class="bi bi-check-circle-fill text-success"></i> Değerleri Düzeltme & Klinik Öneriler
                            </h6>
                            <span class="badge bg-emerald-soft">Aksiyon Planı</span>
                        </div>

                        <div class="mb-3">
                            <div class="fw-semibold text-indigo small mb-1.5"><i class="bi bi-capsule me-1"></i> Medikal / Reçete Revizyonu:</div>
                            <div id="c-container-med-recs" class="small text-secondary ps-2"></div>
                        </div>

                        <div class="mb-3">
                            <div class="fw-semibold text-amber small mb-1.5" style="color:#b45309;"><i class="bi bi-apple me-1"></i> Beslenme & Yaşam Tarzı:</div>
                            <div id="c-container-lifestyle-recs" class="small text-secondary ps-2"></div>
                        </div>

                        <div>
                            <div class="fw-semibold text-teal small mb-1.5" style="color:#0d9488;"><i class="bi bi-calendar-event me-1"></i> Takip & İleri Tetkik:</div>
                            <div id="c-container-followup-recs" class="small text-secondary ps-2"></div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-footer bg-white px-4 py-2.5 d-flex justify-content-between border-top">
                <button type="button" class="btn btn-outline-success btn-sm rounded-pill px-3 fw-semibold" onclick="copyChiefAiLabToReport()">
                    <i class="bi bi-file-earmark-plus me-1"></i> 📋 Rapora Aktar
                </button>
                <button type="button" class="btn btn-secondary btn-sm rounded-pill px-3" data-bs-dismiss="modal">Kapat</button>
            </div>
        </div>
    </div>
</div>
@endpush
