@extends('layouts.app')

@section('title', 'Eczane Reçete Karşılama, Yatan Hasta & Stok Yönetim Masası')

@push('styles')
<style>
    body { background-color: #f8fafc; color: #1e293b; }
    
    .card-clean {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04), 0 1px 2px rgba(15, 23, 42, 0.02);
        transition: all 0.2s ease;
    }

    .metric-card-clean {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.1rem 1.25rem;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }
    .metric-card-clean:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05);
    }

    .step-circle { width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 0.82rem; }
    .step-completed { background-color: #10b981; color: white; }
    .step-in_progress { background-color: #f59e0b; color: white; }
    .step-pending { background-color: #cbd5e1; color: #64748b; }

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

    /* Soft Renk Rozetleri & Metin Tonları */
    .bg-indigo-soft { background-color: #eef2ff; color: #4338ca; border: 1px solid #c7d2fe; }
    .bg-emerald-soft { background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
    .bg-amber-soft { background-color: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
    .bg-rose-soft { background-color: #fff1f2; color: #be123c; border: 1px solid #fecdd3; }
    .bg-slate-soft { background-color: #f1f5f9; color: #334155; border: 1px solid #cbd5e1; }

    /* RESMİ SGK VE GİB VERGİ FİŞİ BASTIRMA STİLLERİ */
    @media print {
        body * {
            visibility: hidden !important;
        }
        #printableReceiptArea, #printableReceiptArea * {
            visibility: visible !important;
        }
        #printableReceiptArea {
            position: absolute !important;
            left: 0 !important;
            top: 0 !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            box-shadow: none !important;
            border: none !important;
        }
        .modal, .modal-dialog, .modal-content {
            position: static !important;
            margin: 0 !important;
            padding: 0 !important;
            border: none !important;
            box-shadow: none !important;
            background: transparent !important;
        }
        .modal-header, .modal-footer, .btn-close, .no-print {
            display: none !important;
        }
    }
</style>
@endpush

@section('content')

    <!-- 1. TEK SAYFA ECZANE BAŞLIĞI VE ANLIK SEKME GEÇİŞ BUTONLARI -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 pb-2 border-bottom">
        <div>
            <h3 class="fw-bold mb-1 d-flex align-items-center gap-2 text-dark">
                <i class="bi bi-prescription2 text-success"></i> Eczane Reçete Karşılama & İlaç Masası
            </h3>
            <p class="text-muted mb-0 small">Ayaktan Poliklinik Karşılama, Yatan Hasta Servis İlaç Takibi & Stok Depo Yönetimi (SGK Medula & İTS Entegre)</p>
        </div>
        <div class="d-flex align-items-center gap-2" id="pharmacyTabNav">
            <button type="button" id="tab_btn_dispensing" class="btn btn-sm {{ $activeTab === 'dispensing' ? 'btn-success fw-bold shadow-sm' : 'btn-outline-success fw-semibold' }} rounded-pill px-3" onclick="switchPharmacyTab('dispensing')">
                <i class="bi bi-prescription-bottle me-1"></i> İlaç Karşılama
            </button>
            <button type="button" id="tab_btn_inpatient" class="btn btn-sm {{ $activeTab === 'inpatient' ? 'btn-success fw-bold shadow-sm' : 'btn-outline-success fw-semibold' }} rounded-pill px-3" onclick="switchPharmacyTab('inpatient')">
                <i class="bi bi-hospital me-1"></i> Yatan Hasta İlaç Paneli
            </button>
            <button type="button" id="tab_btn_inventory" class="btn btn-sm {{ $activeTab === 'inventory' ? 'btn-success fw-bold shadow-sm' : 'btn-outline-success fw-semibold' }} rounded-pill px-3" onclick="switchPharmacyTab('inventory')">
                <i class="bi bi-boxes me-1"></i> Stok & Depo Yönetimi
            </button>
        </div>
    </div>

    <!-- ================================================================ -->
    <!-- SEKME 1: İLAÇ KARŞILAMA (POLİKLİNİK VE GENEL REÇETE MASASI) -->
    <!-- ================================================================ -->
    <div id="pharmacy_tab_dispensing" style="display: {{ $activeTab === 'dispensing' ? 'block' : 'none' }};">
        
        <!-- CANLI REÇETE / HASTA SORGULAMA BARI (AUTOCOMPLETE) -->
        <div class="card-clean p-2.5 mb-3 bg-white">
            <form action="{{ route('pharmacy.index') }}" method="GET" id="pharmacySearchForm">
                <input type="hidden" name="tab" value="dispensing">
                <div class="row g-2 align-items-center">
                    <div class="col-md-6 position-relative">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light text-success border-end-0"><i class="bi bi-search"></i></span>
                            <input type="text" id="pharmacy_search_input" name="prescription_code" class="form-control form-control-sm border-start-0 fw-semibold" placeholder="E-Reçete Kodu (EREP-...), T.C. Kimlik No veya Hasta Adı..." value="{{ request('prescription_code', $prescription['prescription_code'] ?? '') }}" autocomplete="off" oninput="handlePharmacySearchInput(this.value)" onfocus="handlePharmacySearchInput(this.value)">
                            <button type="submit" class="btn btn-success btn-sm fw-semibold px-3">
                                Reçeteyi Soruştur
                            </button>
                        </div>

                        <!-- 🔴 CANLI AUTOCOMPLETE DÜŞÜM MENÜSÜ -->
                        <div id="pharmacy_search_dropdown" class="dropdown-menu shadow-lg w-100 p-0 border-0 mt-1" style="display:none; max-height:380px; overflow-y:auto; z-index:1050; position:absolute; top:100%; left:0;">
                            <div class="p-2 bg-slate-soft text-muted small fw-bold border-bottom d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-person-lines-fill me-1 text-success"></i> Eşleşen Poliklinik Reçete Kayıtları:</span>
                                <span class="badge bg-success" id="search_match_count">0</span>
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
                        <div class="d-inline-flex align-items-center gap-2 bg-emerald-soft px-3 py-1 rounded-pill small">
                            <i class="bi bi-person-check-fill text-success"></i>
                            <span class="fw-bold text-dark">{{ $prescription['patient_name'] }}</span>
                            <span class="text-muted font-monospace" style="font-size:0.75rem;">TC: {{ $prescription['national_id'] }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- DİNAMİK HASTA TÜRÜ KONTROLÜ VE EKRAN DÜZENİ -->
        <div class="row">

            @if(!$prescription)
            <div class="col-12 mb-4">
                <div class="card-clean p-5 text-center">
                    <div class="py-4">
                        @if($hasSearchTerm)
                            <i class="bi bi-exclamation-octagon text-warning opacity-75" style="font-size: 3.5rem;"></i>
                            <h5 class="fw-bold text-dark mt-3">Aranan Kriterlere Uygun Reçete Bulunamadı</h5>
                            <p class="text-muted small mb-0">Girdiğiniz E-Reçete Kodu veya T.C. Kimlik Numarası ile eşleşen kayıt bulunamadı. Lütfen bilgileri kontrol ediniz.</p>
                        @else
                            <i class="bi bi-search-heart text-success opacity-50" style="font-size: 3.5rem;"></i>
                            <h5 class="fw-bold text-dark mt-3">Reçete Sorgulama Masası</h5>
                            <p class="text-muted small mb-0">Reçete karşılama ve İTS karekod sorgulaması için yukarıdaki arama çubuğuna <strong>E-Reçete Kodu</strong> veya <strong>T.C. Kimlik No</strong> girerek <strong>"Reçeteyi Soruştur"</strong> butonuna basınız.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- CASE 1: AYAKTAN POLİKLİNİK HASTASI (TAM GENİŞLİK - DOĞRUDAN İLAÇ TESLİMİ) -->
            @elseif(($prescription['patient_type'] ?? '') === 'ayaktan')
            <div class="col-12 mb-4">
                <div class="card-clean p-4">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
                        <h5 class="fw-bold mb-0 text-dark">
                            <i class="bi bi-shop text-success me-2"></i>
                            Ayaktan Poliklinik Reçetesi: <span class="text-success">{{ $prescription['prescription_code'] }}</span>
                        </h5>
                        <div>
                            <span class="badge bg-indigo-soft me-1"><i class="bi bi-person-fill me-1"></i> Ayaktan Poliklinik Hastası</span>
                            <span class="badge bg-emerald-soft"><i class="bi bi-check-circle me-1"></i> SGK Medula Provizyonu Onaylandı</span>
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <!-- HASTA VE MEDULA PROVİZYON KART CİHAZI -->
                        <div class="col-md-6">
                            <div class="bg-light p-3 rounded-3 border h-100">
                                <h6 class="fw-bold text-dark mb-2"><i class="bi bi-person-vcard text-primary me-1"></i> Hasta Kimlik ve Sigorta Bilgileri</h6>
                                <div class="row g-2 small">
                                    <div class="col-6"><strong>Adı Soyadı:</strong> <span class="fw-bold text-dark">{{ $prescription['patient_name'] }}</span></div>
                                    <div class="col-6"><strong>T.C. Kimlik No:</strong> <span class="font-monospace fw-bold">{{ $prescription['national_id'] }}</span></div>
                                    <div class="col-6"><strong>Doğum T. / Cinsiyet:</strong> {{ $prescription['birth_date'] }} / {{ $prescription['gender'] }}</div>
                                    <div class="col-6"><strong>Sosyal Güvence:</strong> <span class="badge bg-slate-soft">{{ $prescription['sgk_type'] }}</span></div>
                                    <div class="col-12 border-top pt-2 mt-1">
                                        <strong>Reçeteyi Yazan Hekim:</strong> <span class="fw-bold text-dark">{{ $prescription['physician'] }}</span><br>
                                        <strong>Poliklinik & Tanı:</strong> <span class="text-primary fw-bold">{{ $prescription['clinic'] }} — {{ $prescription['diagnosis'] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- HESAPLANAN FİNANSAL TABLO & KATILIM PAYI -->
                        <div class="col-md-6">
                            <div class="bg-emerald-soft p-3 rounded-3 border h-100 d-flex flex-column justify-content-between">
                                <div>
                                    <h6 class="fw-bold text-success mb-2"><i class="bi bi-calculator me-1"></i> SGK Medula Fiyat & Katılım Payı Hesabı</h6>
                                    <div class="row g-2 small">
                                        <div class="col-6"><strong>Reçete Toplam İlaç Tutarı:</strong></div>
                                        <div class="col-6 text-end fw-bold text-dark fs-6">{{ $prescription['medula_info']['total_price'] }}</div>
                                        <div class="col-6 text-success"><strong>SGK Tarafından Ödenen (%80):</strong></div>
                                        <div class="col-6 text-end fw-bold text-success">{{ $prescription['medula_info']['sgk_coverage'] }}</div>
                                        <div class="col-12 border-top pt-2 mt-1"></div>
                                        <div class="col-6 text-danger"><strong class="fs-6">Eczanede Tahsil Edilecek:</strong></div>
                                        <div class="col-6 text-end"><span class="badge bg-danger fs-6 px-3 py-1">{{ $prescription['medula_info']['patient_copay'] }}</span></div>
                                    </div>
                                </div>
                                <div class="text-muted small mt-2 pt-2 border-top text-center font-monospace">
                                    Status: {{ $prescription['medula_info']['copay_status'] }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ALERJİ VE İLAÇ ETKİLEŞİM GÜVENLİK BARI -->
                    <div class="alert alert-warning border-start border-4 border-warning d-flex align-items-center justify-content-between mb-4 shadow-sm" role="alert">
                        <div>
                            <strong class="text-dark"><i class="bi bi-shield-exclamation text-warning me-1"></i> Klinik Güvenlik & Çapraz Etkileşim Kontrolü:</strong>
                            <span class="ms-2 small text-dark">Hasta Alerji Kaydı: <strong>{{ implode(', ', $prescription['allergies']) }}</strong> | İlaç Etkileşimi: <strong>{{ $prescription['interactions'] }}</strong></span>
                        </div>
                        <span class="badge bg-success">Güvenlik Onayı Verildi</span>
                    </div>

                    <!-- İLAÇ KALEMLERİ VE İTS KAREKOD TABLOSU -->
                    <h5 class="fw-bold text-dark mb-3"><i class="bi bi-capsule text-success me-2"></i> Reçetedeki İlaçlar, İTS Karekod ve Eczane Depo Stok Kontrolü</h5>
                    <div class="table-responsive mb-4">
                        <table class="table table-hover table-bordered align-middle small mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>İlaç Adı</th>
                                    <th>İTS Barkod No</th>
                                    <th>İTS Durumu</th>
                                    <th>Dozaj & Kullanım</th>
                                    <th>Kutu</th>
                                    <th>Birim Fiyat</th>
                                    <th>SGK Hissesi</th>
                                    <th>Hasta Katılım</th>
                                    <th>Eczane Stok / Raf</th>
                                    <th>Muadil Seçeneği</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($prescription['drugs'] as $drug)
                                <tr>
                                    <td><strong class="text-dark">{{ $drug['name'] }}</strong></td>
                                    <td><span class="font-monospace small text-muted">{{ $drug['barcode'] }}</span></td>
                                    <td><span class="badge bg-success"><i class="bi bi-qr-code me-1"></i> {{ $drug['its_status'] }}</span></td>
                                    <td>{{ $drug['dosage'] }}</td>
                                    <td class="fw-bold">{{ $drug['box'] }} Kutu</td>
                                    <td class="fw-bold">{{ $drug['price'] }}</td>
                                    <td class="text-success fw-bold">{{ $drug['sgk_pays'] }} ({{ $drug['sgk_rate'] }})</td>
                                    <td class="text-danger fw-bold">{{ $drug['patient_pays'] }}</td>
                                    <td>
                                        <span class="badge bg-success">{{ $drug['stock'] }} Kutu</span>
                                        <small class="text-muted d-block">{{ $drug['shelf'] }}</small>
                                    </td>
                                    <td><span class="badge bg-slate-soft">{{ $drug['equivalent_generic'] }}</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- İŞLEM BUTONLARI VE İRSALİYE -->
                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <div>
                            @if($prescription['is_dispensed'])
                                <span class="badge bg-success p-2 fs-6"><i class="bi bi-check-circle-fill me-1"></i> İlaçlar Hastaya Teslim Edilmiştir (İrsaliye Fiş No: {{ $prescription['receipt_no'] }})</span>
                            @else
                                <span class="badge bg-warning text-dark p-2 fs-6"><i class="bi bi-clock me-1"></i> İlaç Teslimatı Bekliyor</span>
                            @endif
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-success btn-md fw-bold" data-bs-toggle="modal" data-bs-target="#pharmacyReceiptModal">
                                <i class="bi bi-printer me-1"></i> Resmi SGK İrsaliye & Fişini Görüntüle
                            </button>
                            @if(!$prescription['is_dispensed'])
                                <button type="button" class="btn btn-success btn-md fw-bold px-4 shadow-sm" onclick="completeDispensing('ayaktan')">
                                    <i class="bi bi-bag-check-fill me-2"></i> İlaçları Hastaya Teslim Et & Provizyonu Kapat
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- CASE 2: YATAN HASTA SERVİS İŞLEMİ -->
            @else
            <div class="col-lg-7 mb-4">
                <div class="card-clean p-4 h-100">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
                        <h5 class="fw-bold mb-0 text-dark">
                            <i class="bi bi-hospital text-primary me-2"></i>
                            Yatan Hasta Servis Reçetesi: <span class="text-primary">{{ $prescription['prescription_code'] }}</span>
                        </h5>
                        <div>
                            <span class="badge bg-amber-soft me-1"><i class="bi bi-hospital me-1"></i> Yatan Hasta (Klinik Servis)</span>
                            <span class="badge bg-emerald-soft"><i class="bi bi-check-circle me-1"></i> SGK Medula Onaylı</span>
                        </div>
                    </div>

                    <div class="bg-emerald-soft p-3 rounded-3 mb-4 border">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <strong class="text-success"><i class="bi bi-hospital me-1"></i> Servis Provizyon Detayı:</strong>
                            <span class="badge bg-white text-dark border">Provizyon No: {{ $prescription['medula_info']['provizyon_no'] }}</span>
                        </div>
                        <div class="row g-2 small text-dark">
                            <div class="col-md-4"><strong>Hasta:</strong> <span class="fw-bold">{{ $prescription['patient_name'] }}</span></div>
                            <div class="col-md-4"><strong>TC:</strong> <span class="font-monospace fw-bold">{{ $prescription['national_id'] }}</span></div>
                            <div class="col-md-4"><strong>Servis / Oda:</strong> {{ $prescription['patient_type_label'] }}</div>
                            <div class="col-md-6"><strong>Hekim:</strong> {{ $prescription['physician'] }}</div>
                            <div class="col-md-6"><strong>Sosyal Güvence:</strong> {{ $prescription['sgk_type'] }}</div>
                        </div>
                    </div>

                    <h6 class="fw-bold text-dark mb-3"><i class="bi bi-boxes me-1 text-success"></i> Reçeteli İlaçlar & Servis Dozaj Hazırlama</h6>
                    <div class="table-responsive mb-4">
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
                                    <td><strong>{{ $drug['name'] }}</strong></td>
                                    <td class="font-monospace small text-muted">{{ $drug['barcode'] }}</td>
                                    <td>{{ $drug['dosage'] }} ({{ $drug['box'] }} Kutu)</td>
                                    <td><span class="badge bg-success">{{ $drug['stock'] }} Kutu</span></td>
                                    <td><span class="badge bg-slate-soft">{{ $drug['shelf'] }}</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <button type="button" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm" onclick="Swal.fire({icon: 'success', title: 'Yatan Hasta İstem Onayı Verildi', text: 'İlaçlar dozaj etiketleme bantına iletildi ve servis kuryesine zimmetlendi.', confirmButtonColor: '#2563eb'})">
                        <i class="bi bi-hospital me-2"></i> Yatan Hasta İstem Onayı Ver & Servis Kuryesine Teslim Et
                    </button>
                </div>
            </div>

            <div class="col-lg-5 mb-4">
                <div class="card-clean p-4 h-100">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
                        <div>
                            <h6 class="fw-bold text-dark mb-0"><i class="bi bi-diagram-3 me-2 text-primary"></i>Klinik Servis İlaç Takibi</h6>
                            <small class="text-muted">İstem No: <strong>{{ $workflow['order_code'] }}</strong></small>
                        </div>
                    </div>

                    <div class="timeline ps-2">
                        @foreach($workflow['steps'] as $s)
                        <div class="d-flex align-items-start mb-3">
                            <div class="step-circle step-{{ $s['status'] }} me-2 flex-shrink-0 shadow-sm">
                                @if($s['status'] === 'completed')
                                    <i class="bi bi-check-lg"></i>
                                @elseif($s['status'] === 'in_progress')
                                    <div class="spinner-border spinner-border-sm" role="status"></div>
                                @else
                                    {{ $s['step'] }}
                                @endif
                            </div>
                            <div class="flex-grow-1 bg-slate-50 p-2.5 rounded-3 border small">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="fw-bold text-dark mb-0" style="font-size:0.85rem;">Adım {{ $s['step'] }}: {{ $s['name'] }}</h6>
                                    <small class="text-muted">{{ $s['timestamp'] }}</small>
                                </div>
                                <p class="text-secondary mb-0 mt-1" style="font-size:0.78rem;">{{ $s['detail'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>

    <!-- ================================================================ -->
    <!-- SEKME 2: YATAN HASTA İLAÇ PANERİ (8 AŞAMALI HAZIRLAMA MASASI) -->
    <!-- ================================================================ -->
    <div id="pharmacy_tab_inpatient" style="display: {{ $activeTab === 'inpatient' ? 'block' : 'none' }};">
        
        <!-- CANLI HASTA / REÇETE SORGULAMA BARI (AUTOCOMPLETE) -->
        <div class="card-clean p-2.5 mb-3 bg-white">
            <form action="{{ route('pharmacy.index') }}" method="GET" id="inpatientSearchForm">
                <input type="hidden" name="tab" value="inpatient">
                <div class="row g-2 align-items-center">
                    <div class="col-md-6 position-relative">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light text-primary border-end-0"><i class="bi bi-search"></i></span>
                            <input type="text" id="inpatient_search_input" name="prescription_code" class="form-control form-control-sm border-start-0 fw-semibold" placeholder="Reçete No (EREP-...), T.C. Kimlik No veya Hasta Adı İle Arayın..." value="{{ request('prescription_code', $inpatientPrescription['prescription_code'] ?? 'EREP-2026-554422') }}" autocomplete="off" oninput="handleInpatientSearchInput(this.value)" onfocus="handleInpatientSearchInput(this.value)">
                            <button type="submit" class="btn btn-primary btn-sm fw-semibold px-3">
                                İstemi Soruştur
                            </button>
                        </div>

                        <!-- 🔴 CANLI AUTOCOMPLETE DÜŞÜM MENÜSÜ -->
                        <div id="inpatient_search_dropdown" class="dropdown-menu shadow-lg w-100 p-0 border-0 mt-1" style="display:none; max-height:380px; overflow-y:auto; z-index:1050; position:absolute; top:100%; left:0;">
                            <div class="p-2 bg-slate-soft text-muted small fw-bold border-bottom d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-person-lines-fill me-1 text-primary"></i> Eşleşen Yatan Hasta & İstem Kayıtları:</span>
                                <span class="badge bg-primary" id="inpatient_match_count">0</span>
                            </div>
                            <div class="list-group list-group-flush small" id="inpatient_results_list">
                                <!-- Dynamic items injected via JS -->
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <input type="text" name="national_id" class="form-control form-control-sm" placeholder="T.C. Kimlik No..." value="{{ request('national_id', $inpatientPrescription['national_id'] ?? '') }}">
                    </div>
                    <div class="col-md-3 text-end">
                        @if($inpatientPrescription)
                        <div class="d-inline-flex align-items-center gap-2 bg-slate-soft px-3 py-1 rounded-pill small">
                            <i class="bi bi-hospital text-primary"></i>
                            <span class="fw-bold text-dark">{{ $inpatientPrescription['patient_name'] }}</span>
                            <span class="text-muted font-monospace" style="font-size:0.75rem;">TC: {{ $inpatientPrescription['national_id'] }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- YATAN HASTA SERVİS İLAÇ İSTEM DÜZENİ -->
        <div class="row g-3">
            @if($inpatientPrescription)
            
            <!-- SOL KOLON: PROVİZYON, İLAÇ LİSTESİ VE KURYEYE TESLİM BUTONU -->
            <div class="col-lg-7 mb-3">
                <div class="card-clean p-3 h-100">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                        <h6 class="fw-bold mb-0 text-dark">
                            <i class="bi bi-file-earmark-medical text-success me-1.5"></i>
                            Reçete No: <span class="text-success">{{ $inpatientPrescription['prescription_code'] }}</span>
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
                            <span class="badge bg-white text-dark border">Provizyon No: {{ $inpatientPrescription['medula_info']['provizyon_no'] }}</span>
                        </div>
                        <div class="row g-1.5 small text-dark" style="font-size:0.82rem;">
                            <div class="col-md-4"><strong>Hasta:</strong> <span class="fw-bold">{{ $inpatientPrescription['patient_name'] }}</span></div>
                            <div class="col-md-4"><strong>TC:</strong> <span class="font-monospace fw-bold">{{ $inpatientPrescription['national_id'] }}</span></div>
                            <div class="col-md-4"><strong>Servis / Oda:</strong> <span class="fw-bold text-dark">{{ $inpatientPrescription['patient_type_label'] }}</span></div>
                            <div class="col-md-6"><strong>Hekim:</strong> {{ $inpatientPrescription['physician'] }}</div>
                            <div class="col-md-6"><strong>Sosyal Güvence:</strong> {{ $inpatientPrescription['sgk_type'] }}</div>
                            <div class="col-md-12 border-top pt-1 mt-1">
                                <strong>Klinik Tanı (ICD-10):</strong> <span class="text-primary fw-bold">{{ $inpatientPrescription['diagnosis'] }}</span>
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
                                @foreach($inpatientPrescription['drugs'] as $drug)
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

                    <!-- İSTEM ONAY VE KURYEYE TESLİM BUTONU -->
                    <div id="courier_button_container">
                        @if(($inpatientWorkflow['current_step'] ?? 1) >= 7)
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

            <!-- SAĞ KOLON: KOMPAKT 8 AŞAMALI SERVİS SÜREÇ MATRIXI -->
            <div class="col-lg-5 mb-3">
                <div class="card-clean p-3 h-100">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                        <div>
                            <h6 class="fw-bold text-dark mb-0"><i class="bi bi-diagram-3 text-primary me-1.5"></i>Klinik Servis İlaç Takibi</h6>
                            <small class="text-muted">İstem No: <strong>{{ $inpatientWorkflow['order_code'] }}</strong></small>
                        </div>
                        <div>
                            @if($inpatientWorkflow['current_step'] < 8)
                                <form action="{{ route('pharmacy.index') }}" method="GET" class="d-inline">
                                    <input type="hidden" name="tab" value="inpatient">
                                    <input type="hidden" name="prescription_code" value="{{ $inpatientPrescription['prescription_code'] }}">
                                    <input type="hidden" name="step" value="{{ $inpatientWorkflow['current_step'] + 1 }}">
                                    <button type="submit" class="btn btn-primary btn-sm py-1 px-2.5 fw-bold shadow-sm" style="font-size:0.78rem;">
                                        <i class="bi bi-arrow-right-circle me-1"></i> İlerlet (Adım {{ $inpatientWorkflow['current_step'] + 1 }})
                                    </button>
                                </form>
                            @else
                                <span class="badge bg-success p-1.5" style="font-size:0.75rem;"><i class="bi bi-check-circle me-1"></i> Süreç Tamamlandı</span>
                            @endif
                        </div>
                    </div>

                    <!-- KOMPAKT 8 ADIM ROZET MATRİXİ -->
                    <div class="row g-1.5 mb-3">
                        @foreach($inpatientWorkflow['steps'] as $s)
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
                        $activeStepObj = collect($inpatientWorkflow['steps'])->firstWhere('step', $inpatientWorkflow['current_step']);
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
    </div>

    <!-- ================================================================ -->
    <!-- SEKME 3: STOK & DEPO YÖNETİMİ -->
    <!-- ================================================================ -->
    <div id="pharmacy_tab_inventory" style="display: {{ $activeTab === 'inventory' ? 'block' : 'none' }};">
        
        <!-- KPI STOK ÖZET KARTLARI -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="metric-card-clean d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small fw-semibold">Toplam İlaç Çeşidi</div>
                        <h3 class="fw-bold text-dark mb-0 mt-1">{{ $totalItems }}</h3>
                    </div>
                    <div class="rounded-circle bg-indigo-soft p-3 d-flex align-items-center justify-content-center" style="width:46px;height:46px;">
                        <i class="bi bi-capsule fs-4"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric-card-clean d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small fw-semibold">Kritik Stok Uyarısı (< 15)</div>
                        <h3 class="fw-bold text-danger mb-0 mt-1">{{ $criticalCount }}</h3>
                    </div>
                    <div class="rounded-circle bg-rose-soft p-3 d-flex align-items-center justify-content-center" style="width:46px;height:46px;">
                        <i class="bi bi-exclamation-octagon-fill fs-4"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric-card-clean d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small fw-semibold">SKT Yaklaşanlar (30 Gün)</div>
                        <h3 class="fw-bold text-warning mb-0 mt-1">{{ $expiringCount }}</h3>
                    </div>
                    <div class="rounded-circle bg-amber-soft p-3 d-flex align-items-center justify-content-center" style="width:46px;height:46px;">
                        <i class="bi bi-calendar-event-fill fs-4"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric-card-clean d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small fw-semibold">Bugün Teslim Edilen</div>
                        <h3 class="fw-bold text-success mb-0 mt-1">42 Kutu</h3>
                    </div>
                    <div class="rounded-circle bg-emerald-soft p-3 d-flex align-items-center justify-content-center" style="width:46px;height:46px;">
                        <i class="bi bi-check-circle-fill fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- İLAÇ STOK VERİ TABLOSU & DEPO İKMALİ -->
        <div class="card-clean p-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-table text-success me-2"></i> Eczane İlaç Stok & Depo Listesi
                </h5>
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-success btn-sm fw-bold shadow-sm" onclick="Swal.fire({icon: 'success', title: 'Ana Depo İkmal Talebi', text: 'Kritik stok seviyesindeki ilaçlar için Ana Depo Merkez Transfer Talebi oluşturuldu.', confirmButtonColor: '#059669'})">
                        <i class="bi bi-plus-circle me-1"></i> Ana Depodan Stok İkmal Et
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle small mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>İlaç Adı / Kategorisi</th>
                            <th>İTS Barkod No</th>
                            <th>Mevcut Stok</th>
                            <th>Kritik Limit</th>
                            <th>Raf Yeri</th>
                            <th>Perakende Fiyat</th>
                            <th>Son Kullanma Tarihi (SKT)</th>
                            <th>Stok Durumu</th>
                            <th>İşlem</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                        <tr>
                            <td>
                                <div class="fw-bold text-dark">{{ $item['name'] }}</div>
                                <small class="text-muted">{{ $item['category'] }}</small>
                            </td>
                            <td class="font-monospace text-muted">{{ $item['barcode'] }}</td>
                            <td>
                                @if($item['status'] === 'critical')
                                    <span class="badge bg-danger fs-6">{{ $item['stock'] }} Kutu</span>
                                @elseif($item['status'] === 'expiring')
                                    <span class="badge bg-warning text-dark fs-6">{{ $item['stock'] }} Kutu</span>
                                @else
                                    <span class="badge bg-success fs-6">{{ $item['stock'] }} Kutu</span>
                                @endif
                            </td>
                            <td class="text-muted fw-semibold">{{ $item['min_limit'] }} Kutu</td>
                            <td><span class="badge bg-slate-soft">{{ $item['shelf'] }}</span></td>
                            <td class="fw-bold text-dark">{{ $item['price'] }}</td>
                            <td class="font-monospace fw-semibold {{ $item['status'] === 'expiring' ? 'text-danger' : 'text-dark' }}">
                                {{ $item['expiry_date'] }}
                            </td>
                            <td>
                                @if($item['status'] === 'critical')
                                    <span class="badge bg-rose-soft"><i class="bi bi-exclamation-circle me-1"></i> {{ $item['status_label'] }}</span>
                                @elseif($item['status'] === 'expiring')
                                    <span class="badge bg-amber-soft"><i class="bi bi-clock-history me-1"></i> {{ $item['status_label'] }}</span>
                                @else
                                    <span class="badge bg-emerald-soft"><i class="bi bi-check-circle me-1"></i> {{ $item['status_label'] }}</span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-primary btn-sm py-1 px-2" style="font-size:0.75rem;" onclick="Swal.fire({icon: 'info', title: '{{ $item['name'] }}', text: 'Raf Konumu: {{ $item['shelf'] }} | İTS Barkod: {{ $item['barcode'] }} | Mevcut Stok: {{ $item['stock'] }} Kutu', confirmButtonColor: '#2563eb'})">
                                    <i class="bi bi-info-circle me-1"></i> Detay / İkmal
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ================================================================ -->
    <!-- RESMİ GİB VERGİ DAİRESİ & SGK MEDULA STANDARTLARINDA ECZANE FİŞİ / E-İRSALİYE MODALI -->
    <!-- ================================================================ -->
    @if($prescription)
    <div class="modal fade" id="pharmacyReceiptModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-dark text-white p-2 px-3 no-print">
                    <h6 class="modal-title fw-bold mb-0">
                        <i class="bi bi-receipt-cutoff text-success me-2"></i>
                        T.C. Sağlık Bakanlığı, SGK Medula & GİB Resmi Eczane Satış İrsaliyesi / Periyodik Fişi
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body p-4 bg-white" id="printableReceiptArea">
                    <div class="p-3 border rounded border-2 border-secondary bg-white">
                        
                        <!-- 1. ECZANE KURUMSAL / MÜKELLEF VE VERGİ BİLGİLERİ (GİB STANDARDI) -->
                        <div class="text-center border-bottom pb-3 mb-3">
                            <h4 class="fw-bold text-uppercase mb-1" style="color: #047857; font-family: 'Times New Roman', serif;">T.C. SAĞLIK BAKANLIĞI & SGK MEDULA</h4>
                            <h5 class="fw-bold text-dark mb-1" style="font-family: Arial, sans-serif;">ÖZEL ANKARA ŞEHİR HASTANESİ ECZANESİ</h5>
                            <div class="small text-muted font-monospace">
                                <strong>Sorumlu Eczacı:</strong> Ecz. Sudenaz Hakyemez (Oda Sicil No: 06/12458)<br>
                                <strong>İTS Global Lokasyon Numarası (GLN):</strong> 8680001998811 | <strong>Vergi Dairesi:</strong> Çankaya V.D. — <strong>VKN:</strong> 9870543210<br>
                                <strong>Adres:</strong> Çankaya Mah. Atatürk Bulvarı No: 142/A Çankaya / ANKARA — Tel: 0(312) 418 00 00
                            </div>
                            <div class="mt-2">
                                <span class="badge bg-dark px-2 py-1" style="font-size: 0.72rem;">213 SAYILI VUK MÜKELLEFİYETİNE VE 5510 S.K. MEVZUATINA UYGUN PERAKENDE SATIŞ FİŞİ / İRSALİYESİ</span>
                            </div>
                        </div>

                        <!-- 2. RESMİ EVRAK REFERANS KODLARI & ETTN ZAMAN DAMGASI -->
                        <div class="row g-2 bg-light p-2.5 rounded border mb-3 small font-monospace">
                            <div class="col-6">
                                <strong>Fatura / Fiş Seri No:</strong> <span class="text-success fw-bold" id="receiptNoText">{{ $prescription['receipt_no'] ?? 'FİŞ-2026-889922' }}</span><br>
                                <strong>ETTN (Evrensel Tekil No):</strong> g4d8a1c9-58b2-4f81-9f6e-202607291448<br>
                                <strong>E-Reçete Takip No:</strong> <span class="fw-bold text-dark">{{ $prescription['prescription_code'] ?? '' }}</span><br>
                                <strong>SGK Medula Evrak No:</strong> EVR-2026-994411
                            </div>
                            <div class="col-6 text-end">
                                <strong>Düzenlenme Tarihi & Saati:</strong> <span id="receiptDateText">{{ $prescription['dispense_date'] ?? date('d.m.Y H:i') }}</span><br>
                                <strong>SGK Provizyon No:</strong> <span class="text-primary fw-bold">{{ $prescription['medula_info']['provizyon_no'] ?? 'PRV-2026-994411' }}</span><br>
                                <strong>İTS Karekod İşlem Kodu:</strong> <span class="text-success fw-bold">ITS-OK-2026-884912</span><br>
                                <strong>Teslimat Türü:</strong> Ayaktan İlaç Teslimi
                            </div>
                        </div>

                        <!-- 3. HASTA KİMLİK VE SİGORTA TABLOSU -->
                        <table class="table table-bordered table-sm mb-3 small">
                            <tr class="table-secondary"><th colspan="4" class="text-center fw-bold">HASTA, HEKİM VE SİGORTA BİLGİLERİ</th></tr>
                            <tr>
                                <th width="20%">Hasta Adı Soyadı:</th><td width="30%" class="fw-bold text-dark">{{ $prescription['patient_name'] ?? '' }}</td>
                                <th width="20%">T.C. Kimlik No:</th><td width="30%" class="font-monospace fw-bold">{{ $prescription['national_id'] ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Reçete Eden Hekim:</th><td>{{ $prescription['physician'] ?? '' }}</td>
                                <th>Sosyal Güvence:</th><td><span class="badge bg-secondary">{{ $prescription['sgk_type'] ?? '' }}</span></td>
                            </tr>
                            <tr>
                                <th>Klinik Tanı (ICD-10):</th><td colspan="3" class="fw-bold text-primary">{{ $prescription['diagnosis'] ?? '' }}</td>
                            </tr>
                        </table>

                        <!-- 4. İLAÇ DÖKÜMÜ & KDV HESAPLAMA TABLOSU -->
                        <h6 class="fw-bold text-dark mb-2 small"><i class="bi bi-capsule me-1 text-success"></i> İLAÇ KARŞILAMA VE VERGİ / SGK HESAP DÖKÜMÜ</h6>
                        <table class="table table-bordered align-middle small mb-3">
                            <thead class="table-light text-center">
                                <tr>
                                    <th>S.N.</th>
                                    <th>İlaç Adı & İTS Barkodu</th>
                                    <th>Dozaj / Adet</th>
                                    <th>Perakende Fiyat (KDV Dahil)</th>
                                    <th>KDV Oranı</th>
                                    <th>SGK Hissesi (%80)</th>
                                    <th>Hasta Katılım Payı (%20)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($prescription['drugs'] ?? [] as $index => $drug)
                                <tr>
                                    <td class="text-center font-monospace">{{ $index + 1 }}</td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $drug['name'] }}</div>
                                        <small class="font-monospace text-muted">İTS Barkod: {{ $drug['barcode'] }}</small>
                                    </td>
                                    <td class="text-center">{{ $drug['dosage'] }} ({{ $drug['box'] }} Kutu)</td>
                                    <td class="text-end fw-bold text-dark">{{ $drug['price'] }}</td>
                                    <td class="text-center">%10 KDV</td>
                                    <td class="text-end text-success fw-bold">{{ $drug['sgk_pays'] ?? '-' }}</td>
                                    <td class="text-end text-danger fw-bold">{{ $drug['patient_pays'] ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- 5. VERGİ VE FİNANSAL TOPLAM ÖZETİ (GİB VERGİ DAİRESİ STANDARDI) -->
                        <div class="p-3 bg-light rounded border mb-3">
                            <div class="row g-2 small">
                                <div class="col-md-7 border-end pe-3">
                                    <strong class="text-dark d-block mb-1"><i class="bi bi-info-circle text-primary me-1"></i> SGK Medula ve Vergi Beyanı:</strong>
                                    <div class="text-muted" style="font-size:0.75rem;">
                                        5510 Sayılı SSGSS Kanunu uyarınca SGK Medula sisteminden elektronik onay alınmıştır. İlaçlar İTS (İlaç Takip Sistemi) üzerinden eczane stok düşümü yapılarak hak sahibine teslim edilmiştir. 213 Sayılı Vergi Usul Kanunu uyarınca perakende satış fişi hükmündedir.
                                    </div>
                                </div>
                                <div class="col-md-5 ps-3 font-monospace">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Reçete Brut Tutarı:</span>
                                        <strong class="text-dark">{{ $prescription['medula_info']['total_price'] ?? '142.50 TL' }}</strong>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1 text-muted" style="font-size:0.75rem;">
                                        <span>Hesaplanan KDV (%10):</span>
                                        <span>12.95 TL</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1 text-success">
                                        <span>SGK Karşılanan Pay:</span>
                                        <strong>- {{ $prescription['medula_info']['sgk_coverage'] ?? '114.00 TL' }}</strong>
                                    </div>
                                    <div class="d-flex justify-content-between border-top pt-1 text-danger fw-bold fs-6">
                                        <span>TAHSİL EDİLEN (KDV Dahil):</span>
                                        <span>{{ $prescription['medula_info']['patient_copay'] ?? '28.50 TL' }}</span>
                                    </div>
                                    <div class="text-end text-muted small mt-1" style="font-size:0.7rem;">
                                        Ödeme Şekli: NAKİT / KREDİ KARTI
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 6. RESMİ SORUMLU ECZACI İMZA & İTS ONAY MÜHRÜ -->
                        <div class="row text-center small pt-2 border-top">
                            <div class="col-6">
                                <div class="p-2 border rounded bg-white">
                                    <div class="text-muted" style="font-size:0.7rem;">İTS KAREKOD DÜŞÜM MÜHRÜ</div>
                                    <div class="font-monospace fw-bold text-success"><i class="bi bi-shield-check me-1"></i> ITS-OK-2026-884912</div>
                                    <small class="text-muted" style="font-size:0.68rem;">T.C. Sağlık Bakanlığı İTS Sistem Onaylı</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-2 border rounded bg-white">
                                    <div class="text-muted" style="font-size:0.7rem;">SORUMLU ECZACI İMZA & KAŞE</div>
                                    <div class="fw-bold text-dark">Ecz. Sudenaz Hakyemez</div>
                                    <small class="text-success" style="font-size:0.68rem;"><i class="bi bi-check-circle me-1"></i> E-İmzalı Resmi İrsaliye Fişi</small>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer bg-light p-2 no-print">
                    <button type="button" class="btn btn-primary btn-sm fw-bold px-3 shadow-sm" onclick="printPharmacyReceipt()">
                        <i class="bi bi-printer me-1"></i> Fişi Yazdır / PDF İndir
                    </button>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Kapat</button>
                </div>
            </div>
        </div>
    </div>
    @endif

@endsection

@push('scripts')
<script>
    // 🔴 ANLIK TAB DEĞİŞTİRME FONKSİYONU (SAYFA YENİLENMEDEN 0 MS GECİKMEYLE)
    function switchPharmacyTab(tabName) {
        const tabs = ['dispensing', 'inpatient', 'inventory'];
        tabs.forEach(t => {
            const el = document.getElementById('pharmacy_tab_' + t);
            const btn = document.getElementById('tab_btn_' + t);
            if (el && btn) {
                if (t === tabName) {
                    el.style.display = 'block';
                    btn.className = 'btn btn-sm btn-success fw-bold shadow-sm rounded-pill px-3';
                } else {
                    el.style.display = 'none';
                    btn.className = 'btn btn-sm btn-outline-success fw-semibold rounded-pill px-3';
                }
            }
        });

        // URL query durumunu güncelle
        if (history.replaceState) {
            const newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?tab=' + tabName;
            window.history.replaceState({path: newUrl}, '', newUrl);
        }
    }

    let searchDebounceTimer = null;

    function handlePharmacySearchInput(query) {
        clearTimeout(searchDebounceTimer);
        const dropdown = document.getElementById('pharmacy_search_dropdown');
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
                                <a href="{{ route('pharmacy.index') }}?tab=dispensing&prescription_code=${item.prescription_code}" class="list-group-item list-group-item-action p-2.5 border-0 border-bottom d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-bold text-dark d-flex align-items-center gap-2">
                                            <i class="bi bi-person-circle text-success fs-6"></i> ${item.patient_name}
                                            <span class="badge bg-success-subtle text-success border border-success-subtle font-monospace">${item.prescription_code}</span>
                                        </div>
                                        <div class="text-muted small mt-1" style="font-size:0.75rem;">
                                            <i class="bi bi-card-text me-1"></i> TC: <strong>${item.national_id}</strong> | Poliklinik/Servis: <strong>${item.clinic}</strong>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-light text-dark border mb-1 d-block">${item.physician}</span>
                                        <span class="btn btn-success btn-sm py-0 px-2 fw-semibold" style="font-size:0.72rem;">Sorgula & Gör &rarr;</span>
                                    </div>
                                </a>
                            `;
                        });
                        resultsList.innerHTML = html;
                        matchCountBadge.innerText = data.items.length;
                        dropdown.style.display = 'block';
                    } else {
                        resultsList.innerHTML = `<div class="p-3 text-center text-muted small"><i class="bi bi-exclamation-circle me-1"></i> "${query}" kriterine uygun reçete kaydı bulunamadı.</div>`;
                        matchCountBadge.innerText = '0';
                        dropdown.style.display = 'block';
                    }
                })
                .catch(err => {
                    console.error("Search AJAX error:", err);
                });
        }, 150);
    }

    function handleInpatientSearchInput(query) {
        clearTimeout(searchDebounceTimer);
        const dropdown = document.getElementById('inpatient_search_dropdown');
        const resultsList = document.getElementById('inpatient_results_list');
        const matchCountBadge = document.getElementById('inpatient_match_count');

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
                                <a href="{{ route('pharmacy.index') }}?tab=inpatient&prescription_code=${item.prescription_code}" class="list-group-item list-group-item-action p-2.5 border-0 border-bottom d-flex justify-content-between align-items-center">
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
        const drop1 = document.getElementById('pharmacy_search_dropdown');
        const input1 = document.getElementById('pharmacy_search_input');
        if (drop1 && input1 && !drop1.contains(e.target) && !input1.contains(e.target)) {
            drop1.style.display = 'none';
        }

        const drop2 = document.getElementById('inpatient_search_dropdown');
        const input2 = document.getElementById('inpatient_search_input');
        if (drop2 && input2 && !drop2.contains(e.target) && !input2.contains(e.target)) {
            drop2.style.display = 'none';
        }
    });

    function printPharmacyReceipt() {
        window.print();
    }

    function completeDispensing(type) {
        const prescriptionCode = "{{ $prescription['prescription_code'] ?? '' }}";

        fetch("{{ route('pharmacy.dispense') }}", {
            method: "POST",
            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
            body: JSON.stringify({ prescription_code: prescriptionCode })
        })
        .then(res => res.json())
        .then(data => {
            if (document.getElementById('receiptNoText')) document.getElementById('receiptNoText').innerText = data.receipt_no;
            if (document.getElementById('receiptDateText')) document.getElementById('receiptDateText').innerText = data.dispense_date;

            Swal.fire({
                icon: 'success',
                title: 'Reçete Karşılandı & İlaçlar Teslim Edildi',
                html: 'SGK Medula provizyonu kapatıldı ve İTS Karekod düşümü yapıldı.<br>' +
                      '<strong>İrsaliye Fiş Kodu: ' + data.receipt_no + '</strong><br>' +
                      '<strong>Tahsil Edilen Katılım Payı: {{ $prescription["medula_info"]["patient_copay"] ?? "" }}</strong>',
                showCancelButton: true,
                confirmButtonText: '📄 İrsaliye Fişini Görüntüle ve Yazdır',
                cancelButtonText: 'Tamam',
                confirmButtonColor: '#059669'
            }).then(result => {
                if (result.isConfirmed) {
                    const modalElement = document.getElementById('pharmacyReceiptModal');
                    if (modalElement) {
                        const modal = new bootstrap.Modal(modalElement);
                        modal.show();
                    }
                }
                setTimeout(() => { window.location.reload(); }, 1200);
            });
        });
    }

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
