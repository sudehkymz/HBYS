@extends('layouts.app')

@section('title', 'Yatan Hasta Servis İlaç Takibi & 8 Aşamalı Hazırlama Masası')

@push('styles')
<style>
    body { background-color: #f8fafc; color: #0f172a; }
    
    .card-clean {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.03), 0 1px 2px rgba(15, 23, 42, 0.02);
    }

    .step-pill {
        font-size: 0.76rem;
        font-weight: 600;
        padding: 0.35rem 0.65rem;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }
    .step-pill-completed { background-color: #d1fae5; color: #047857; border: 1px solid #a7f3d0; }
    .step-pill-in_progress { background-color: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
    .step-pill-pending { background-color: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; }

    /* Soft Renk Rozetleri */
    .bg-indigo-soft { background-color: #eef2ff; color: #4338ca; border: 1px solid #c7d2fe; }
    .bg-emerald-soft { background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
    .bg-amber-soft { background-color: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
    .bg-slate-soft { background-color: #f8fafc; color: #334155; border: 1px solid #e2e8f0; }

    .nav-pills-custom .nav-link {
        color: #64748b;
        font-weight: 600;
        font-size: 0.84rem;
        padding: 0.45rem 0.9rem;
        border-radius: 8px;
    }
    .nav-pills-custom .nav-link.active {
        background-color: #059669;
        color: #ffffff;
        box-shadow: 0 2px 6px rgba(5, 150, 105, 0.2);
    }
</style>
@endpush

@section('content')

    <!-- 1. ŞIK VE KOMPAKT ÜST HEADER -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 pb-2 border-bottom">
        <div>
            <h4 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                <i class="bi bi-hospital text-primary"></i> Yatan Hasta Servis İlaç Takibi & 8 Aşamalı Hazırlama Masası
            </h4>
            <p class="text-muted mb-0 small">Klinik Servis İlaç Dozaj Etiketleme, Kurye Teslimat & Hemşire Onay Hattı</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('pharmacy.index') }}" class="btn btn-sm btn-outline-success fw-semibold rounded-pill px-3">
                <i class="bi bi-prescription-bottle me-1"></i> İlaç Karşılama
            </a>
            <a href="{{ route('pharmacy.inpatient') }}" class="btn btn-sm btn-success fw-bold rounded-pill px-3 shadow-sm">
                <i class="bi bi-hospital me-1"></i> Yatan Hasta İlaç Paneli
            </a>
            <a href="{{ route('pharmacy.inventory') }}" class="btn btn-sm btn-outline-success fw-semibold rounded-pill px-3">
                <i class="bi bi-boxes me-1"></i> Stok & Depo Yönetimi
            </a>
        </div>
    </div>

    <!-- 3. CANLI HASTA / REÇETE SORGULAMA BARI (AUTOCOMPLETE) -->
    <div class="card-clean p-2.5 mb-3 bg-white">
        <form action="{{ route('pharmacy.inpatient') }}" method="GET" id="inpatientSearchForm">
            <div class="row g-2 align-items-center">
                <div class="col-md-6 position-relative">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light text-primary border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" id="inpatient_search_input" name="prescription_code" class="form-control form-control-sm border-start-0 fw-semibold" placeholder="Reçete No (EREP-...), T.C. Kimlik No veya Hasta Adı İle Arayın..." value="{{ request('prescription_code', $prescription['prescription_code'] ?? 'EREP-2026-554422') }}" autocomplete="off" oninput="handleInpatientSearchInput(this.value)" onfocus="handleInpatientSearchInput(this.value)">
                        <button type="submit" class="btn btn-primary btn-sm fw-semibold px-3">
                            İstemi Soruştur
                        </button>
                    </div>

                    <!-- 🔴 CANLI AUTOCOMPLETE DÜŞÜM MENÜSÜ -->
                    <div id="inpatient_search_dropdown" class="dropdown-menu shadow-lg w-100 p-0 border-0 mt-1" style="display:none; max-height:380px; overflow-y:auto; z-index:1050; position:absolute; top:100%; left:0;">
                        <div class="p-2 bg-slate-soft text-muted small fw-bold border-bottom d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-person-lines-fill me-1 text-primary"></i> Eşleşen Yatan Hasta & İstem Kayıtları:</span>
                            <span class="badge bg-primary" id="search_match_count">0</span>
                        </div>
                        <div class="list-group list-group-flush small" id="search_results_list">
                            <!-- Dynamic items injected via JS -->
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <input type="text" name="national_id" class="form-control form-control-sm" placeholder="T.C. Kimlik No..." value="{{ request('national_id', $prescription['national_id'] ?? '') }}">
                </div>
                <div class="col-md-3 text-end">
                    @if($prescription)
                    <div class="d-inline-flex align-items-center gap-2 bg-slate-soft px-3 py-1 rounded-pill small">
                        <i class="bi bi-hospital text-primary"></i>
                        <span class="fw-bold text-dark">{{ $prescription['patient_name'] }}</span>
                        <span class="text-muted font-monospace" style="font-size:0.75rem;">TC: {{ $prescription['national_id'] }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- 4. YATAN HASTA SERVİS İLAÇ İSTEM DÜZENİ -->
    <div class="row g-3">
        @if($prescription)
        
        <!-- SOL KOLON: PROVİZYON, İLAÇ LİSTESİ VE KURYEYE TESLİM BUTONU -->
        <div class="col-lg-7 mb-3">
            <div class="card-clean p-3 h-100">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                    <h6 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-file-earmark-medical text-success me-1.5"></i>
                        Reçete No: <span class="text-success">{{ $prescription['prescription_code'] }}</span>
                    </h6>
                    <div>
                        <span class="badge bg-amber-soft me-1"><i class="bi bi-hospital me-1"></i> Servis İlaç İstemi</span>
                        <span class="badge bg-emerald-soft"><i class="bi bi-check-circle me-1"></i> SGK Medula Onaylı</span>
                    </div>
                </div>

                <!-- SGK MEDULA PROVİZYON KARTI -->
                <div class="bg-emerald-soft p-3 rounded-3 mb-3 border">
                    <div class="d-flex justify-content-between align-items-center mb-1.5">
                        <strong class="text-success small"><i class="bi bi-hospital me-1"></i> Yatan Hasta Servis Provizyonu:</strong>
                        <span class="badge bg-white text-dark border">Provizyon No: {{ $prescription['medula_info']['provizyon_no'] }}</span>
                    </div>
                    <div class="row g-1.5 small text-dark" style="font-size:0.82rem;">
                        <div class="col-md-4"><strong>Hasta:</strong> <span class="fw-bold">{{ $prescription['patient_name'] }}</span></div>
                        <div class="col-md-4"><strong>TC:</strong> <span class="font-monospace fw-bold">{{ $prescription['national_id'] }}</span></div>
                        <div class="col-md-4"><strong>Servis / Oda:</strong> <span class="fw-bold text-dark">{{ $prescription['patient_type_label'] }}</span></div>
                        <div class="col-md-6"><strong>Hekim:</strong> {{ $prescription['physician'] }}</div>
                        <div class="col-md-6"><strong>Sosyal Güvence:</strong> {{ $prescription['sgk_type'] }}</div>
                        <div class="col-md-12 border-top pt-1 mt-1">
                            <strong>Klinik Tanı (ICD-10):</strong> <span class="text-primary fw-bold">{{ $prescription['diagnosis'] }}</span>
                        </div>
                    </div>
                </div>

                <!-- İLAÇ LİSTESİ VE STOK TABLOSU -->
                <h6 class="fw-bold text-dark mb-2 small"><i class="bi bi-boxes text-success me-1"></i> Reçeteli İlaçlar & Eczane Depo Stok Tablosu</h6>
                <div class="table-responsive mb-3">
                    <table class="table table-sm table-bordered align-middle small mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>İlaç Adı</th>
                                <th>İTS Barkod</th>
                                <th>Dozaj / Kutu</th>
                                <th>Depo Stok</th>
                                <th>Raf Yeri</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($prescription['drugs'] as $drug)
                            <tr>
                                <td><div class="fw-bold text-dark">{{ $drug['name'] }}</div></td>
                                <td class="font-monospace small text-muted">{{ $drug['barcode'] }}</td>
                                <td>{{ $drug['dosage'] }} ({{ $drug['box'] }} Kutu)</td>
                                <td><span class="badge bg-success">{{ $drug['stock'] }} Kutu</span></td>
                                <td><span class="badge bg-slate-soft">{{ $drug['shelf'] }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- İSTEM ONAY VE KURYEYE TESLİM BUTONU (TEKRARLANAN TIKLAMA KORUMALI) -->
                <div id="courier_button_container">
                    @if(($workflow['current_step'] ?? 1) >= 7)
                        <button type="button" class="btn btn-success btn-md w-100 fw-bold shadow-sm" disabled>
                            <i class="bi bi-check-circle-fill me-2"></i> Servis Kuryesine Teslim Edildi (İlaç Zimmetlendi & Kurye Yolda)
                        </button>
                    @else
                        <button type="button" id="courier_deliver_btn" class="btn btn-primary btn-md w-100 fw-bold shadow-sm" onclick="confirmCourierDelivery(this)">
                            <i class="bi bi-hospital me-2"></i> Yatan Hasta İstem Onayı Ver & Servis Kuryesine Teslim Et
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- SAĞ KOLON: KOMPAKT 8 AŞAMALI SERVİS SÜREÇ MATRIXI (YER KAPLAMAYAN TASARIM) -->
        <div class="col-lg-5 mb-3">
            <div class="card-clean p-3 h-100">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                    <div>
                        <h6 class="fw-bold text-dark mb-0"><i class="bi bi-diagram-3 text-primary me-1.5"></i>Klinik Servis İlaç Takibi</h6>
                        <small class="text-muted">İstem No: <strong>{{ $workflow['order_code'] }}</strong></small>
                    </div>
                    <div>
                        @if($workflow['current_step'] < 8)
                            <form action="{{ route('pharmacy.inpatient') }}" method="GET" class="d-inline">
                                <input type="hidden" name="prescription_code" value="{{ $prescription['prescription_code'] }}">
                                <input type="hidden" name="step" value="{{ $workflow['current_step'] + 1 }}">
                                <button type="submit" class="btn btn-primary btn-sm py-1 px-2.5 fw-bold shadow-sm" style="font-size:0.78rem;">
                                    <i class="bi bi-arrow-right-circle me-1"></i> İlerlet (Adım {{ $workflow['current_step'] + 1 }})
                                </button>
                            </form>
                        @else
                            <span class="badge bg-success p-1.5" style="font-size:0.75rem;"><i class="bi bi-check-circle me-1"></i> Süreç Tamamlandı</span>
                        @endif
                    </div>
                </div>

                <!-- KOMPAKT 8 ADIM ROZET MATRİXİ (YER KAPLAMAYAN 2 KOLONLU DÜZEN) -->
                <div class="row g-1.5 mb-3">
                    @foreach($workflow['steps'] as $s)
                    <div class="col-6">
                        <div class="p-2 rounded border step-pill-{{ $s['status'] }} d-flex align-items-center justify-content-between">
                            <div class="text-truncate me-1" style="font-size:0.76rem;">
                                <strong>Adım {{ $s['step'] }}:</strong> {{ $s['name'] }}
                            </div>
                            <div>
                                @if($s['status'] === 'completed')
                                    <i class="bi bi-check-circle-fill text-success fs-6"></i>
                                @elseif($s['status'] === 'in_progress')
                                    <div class="spinner-border spinner-border-sm text-warning" style="width:0.85rem;height:0.85rem;" role="status"></div>
                                @else
                                    <i class="bi bi-dash-circle text-muted fs-6"></i>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- AKTİF AŞAMA DETAY KARTI -->
                @php
                    $activeStepObj = collect($workflow['steps'])->firstWhere('step', $workflow['current_step']);
                @endphp
                @if($activeStepObj)
                <div class="bg-slate-50 p-2.5 rounded-3 border">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <strong class="text-dark small"><i class="bi bi-activity text-primary me-1"></i> Mevcut Aşama (Adım {{ $activeStepObj['step'] }}):</strong>
                        <span class="badge bg-amber-soft">{{ $activeStepObj['timestamp'] }}</span>
                    </div>
                    <h6 class="fw-bold text-primary mb-1" style="font-size:0.88rem;">{{ $activeStepObj['name'] }}</h6>
                    <p class="text-muted mb-0" style="font-size:0.78rem;">{{ $activeStepObj['detail'] }}</p>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>

@endsection

@push('scripts')
<script>
    let searchDebounceTimer = null;

    function handleInpatientSearchInput(query) {
        clearTimeout(searchDebounceTimer);
        const dropdown = document.getElementById('inpatient_search_dropdown');
        const resultsList = document.getElementById('search_results_list');
        const matchCountBadge = document.getElementById('search_match_count');

        if (!query || query.trim().length < 1) {
            if (dropdown) dropdown.style.display = 'none';
            return;
        }

        searchDebounceTimer = setTimeout(() => {
            fetch("{{ route('pharmacy.search_inpatient_ajax') }}?q=" + encodeURIComponent(query.trim()))
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success' && data.items && data.items.length > 0) {
                        let html = '';
                        data.items.forEach(item => {
                            html += `
                                <a href="{{ route('pharmacy.inpatient') }}?prescription_code=${item.prescription_code}" class="list-group-item list-group-item-action p-2.5 border-0 border-bottom d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-bold text-dark d-flex align-items-center gap-2">
                                            <i class="bi bi-hospital text-primary fs-6"></i> ${item.patient_name}
                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle font-monospace">${item.prescription_code}</span>
                                        </div>
                                        <div class="text-muted small mt-1" style="font-size:0.75rem;">
                                            <i class="bi bi-card-text me-1"></i> TC: <strong>${item.national_id}</strong> | Servis: <strong>${item.clinic}</strong> | Tanı: <strong>${item.diagnosis}</strong>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-light text-dark border mb-1 d-block">${item.physician}</span>
                                        <span class="btn btn-primary btn-sm py-0 px-2 fw-semibold" style="font-size:0.72rem;">İstemi Aç &rarr;</span>
                                    </div>
                                </a>
                            `;
                        });
                        resultsList.innerHTML = html;
                        matchCountBadge.innerText = data.items.length;
                        dropdown.style.display = 'block';
                    } else {
                        resultsList.innerHTML = `<div class="p-3 text-center text-muted small"><i class="bi bi-exclamation-circle me-1"></i> "${query}" kriterine uygun yatan hasta reçete istemi bulunamadı.</div>`;
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
        const dropdown = document.getElementById('inpatient_search_dropdown');
        const input = document.getElementById('inpatient_search_input');
        if (dropdown && input && !dropdown.contains(e.target) && !input.contains(e.target)) {
            dropdown.style.display = 'none';
        }
    });

    function confirmCourierDelivery(btn) {
        Swal.fire({
            icon: 'success',
            title: 'Yatan Hasta İstem Onayı Verildi',
            text: 'İlaçlar dozaj etiketleme bantına iletildi ve servis kuryesine zimmetlendi.',
            confirmButtonColor: '#059669'
        }).then(() => {
            btn.disabled = true;
            btn.className = 'btn btn-success btn-md w-100 fw-bold shadow-sm';
            btn.innerHTML = '<i class="bi bi-check-circle-fill me-2"></i> Servis Kuryesine Teslim Edildi (İlaç Zimmetlendi & Kurye Yolda)';
        });
    }
</script>
@endpush
