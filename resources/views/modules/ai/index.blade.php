@extends('layouts.app')

@section('title', 'Yapay Zekâ Klinik Karar Asistanı')

@push('styles')
<style>
    .ai-header {
        background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%);
        color: white; padding: 1.5rem; border-radius: 12px; border-bottom: 4px solid #6366f1;
    }
    .card-ai { border: none; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
    .badge-kvkk { background-color: #0d9488; color: white; font-size: 0.75rem; padding: 0.35em 0.65em; border-radius: 6px; }
    .ai-box {
        background-color: #f8fafc; border-left: 4px solid #6366f1; padding: 1.25rem;
        border-radius: 8px; font-size: 0.95rem; line-height: 1.6; white-space: pre-line;
        transition: all 0.3s ease;
    }
    .confidence-pill {
        background: #e0e7ff; color: #3730a3; font-weight: 600; padding: 0.35rem 0.85rem;
        border-radius: 20px; font-size: 0.85rem; display: inline-flex; align-items: center;
    }
    .btn-ai-action {
        transition: all 0.2s ease-in-out; border-radius: 8px; font-weight: 500; text-align: left; padding: 0.75rem 1rem;
    }
    .btn-ai-action:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(99, 102, 241, 0.15); }
    .btn-ai-action.active { background-color: #6366f1 !important; color: white !important; border-color: #6366f1 !important; }
    .doctor-approval-card { background: #ffffff; border: 2px dashed #a5b4fc; border-radius: 10px; padding: 1.25rem; }
</style>
@endpush

@section('content')

    <header class="ai-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="fw-bold mb-1"><i class="bi bi-cpu-fill me-2"></i>Yapay Zekâ Destekli Klinik Karar Asistanı</h3>
                <p class="mb-0 text-light opacity-75">AI Gateway Pipeline, Klinik Protokol Rehberleri & Hekim Karar Desteği</p>
            </div>
            <div>
                <span class="badge badge-kvkk"><i class="bi bi-shield-lock-fill me-1"></i>KVKK Veri Maskeleme Aktif</span>
                <span class="badge bg-warning text-dark ms-2"><i class="bi bi-person-check-fill me-1"></i>Doktor Onayı Zorunlu</span>
            </div>
        </div>
    </header>

    <!-- Toast / Bildirim Alanı -->
    <div id="toast-container" class="position-fixed top-0 end-0 p-3" style="z-index: 1080;"></div>

    <div class="row">
        <!-- Sol Menü / Optimize Edilmiş Buton Paneli -->
        <div class="col-lg-4 mb-4">

            <!-- Aktif Muayene Hastası Seçim Paneli -->
            <div class="card card-ai p-3 mb-4 border-start border-4 border-primary">
                <label class="form-label fw-bold text-dark mb-1"><i class="bi bi-person-bounding-box text-primary me-1"></i> Analiz Edilecek Hasta Seçimi:</label>
                <select id="ai-patient-select" class="form-select form-select-sm fw-bold border-primary text-dark mb-2" onchange="onAiPatientChange(this.value)">
                    <option value="1" selected>Hasta #1: Ahmet Yılmaz (41Y, Erkek - Hipertansiyon & Diyabet)</option>
                    <option value="2">Hasta #2: Ayşe Demir (34Y, Kadın - Gebelik 24.Hafta & Astım)</option>
                    <option value="3">Hasta #3: Mehmet Kaya (68Y, Erkek - KOAH & Kalp Yetmezliği)</option>
                </select>
                <div class="d-flex gap-2 flex-wrap" id="ai-patient-badges">
                    <span class="badge bg-danger" id="ai-p-allergy"><i class="bi bi-exclamation-triangle-fill me-1"></i> Alerji: Penasilin</span>
                    <span class="badge bg-warning text-dark" id="ai-p-diagnosis"><i class="bi bi-activity me-1"></i> Tanı: I10 Hipertansiyon</span>
                </div>
            </div>
            
            <div class="card card-ai p-3 mb-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-sliders me-2 text-primary"></i>Klinik Karar Destek Modülleri</h5>
                <div class="d-grid gap-2">
                    <button id="btn-summary" class="btn btn-outline-primary btn-ai-action text-start" onclick="fetchPatientSummary()">
                        <i class="bi bi-file-person me-2"></i> Hasta Klinik Özeti & Geçmiş Analizi
                    </button>
                    <button id="btn-note" class="btn btn-outline-indigo btn-ai-action text-start text-dark" onclick="fetchClinicalNote()">
                        <i class="bi bi-journal-medical me-2"></i> Epikriz / Tıbbi Not Taslağı Üret
                    </button>
                    <button id="btn-support" class="btn btn-outline-purple btn-ai-action text-start text-dark" onclick="fetchDecisionSupport()">
                        <i class="bi bi-exclamation-triangle me-2"></i> Klinik Karar Desteği & İlaç Uyarıları
                    </button>
                    <button id="btn-protocol" class="btn btn-outline-success btn-ai-action text-start text-dark" onclick="fetchClinicalProtocol()">
                        <i class="bi bi-diagram-3 me-2"></i> Klinik Tanı & Tedavi Protokol Rehberi
                    </button>
                </div>
            </div>

            <!-- Parametrik Klinik Tetkik Verileri - Dinamik -->
            <div class="card card-ai p-3 mb-4 bg-white border">
                <h6 class="fw-bold text-dark mb-2"><i class="bi bi-table me-1 text-primary"></i> Parametrik Klinik Tetkik Verileri</h6>
                <div class="small" id="structured-data-container">
                    <div class="d-flex justify-content-between border-bottom py-1">
                        <span>Parametre:</span> <strong class="text-dark" id="param-name">HbA1c</strong>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-1">
                        <span>Sonuç / Birim:</span> <strong class="text-danger" id="param-value">7,8 %</strong>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-1">
                        <span>Referans Üst Sınır:</span> <span id="param-ref">6,5 %</span>
                    </div>
                    <div class="d-flex justify-content-between py-1">
                        <span>Durum:</span> <span class="badge bg-danger" id="param-status">Yüksek</span>
                    </div>
                </div>
            </div>

            <div class="card card-ai p-3">
                <h6 class="fw-bold text-secondary mb-2"><i class="bi bi-shield-check me-1"></i> Klinik Karar Destek İlkeleri</h6>
                <ul class="small text-muted ps-3 mb-0">
                    <li>AI sistemi otonom tedavi kararı veremez.</li>
                    <li>Reçete imzalayamaz, rapor düzenleyemez.</li>
                    <li>Girdiler KVKK uyumlu anomimleştirilerek AI Gateway'e iletilir.</li>
                    <li>Çıktılar hekim tarafından kontrol edilerek onaylanır.</li>
                </ul>
            </div>
        </div>

        <!-- Sağ İçerik / Çıktı Ekranı -->
        <div class="col-lg-8">
            <div class="card card-ai p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="fw-bold mb-0" id="output-title"><i class="bi bi-robot me-2 text-indigo"></i>Yapay Zekâ Analiz Ekranı</h4>
                    <div id="confidence-container" class="d-none">
                        <span class="confidence-pill" id="confidence-score">
                            <i class="bi bi-patch-check-fill me-1 text-primary"></i> Güven Skoru: %95
                        </span>
                    </div>
                </div>

                <!-- Yükleniyor Spinner -->
                <div id="ai-loading" class="text-center py-5 d-none">
                    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                        <span class="visually-hidden">İşleniyor...</span>
                    </div>
                    <p class="text-muted fw-semibold mt-3">AI Gateway üzerinden veriler anonimleştiriliyor ve klinik analiz yapılıyor...</p>
                </div>

                <!-- Yanıt Kutusu -->
                <div id="ai-output-box" class="ai-box mb-3">
                    Lütfen soldaki klinik modül butonlarına tıklayarak analizi başlatın.
                </div>

                <!-- Doktor Karar ve Onay Mekanizması -->
                <div id="doctor-feedback-section" class="doctor-approval-card d-none">
                    <h6 class="fw-bold text-dark mb-2"><i class="bi bi-check2-circle text-primary me-1"></i>Hekim Kararı ve Geri Bildirim Mekanizması</h6>
                    <p class="small text-muted mb-2">Bu çıktı doktor kontrolü ve onayı olmadan hasta dosyasına kaydedilemez.</p>
                    <div class="mb-3">
                        <textarea id="feedback-notes" class="form-control form-control-sm" rows="2" placeholder="Hekim notu / revizyon açıklaması (opsiyonel)..."></textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button id="btn-accept" class="btn btn-success btn-sm px-3 fw-semibold" onclick="sendFeedback('accepted')">
                            <i class="bi bi-check-circle me-1"></i> Kabul Et
                        </button>
                        <button id="btn-edit" class="btn btn-warning btn-sm px-3 text-dark fw-semibold" onclick="sendFeedback('edited')">
                            <i class="bi bi-pencil-square me-1"></i> Düzenleyerek Kabul Et
                        </button>
                        <button id="btn-reject" class="btn btn-danger btn-sm px-3 fw-semibold" onclick="sendFeedback('rejected')">
                            <i class="bi bi-x-circle me-1"></i> Reddet
                        </button>
                    </div>
                </div>
            </div>

            <!-- Audit Log Tablosu (Katlanabilir / Açılır-Kapanır Panel) -->
            <div class="card card-ai p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-clock-history me-1 text-primary"></i> İşlenen Klinik AI İstekleri (Audit Log)
                    </h6>
                    <!-- Kapatıp Açma Butonu -->
                    <button class="btn btn-sm btn-outline-secondary fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#auditLogCollapse" aria-expanded="false" aria-controls="auditLogCollapse" id="auditToggleBtn">
                        <i class="bi bi-chevron-down me-1"></i> Log Geçmişini Göster / Gizle
                    </button>
                </div>

                <!-- Collapse / Katlanabilir Gövde (Varsayılan Olarak Gizli) -->
                <div class="collapse mt-3" id="auditLogCollapse">
                    <div class="table-responsive" style="max-height: 280px; overflow-y: auto;">
                        <table class="table table-sm table-hover align-middle mb-0" id="audit-log-table">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th>#</th>
                                    <th>İstek Türü</th>
                                    <th>Model / Adaptör</th>
                                    <th>Tarih</th>
                                    <th>Durum</th>
                                    <th>İncele</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentResponses as $res)
                                <tr>
                                    <td>{{ $res->id }}</td>
                                    <td><span class="badge bg-indigo text-primary border">{{ $res->request->request_type ?? 'Genel' }}</span></td>
                                    <td><small class="text-muted">{{ class_basename($res->request->model_name ?? 'MockAiAdapter') }}</small></td>
                                    <td><small>{{ $res->created_at->format('d.m.Y H:i') }}</small></td>
                                    <td><span class="badge bg-success">Tamamlandı</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary py-0 px-2 style-small" onclick="viewAuditDetail({{ $res->id }}, '{{ $res->request->request_type ?? 'AI Analiz' }}', '{{ class_basename($res->request->model_name ?? 'MockAiAdapter') }}')">
                                            🔍 Detay
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr id="empty-row">
                                    <td colspan="6" class="text-center text-muted py-3">Henüz kaydedilmiş AI isteği bulunmuyor.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- AUDIT LOG DETAY MODALI -->
    <div class="modal fade" id="auditDetailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h6 class="modal-title fw-bold" id="auditModalTitle"><i class="bi bi-shield-check text-primary me-2"></i> AI Audit Log Detayı</h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body small">
                    <div class="card p-2 mb-2 bg-light">
                        <div><strong>İstek ID:</strong> <span id="audit-modal-id"></span></div>
                        <div><strong>İstek Türü:</strong> <span id="audit-modal-type"></span></div>
                        <div><strong>Model / Adaptör:</strong> <span id="audit-modal-model"></span></div>
                        <div><strong>KVKK Maskeleme:</strong> <span class="badge bg-success">Maskelendi (Hasta İsmi Gizlendi)</span></div>
                    </div>
                    <div class="mb-2">
                        <strong class="text-dark">AI Gateway İletim Güvenliği:</strong>
                        <p class="text-muted mb-0">İstek Sağlık Bakanlığı AI Gateway & HTTP HTTPS Secure Tunnel üzerinden iletilmiş, cevabın hasta dosyasına doğrudan yazılması engellenerek doktor onayına sunulmuştur.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Kapat</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    let currentResponseId = null;

    function viewAuditDetail(id, type, model) {
        document.getElementById('audit-modal-id').innerText = '#' + id;
        document.getElementById('audit-modal-type').innerText = type;
        document.getElementById('audit-modal-model').innerText = model;

        const myModal = new bootstrap.Modal(document.getElementById('auditDetailModal'));
        myModal.show();
    }

    function getSelectedPatientId() {
        const sel = document.getElementById('ai-patient-select');
        return sel ? sel.value : 1;
    }

    function onAiPatientChange(pid) {
        const allergy = document.getElementById('ai-p-allergy');
        const diagnosis = document.getElementById('ai-p-diagnosis');

        if (pid == '1') {
            document.getElementById('param-name').innerText = 'HbA1c';
            document.getElementById('param-value').innerText = '7,8 %';
            document.getElementById('param-ref').innerText = '6,5 %';
            document.getElementById('param-status').innerText = 'Yüksek';
            document.getElementById('param-status').className = 'badge bg-danger';

            allergy.innerHTML = '<i class="bi bi-exclamation-triangle-fill me-1"></i> Alerji: Penasilin';
            diagnosis.innerHTML = '<i class="bi bi-activity me-1"></i> Tanı: I10 Hipertansiyon';
        } else if (pid == '2') {
            document.getElementById('param-name').innerText = 'Hemoglobin (Hb)';
            document.getElementById('param-value').innerText = '10,5 g/dL';
            document.getElementById('param-ref').innerText = '12,0 g/dL';
            document.getElementById('param-status').innerText = 'Düşük (Hafif Anemi)';
            document.getElementById('param-status').className = 'badge bg-warning text-dark';

            allergy.innerHTML = '<i class="bi bi-exclamation-triangle-fill me-1"></i> Alerji: Aspirin / NSAİİ';
            diagnosis.innerHTML = '<i class="bi bi-activity me-1"></i> Tanı: Gebelik 24.Hafta & Astım';
        } else {
            document.getElementById('param-name').innerText = 'BNP Peptit (Kalp)';
            document.getElementById('param-value').innerText = '450 pg/mL';
            document.getElementById('param-ref').innerText = '100 pg/mL';
            document.getElementById('param-status').innerText = 'Kritik Yüksek';
            document.getElementById('param-status').className = 'badge bg-danger';

            allergy.innerHTML = '<i class="bi bi-shield-check me-1"></i> Alerji: Yok';
            diagnosis.innerHTML = '<i class="bi bi-activity me-1"></i> Tanı: KOAH & Kalp Yetmezliği';
        }
    }

    function setActiveButton(btnId) {
        document.querySelectorAll('.btn-ai-action').forEach(btn => btn.classList.remove('active'));
        if (btnId) {
            document.getElementById(btnId).classList.add('active');
        }
    }

    function disableButtons(disabled) {
        document.querySelectorAll('.btn-ai-action').forEach(btn => btn.disabled = disabled);
    }

    function showToast(message, type = 'success') {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');
        toast.className = `alert alert-${type} alert-dismissible fade show shadow-sm`;
        toast.innerHTML = `<i class="bi bi-info-circle me-2"></i>${message}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
        container.appendChild(toast);
        setTimeout(() => toast.remove(), 4000);
    }

    function showLoading(title, btnId) {
        setActiveButton(btnId);
        disableButtons(true);
        document.getElementById('ai-loading').classList.remove('d-none');
        document.getElementById('ai-output-box').classList.add('d-none');
        document.getElementById('doctor-feedback-section').classList.add('d-none');
        document.getElementById('output-title').innerHTML = title;
    }

    function hideLoading(summaryText, confidence, responseId, requestType) {
        disableButtons(false);
        document.getElementById('ai-loading').classList.add('d-none');
        document.getElementById('ai-output-box').classList.remove('d-none');
        document.getElementById('ai-output-box').innerText = summaryText;

        if (confidence) {
            document.getElementById('confidence-container').classList.remove('d-none');
            document.getElementById('confidence-score').innerHTML = '<i class="bi bi-patch-check-fill me-1 text-primary"></i> Güven Skoru: %' + Math.round(confidence * 100);
        }

        if (responseId) {
            currentResponseId = responseId;
            document.getElementById('doctor-feedback-section').classList.remove('d-none');
            appendAuditLogRow(responseId, requestType);
        }
    }

    function appendAuditLogRow(id, type) {
        const emptyRow = document.getElementById('empty-row');
        if (emptyRow) emptyRow.remove();

        const tbody = document.querySelector('#audit-log-table tbody');
        const now = new Date();
        const timeStr = now.toLocaleDateString('tr-TR') + ' ' + now.toLocaleTimeString('tr-TR', {hour: '2-digit', minute:'2-digit'});

        const tr = document.createElement('tr');
        tr.innerHTML = `<td>${id}</td>
            <td><span class="badge bg-indigo text-primary border">${type}</span></td>
            <td><small class="text-muted">MockAiAdapter</small></td>
            <td><small>${timeStr}</small></td>
            <td><span class="badge bg-success">Tamamlandı</span></td>
            <td><button class="btn btn-sm btn-outline-primary py-0 px-2 style-small" onclick="viewAuditDetail(${id}, '${type}', 'MockAiAdapter')">🔍 Detay</button></td>`;
        tbody.insertBefore(tr, tbody.firstChild);
    }

    function fetchPatientSummary() {
        const pid = getSelectedPatientId();
        showLoading('<i class="bi bi-file-person me-2 text-primary"></i>Hasta Klinik Özeti (Hasta #' + pid + ')', 'btn-summary');

        fetch("{{ route('ai.summarize_patient') }}", {
            method: "POST",
            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
            body: JSON.stringify({ patient_id: pid })
        })
        .then(res => res.json())
        .then(data => {
            hideLoading(data.summary_text, data.confidence_score, data.response_id, 'patient_summary');
        });
    }

    function fetchClinicalNote() {
        const pid = getSelectedPatientId();
        showLoading('<i class="bi bi-journal-medical me-2 text-success"></i>Epikriz / Tıbbi Not Taslağı (Hasta #' + pid + ')', 'btn-note');

        fetch("{{ route('ai.clinical_note') }}", {
            method: "POST",
            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
            body: JSON.stringify({ patient_id: pid })
        })
        .then(res => res.json())
        .then(data => {
            hideLoading(data.summary_text, data.confidence_score, data.response_id, 'clinical_note');
        });
    }

    function fetchDecisionSupport() {
        const pid = getSelectedPatientId();
        showLoading('<i class="bi bi-exclamation-triangle me-2 text-warning"></i>Klinik Karar Desteği & Uyarılar (Hasta #' + pid + ')', 'btn-support');

        fetch("{{ route('ai.decision_support') }}", {
            method: "POST",
            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
            body: JSON.stringify({ patient_id: pid })
        })
        .then(res => res.json())
        .then(data => {
            hideLoading(data.summary_text, data.confidence_score, data.response_id, 'decision_support');
        });
    }

    function fetchClinicalProtocol() {
        showLoading('<i class="bi bi-diagram-3 me-2 text-success"></i>Klinik Tanı & Tedavi Protokol Rehberi', 'btn-protocol');

        fetch("{{ route('ai.protocol') }}", {
            method: "POST",
            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
            body: JSON.stringify({ icd_code: 'I10' })
        })
        .then(res => res.json())
        .then(data => {
            let formatted = `KLİNİK PROTOKOL: ${data.disease_name} (${data.icd_code})\n`;
            formatted += `Kılavuz Kaynağı: ${data.guideline_source} (${data.guideline_version})\n\n`;
            formatted += `Semptomlar: ${data.symptoms.join(', ')}\n`;
            formatted += `Önerilen Tetkikler: ${data.recommended_tests.join(', ')}\n`;
            formatted += `Önerilen İlaç Grupları: ${data.recommended_drug_groups.join(', ')}\n\n`;
            formatted += `Kontrendikasyonlar: ${data.contraindications.join(' ')}\n\n`;
            formatted += `Yasal Uyarı: ${data.disclaimer}`;

            hideLoading(formatted, 0.98, null, 'clinical_protocol');
        });
    }

    function sendFeedback(action) {
        if (!currentResponseId) return;
        const notes = document.getElementById('feedback-notes').value;

        fetch("{{ route('ai.feedback') }}", {
            method: "POST",
            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
            body: JSON.stringify({
                ai_response_id: currentResponseId,
                action: action,
                feedback_notes: notes
            })
        })
        .then(res => res.json())
        .then(data => {
            showToast("Hekim Kararı Kaydedildi: " + action.toUpperCase(), "success");
            document.getElementById('doctor-feedback-section').classList.add('d-none');
        });
    }
</script>
@endpush
