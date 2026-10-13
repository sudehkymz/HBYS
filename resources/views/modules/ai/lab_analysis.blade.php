@extends('layouts.app')

@section('title', 'Yapay Zekâ Tıbbi Dosya & Lab Analiz Portalı')

@push('styles')
<style>
    .ai-lab-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 40%, #312e81 100%);
        color: white; padding: 1.75rem 2rem; border-radius: 16px;
        box-shadow: 0 10px 25px -5px rgba(30, 27, 75, 0.3);
        border-bottom: 4px solid #6366f1;
    }
    .card-custom {
        background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.03); transition: all 0.25s ease;
    }
    .card-custom:hover { box-shadow: 0 8px 24px rgba(15, 23, 42, 0.07); }

    .ai-badge-soft { font-size: 0.75rem; padding: 0.35rem 0.75rem; border-radius: 20px; font-weight: 600; }
    .badge-primary-soft { background: #e0e7ff; color: #3730a3; }
    .badge-danger-soft { background: #ffe4e6; color: #9f1239; }
    .badge-warning-soft { background: #fef3c7; color: #92400e; }
    .badge-success-soft { background: #dcfce7; color: #166534; }
    .badge-info-soft { background: #e0f2fe; color: #075985; }

    .lab-table-row { transition: background-color 0.2s ease; }
    .lab-table-row:hover { background-color: #f8fafc; }

    .diagnosis-card {
        border-left: 5px solid #6366f1; background: #ffffff;
        border-radius: 12px; transition: transform 0.2s ease;
    }
    .diagnosis-card.critical { border-left-color: #ef4444; background: #fff5f5; }
    .diagnosis-card.high { border-left-color: #f59e0b; background: #fffbf0; }
    .diagnosis-card.medium { border-left-color: #06b6d4; background: #f0fdf4; }

    .risk-card {
        border-radius: 12px; background: #ffffff; border: 1px solid #cbd5e1;
        transition: all 0.2s ease;
    }
    .risk-card:hover { transform: translateY(-3px); }

    .rec-box {
        border-radius: 12px; padding: 1.25rem; margin-bottom: 1rem;
        background: #f8fafc; border: 1px solid #e2e8f0;
    }

    .progress-bar-glow {
        box-shadow: 0 0 10px rgba(99, 102, 241, 0.4);
    }
</style>
@endpush

@section('content')

    <!-- Üst Başlık Kartı -->
    <header class="ai-lab-header mb-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h3 class="fw-bold mb-1 d-flex align-items-center gap-2">
                    <i class="bi bi-flask-florence text-warning fs-3"></i> Yapay Zekâ Tıbbi Dosya & Lab Analiz Portalı
                </h3>
                <p class="mb-0 text-light opacity-75 small">
                    Laboratuvar Veri Taraması • Mevcut Olası Teşhis Tahmini • Gelecek Komplikasyon Projeksiyonu • İyileştirme Önerileri
                </p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-teal text-white px-3 py-2 rounded-pill font-monospace" style="background:#0d9488;">
                    <i class="bi bi-shield-check me-1"></i>KVKK Veri Maskeleme Aktif
                </span>
                <span class="badge bg-indigo-soft px-3 py-2 rounded-pill font-monospace">
                    <i class="bi bi-cpu me-1"></i>AI Confidence: <strong id="header-confidence">%{{ $initialAnalysis['ai_confidence_score'] ?? 92 }}</strong>
                </span>
            </div>
        </div>
    </header>

    <div class="row g-4">
        <!-- SOL KOLON: Hasta Seçimi & Parametrik Lab Verileri Taraması -->
        <div class="col-lg-5">
            <!-- Hasta Seçici -->
            <div class="card-custom p-4 mb-4">
                <h5 class="fw-bold text-dark mb-3">
                    <i class="bi bi-person-bounding-box text-primary me-2"></i>Tıbbi Dosyası Taranacak Hasta
                </h5>
                <select id="select-patient" class="form-select form-select-lg fw-bold border-primary text-dark mb-3" onchange="loadPatientAnalysis(this.value)">
                    <option value="1" {{ ($patientId ?? 1) == 1 ? 'selected' : '' }}>Hasta #1: Ahmet Yılmaz (41Y, Erkek - Hipertansiyon & Diyabet)</option>
                    <option value="2" {{ ($patientId ?? 1) == 2 ? 'selected' : '' }}>Hasta #2: Ayşe Demir (34Y, Kadın - Gebelik 24.Hafta & Anemi)</option>
                    <option value="3" {{ ($patientId ?? 1) == 3 ? 'selected' : '' }}>Hasta #3: Mehmet Kaya (68Y, Erkek - KOAH & Kalp Yetmezliği)</option>
                </select>

                <div class="p-3 bg-light rounded-3 border">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">Ad Soyad / T.C.:</span>
                        <strong class="text-dark small" id="p-name">{{ $patient['first_name'] ?? 'Ahmet' }} {{ $patient['last_name'] ?? 'Yılmaz' }} ({{ $patient['national_id'] ?? '' }})</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">Cinsiyet / Doğum Tarihi:</span>
                        <span class="small fw-semibold text-dark" id="p-gender-dob">{{ $patient['gender'] ?? 'Erkek' }} ({{ $patient['birth_date'] ?? '' }})</span>
                    </div>
                    <div class="d-flex flex-wrap gap-1 mt-2" id="p-chronic-tags">
                        @foreach(($patient['chronic_diseases'] ?? []) as $disease)
                            <span class="badge bg-danger-soft">{{ $disease }}</span>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Taranan Laboratuvar Verileri Çizelgesi -->
            <div class="card-custom p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="bi bi-list-check text-primary me-2"></i>Taranan Lab Sonuçları
                    </h5>
                    <button class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="openAddLabModal()">
                        <i class="bi bi-plus-circle me-1"></i>Simüle Lab Değeri Ekle
                    </button>
                </div>

                <div class="table-responsive" style="max-height: 380px; overflow-y: auto;">
                    <table class="table table-hover align-middle small mb-0">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th>Test Adı</th>
                                <th>Sonuç</th>
                                <th>Referans</th>
                                <th>Durum</th>
                            </tr>
                        </thead>
                        <tbody id="scanned-labs-tbody">
                            @foreach(($initialAnalysis['scanned_lab_results'] ?? []) as $lab)
                                <tr class="lab-table-row">
                                    <td class="fw-semibold text-dark">{{ $lab['name'] }}</td>
                                    <td><strong class="{{ $lab['status_code'] !== 'normal' ? 'text-danger' : 'text-success' }}">{{ $lab['value'] }} {{ $lab['unit'] }}</strong></td>
                                    <td class="text-muted">{{ $lab['reference'] }}</td>
                                    <td>
                                        <span class="badge {{ $lab['badge_class'] }}">{{ $lab['status_label'] }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <button id="btn-run-analysis" class="btn btn-primary btn-lg w-100 rounded-pill shadow-sm fw-bold d-flex align-items-center justify-content-center gap-2" onclick="runFullAiAnalysis()">
                        <i class="bi bi-cpu-fill fs-5"></i>
                        <span>⚡ Yapay Zekâ Tıbbi Dosya Analizini Başlat</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- SAĞ KOLON: 3 BOYUTLU YAPAY ZEKÂ ANALİZİ & ÖNERİLER -->
        <div class="col-lg-7">

            <!-- Sekme Navigasyonu -->
            <ul class="nav nav-pills nav-fill mb-3 bg-white p-2 rounded-3 border card-custom" id="ai-analysis-tabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active fw-bold text-indigo" id="tab-diagnoses-btn" data-bs-toggle="tab" data-bs-target="#tab-diagnoses" type="button">
                        <i class="bi bi-search me-1"></i>1. Olası Mevcut Hastalıklar
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link fw-bold text-danger" id="tab-risks-btn" data-bs-toggle="tab" data-bs-target="#tab-risks" type="button">
                        <i class="bi bi-crystal-ball me-1"></i>2. Gelecek Hastalık Riskleri
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link fw-bold text-success" id="tab-recs-btn" data-bs-toggle="tab" data-bs-target="#tab-recs" type="button">
                        <i class="bi bi-shield-plus me-1"></i>3. Düzeltme Önerileri
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="ai-analysis-tab-content">

                <!-- BOYUT 1: MEVCUT OLASI HASTALIKLAR (TEŞHİSLER) -->
                <div class="tab-pane fade show active" id="tab-diagnoses" role="tabpanel">
                    <div class="card-custom p-4 mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold text-dark mb-0">
                                <i class="bi bi-activity text-primary me-2"></i>Yapay Zekâ Teşhis ve Hastalık Tahminleri
                            </h5>
                            <span class="badge badge-primary-soft" id="count-diagnoses">{{ count($initialAnalysis['current_diagnoses'] ?? []) }} Olası Teşhis</span>
                        </div>

                        <div id="container-diagnoses">
                            @foreach(($initialAnalysis['current_diagnoses'] ?? []) as $diag)
                                <div class="card p-3 mb-3 diagnosis-card {{ $diag['severity'] }} border-0 shadow-sm">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="fw-bold text-dark mb-0">
                                            <span class="badge bg-secondary font-monospace me-2">{{ $diag['icd10'] }}</span>
                                            {{ $diag['disease'] }}
                                        </h6>
                                        <span class="badge bg-indigo-soft fs-6">{{ $diag['severity_label'] }}</span>
                                    </div>

                                    <!-- Olasılık İlerleme Çubuğu -->
                                    <div class="mb-2">
                                        <div class="d-flex justify-content-between small fw-bold mb-1">
                                            <span class="text-muted">AI Teşhis Olasılığı:</span>
                                            <span class="text-primary">%{{ $diag['probability'] }}</span>
                                        </div>
                                        <div class="progress" style="height: 10px; border-radius: 6px;">
                                            <div class="progress-bar bg-indigo progress-bar-glow" style="width: {{ $diag['probability'] }}%; background-color: #6366f1;"></div>
                                        </div>
                                    </div>

                                    <p class="small text-secondary mb-2">{{ $diag['clinical_summary'] }}</p>

                                    <div class="d-flex align-items-center gap-1 flex-wrap">
                                        <span class="small text-muted me-1">Dayanak Lab Verileri:</span>
                                        @foreach(($diag['supporting_labs'] ?? []) as $slab)
                                            <span class="badge bg-light text-dark border">{{ $slab }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- BOYUT 2: GELECEKTE OLUŞABİLECEK HASTALIKLAR VE RİSKLER (PROJ EKSİYON) -->
                <div class="tab-pane fade" id="tab-risks" role="tabpanel">
                    <div class="card-custom p-4 mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h5 class="fw-bold text-dark mb-1">
                                    <i class="bi bi-exclamation-octagon-fill text-danger me-2"></i>Gelecekte Oluşabilecek Hastalık & Komplikasyon Riskleri
                                </h5>
                                <p class="text-muted small mb-0">Lab değerleri bu şekilde devam ederse organ sistemlerinde gelişebilecek 1-5 yıllık patolojiler</p>
                            </div>
                        </div>

                        <div id="container-future-risks">
                            @foreach(($initialAnalysis['future_risks'] ?? []) as $risk)
                                <div class="risk-card p-3 mb-3 border-start border-4 border-danger">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="fw-bold text-dark mb-1">{{ $risk['condition'] }}</h6>
                                            <span class="badge {{ $risk['badge_class'] }} rounded-pill me-2">{{ $risk['timeline'] }}</span>
                                            <span class="badge bg-light text-dark border"><i class="bi bi-heart-pulse me-1"></i>{{ $risk['impact_organ'] }}</span>
                                        </div>
                                        <div class="text-end">
                                            <div class="fs-5 fw-bold text-danger">%{{ $risk['risk_score'] }}</div>
                                            <small class="text-muted" style="font-size:0.7rem;">Risk Skoru</small>
                                        </div>
                                    </div>
                                    <p class="small text-secondary mb-0">{{ $risk['description'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- BOYUT 3: DEĞERLERİ DÜZELTME & KLİNİK İYİLEŞTİRME ÖNERİLERİ -->
                <div class="tab-pane fade" id="tab-recs" role="tabpanel">
                    <div class="card-custom p-4 mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold text-dark mb-0">
                                <i class="bi bi-heart-pulse-fill text-success me-2"></i>Değerleri Düzeltme & Klinik İyileştirme Önerileri
                            </h5>
                            <button class="btn btn-sm btn-outline-success rounded-pill px-3" onclick="copyAiSummaryText()">
                                <i class="bi bi-clipboard me-1"></i>Epikriz / Nota Kopyala
                            </button>
                        </div>

                        <!-- A) Medikal Tedavi & İlaç Revizyon Önerileri -->
                        <div class="mb-4">
                            <h6 class="fw-bold text-indigo mb-2 border-bottom pb-1">
                                <i class="bi bi-capsule me-1"></i> A) Medikal Tedavi & Reçete Revizyon Önerileri
                            </h6>
                            <div id="container-med-recs">
                                @foreach(($initialAnalysis['improvement_recommendations']['medical_adjustments'] ?? []) as $med)
                                    <div class="rec-box border-start border-4 border-indigo">
                                        <strong class="text-dark d-block mb-1"><i class="bi bi-check-circle-fill text-indigo me-1"></i>{{ $med['title'] }}</strong>
                                        <p class="small text-secondary mb-0">{{ $med['detail'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- B) Beslenme & Yaşam Tarzı Tavsiyeleri -->
                        <div class="mb-4">
                            <h6 class="fw-bold text-amber mb-2 border-bottom pb-1" style="color:#b45309;">
                                <i class="bi bi-apple me-1"></i> B) Beslenme & Yaşam Tarzı Tavsiyeleri
                            </h6>
                            <div id="container-lifestyle-recs">
                                @foreach(($initialAnalysis['improvement_recommendations']['lifestyle_and_nutrition'] ?? []) as $life)
                                    <div class="rec-box border-start border-4 border-warning">
                                        <strong class="text-dark d-block mb-1"><i class="bi bi-egg-fried text-warning me-1"></i>{{ $life['title'] }}</strong>
                                        <p class="small text-secondary mb-0">{{ $life['detail'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- C) Takip & İleri Tetkik Takvimi -->
                        <div>
                            <h6 class="fw-bold text-teal mb-2 border-bottom pb-1" style="color:#0d9488;">
                                <i class="bi bi-calendar-event me-1"></i> C) Takip & İleri Tetkik Takvimi
                            </h6>
                            <div id="container-followup-recs">
                                @foreach(($initialAnalysis['improvement_recommendations']['followup_schedule'] ?? []) as $fol)
                                    <div class="rec-box border-start border-4 border-info">
                                        <strong class="text-dark d-block mb-1"><i class="bi bi-clock-history text-info me-1"></i>{{ $fol['title'] }}</strong>
                                        <p class="small text-secondary mb-0">{{ $fol['detail'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- SİMÜLE LAB DEĞERİ EKLEME MODALI -->
    <div class="modal fade" id="addLabModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header bg-primary text-white rounded-top-4">
                    <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle me-2"></i>Simüle Lab Değeri Ekle</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Test Adı:</label>
                        <input type="text" id="new-lab-name" class="form-control" placeholder="Örn: HbA1c, LDL Kolesterol, Kreatinin, BNP...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Sonuç Değeri:</label>
                        <input type="text" id="new-lab-value" class="form-control" placeholder="Örn: 8.4, 155, 1.8...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Birim:</label>
                        <input type="text" id="new-lab-unit" class="form-control" placeholder="Örn: %, mg/dL, pg/mL...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Referans Aralığı:</label>
                        <input type="text" id="new-lab-ref" class="form-control" placeholder="Örn: 4.0 - 6.0, < 100...">
                    </div>
                </div>
                <div class="modal-footer bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">İptal</button>
                    <button type="button" class="btn btn-primary rounded-pill px-4 fw-bold" onclick="saveCustomLabItem()">Ekle & Analiz Et</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    let currentCustomLabs = [];

    function loadPatientAnalysis(patientId) {
        currentCustomLabs = [];
        window.location.href = "{{ route('ai.lab_analysis.index') }}?patient_id=" + patientId;
    }

    function runFullAiAnalysis() {
        const patientId = document.getElementById('select-patient').value;
        const btn = document.getElementById('btn-run-analysis');
        const origText = btn.innerHTML;

        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Yapay Zekâ Dosyayı Tarıyor...';

        fetch("{{ route('ai.lab_analysis.analyze') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                patient_id: patientId,
                custom_labs: currentCustomLabs
            })
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            btn.innerHTML = origText;
            renderAiAnalysisResults(data);

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'Yapay Zekâ Analizi Tamamlandı',
                    text: data.scanned_labs_count + ' laboratuvar parametresi tarandı. Olası teşhisler ve gelecek riskler güncellendi.',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        })
        .catch(err => {
            btn.disabled = false;
            btn.innerHTML = origText;
            console.error(err);
        });
    }

    function renderAiAnalysisResults(data) {
        if (!data) return;

        // Confidence score
        document.getElementById('header-confidence').textContent = '%' + (data.ai_confidence_score || 92);

        // 1. Taranmış Lab Tablosu
        const tbody = document.getElementById('scanned-labs-tbody');
        tbody.innerHTML = '';
        (data.scanned_lab_results || []).forEach(lab => {
            const tr = document.createElement('tr');
            tr.className = 'lab-table-row';
            tr.innerHTML = `
                <td class="fw-semibold text-dark">${lab.name}</td>
                <td><strong class="${lab.status_code !== 'normal' ? 'text-danger' : 'text-success'}">${lab.value} ${lab.unit}</strong></td>
                <td class="text-muted">${lab.reference}</td>
                <td><span class="badge ${lab.badge_class}">${lab.status_label}</span></td>
            `;
            tbody.appendChild(tr);
        });

        // 2. Mevcut Olası Teşhisler
        const diagContainer = document.getElementById('container-diagnoses');
        document.getElementById('count-diagnoses').textContent = (data.current_diagnoses || []).length + ' Olası Teşhis';
        diagContainer.innerHTML = '';
        (data.current_diagnoses || []).forEach(diag => {
            let labsHtml = (diag.supporting_labs || []).map(l => `<span class="badge bg-light text-dark border">${l}</span>`).join(' ');
            const card = document.createElement('div');
            card.className = `card p-3 mb-3 diagnosis-card ${diag.severity} border-0 shadow-sm`;
            card.innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-bold text-dark mb-0">
                        <span class="badge bg-secondary font-monospace me-2">${diag.icd10}</span>
                        ${diag.disease}
                    </h6>
                    <span class="badge bg-indigo-soft fs-6">${diag.severity_label}</span>
                </div>
                <div class="mb-2">
                    <div class="d-flex justify-content-between small fw-bold mb-1">
                        <span class="text-muted">AI Teşhis Olasılığı:</span>
                        <span class="text-primary">%${diag.probability}</span>
                    </div>
                    <div class="progress" style="height: 10px; border-radius: 6px;">
                        <div class="progress-bar bg-indigo progress-bar-glow" style="width: ${diag.probability}%; background-color: #6366f1;"></div>
                    </div>
                </div>
                <p class="small text-secondary mb-2">${diag.clinical_summary}</p>
                <div class="d-flex align-items-center gap-1 flex-wrap">
                    <span class="small text-muted me-1">Dayanak Lab Verileri:</span>
                    ${labsHtml}
                </div>
            `;
            diagContainer.appendChild(card);
        });

        // 3. Gelecek Riskler
        const riskContainer = document.getElementById('container-future-risks');
        riskContainer.innerHTML = '';
        (data.future_risks || []).forEach(risk => {
            const div = document.createElement('div');
            div.className = 'risk-card p-3 mb-3 border-start border-4 border-danger';
            div.innerHTML = `
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <h6 class="fw-bold text-dark mb-1">${risk.condition}</h6>
                        <span class="badge ${risk.badge_class} rounded-pill me-2">${risk.timeline}</span>
                        <span class="badge bg-light text-dark border"><i class="bi bi-heart-pulse me-1"></i>${risk.impact_organ}</span>
                    </div>
                    <div class="text-end">
                        <div class="fs-5 fw-bold text-danger">%${risk.risk_score}</div>
                        <small class="text-muted" style="font-size:0.7rem;">Risk Skoru</small>
                    </div>
                </div>
                <p class="small text-secondary mb-0">${risk.description}</p>
            `;
            riskContainer.appendChild(div);
        });

        // 4. Öneriler
        const recs = data.improvement_recommendations || {};
        
        // Medikal
        const medBox = document.getElementById('container-med-recs');
        medBox.innerHTML = (recs.medical_adjustments || []).map(m => `
            <div class="rec-box border-start border-4 border-indigo">
                <strong class="text-dark d-block mb-1"><i class="bi bi-check-circle-fill text-indigo me-1"></i>${m.title}</strong>
                <p class="small text-secondary mb-0">${m.detail}</p>
            </div>
        `).join('');

        // Yaşam tarzı
        const lifeBox = document.getElementById('container-lifestyle-recs');
        lifeBox.innerHTML = (recs.lifestyle_and_nutrition || []).map(l => `
            <div class="rec-box border-start border-4 border-warning">
                <strong class="text-dark d-block mb-1"><i class="bi bi-egg-fried text-warning me-1"></i>${l.title}</strong>
                <p class="small text-secondary mb-0">${l.detail}</p>
            </div>
        `).join('');

        // Takip
        const folBox = document.getElementById('container-followup-recs');
        folBox.innerHTML = (recs.followup_schedule || []).map(f => `
            <div class="rec-box border-start border-4 border-info">
                <strong class="text-dark d-block mb-1"><i class="bi bi-clock-history text-info me-1"></i>${f.title}</strong>
                <p class="small text-secondary mb-0">${f.detail}</p>
            </div>
        `).join('');
    }

    function openAddLabModal() {
        const modal = new bootstrap.Modal(document.getElementById('addLabModal'));
        modal.show();
    }

    function saveCustomLabItem() {
        const name = document.getElementById('new-lab-name').value.trim();
        const value = document.getElementById('new-lab-value').value.trim();
        const unit = document.getElementById('new-lab-unit').value.trim();
        const ref = document.getElementById('new-lab-ref').value.trim();

        if (!name || !value) {
            alert('Lütfen en az Test Adı ve Sonuç Değerini giriniz.');
            return;
        }

        currentCustomLabs.push({
            test_name: name,
            value: value,
            unit: unit || 'mg/dL',
            reference: ref || '0 - 100',
            date: 'Şimdi'
        });

        const modalEl = document.getElementById('addLabModal');
        const modal = bootstrap.Modal.getInstance(modalEl);
        modal.hide();

        runFullAiAnalysis();
    }

    function copyAiSummaryText() {
        const patientId = document.getElementById('select-patient').value;
        fetch("{{ route('ai.lab_analysis.export_summary') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ patient_id: patientId })
        })
        .then(res => res.json())
        .then(data => {
            if (data.summary_text) {
                navigator.clipboard.writeText(data.summary_text).then(() => {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Epikriz / Rapor Metni Kopyalandı',
                            text: 'Yapay Zekâ lab analiz özeti panoya kopyalandı.',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        alert('Yapay zekâ özeti kopyalandı!');
                    }
                });
            }
        });
    }
</script>
@endpush
