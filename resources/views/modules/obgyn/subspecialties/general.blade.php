@extends('modules.obgyn.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-baby-carriage me-2" style="color: #ec4899;"></i>Kadın Hastalıkları, Doğum & Yenidoğan Polikliniği (Ana Branş)
@endsection

@section('page_description')
    Gestasyonel hafta biometrisi, EFW tahmini bebek ağırlığı, NST takip, gebelik kaydı, doğum girişi & yenidoğan kartı yönetimi.
@endsection

@section('obgyn_workspace')
<!-- Navigation Tabs for Obstetrics Workflow -->
<ul class="nav nav-tabs mb-4 border-bottom-0" id="obgynMainTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active fw-bold text-dark border-top-0 border-start-0 border-end-0 border-4 border-pink" id="tab-usg-btn" data-bs-toggle="tab" data-bs-target="#tab-usg" type="button" role="tab">
            <i class="fa-solid fa-baby-carriage me-2" style="color: #ec4899;"></i>1. USG Biyometri & NST Takip
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link fw-bold text-dark border-top-0 border-start-0 border-end-0 border-4" id="tab-pregnancy-btn" data-bs-toggle="tab" data-bs-target="#tab-pregnancy" type="button" role="tab">
            <i class="fa-solid fa-file-waveform me-2 text-primary"></i>2. Gebelik & Takip Kaydı
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link fw-bold text-dark border-top-0 border-start-0 border-end-0 border-4" id="tab-delivery-btn" data-bs-toggle="tab" data-bs-target="#tab-delivery" type="button" role="tab">
            <i class="fa-solid fa-baby me-2 text-success"></i>3. Doğum Girişi & Yenidoğan Kartı
        </button>
    </li>
</ul>

<div class="tab-content" id="obgynMainTabContent">
    <!-- TAB 1: USG BIOMETRY & NST TAKİP -->
    <div class="tab-pane fade show active" id="tab-usg" role="tabpanel">
        <div class="row g-4 mb-4">
            <!-- Obstetric USG Biometry Card -->
            <div class="col-md-6">
                <div class="card obgyn-card h-100 border-start border-4" style="border-left-color: #ec4899 !important;">
                    <div class="card-header bg-white border-0 py-3">
                        <h6 class="fw-bold mb-0" style="color: #ec4899;"><i class="fa-solid fa-baby-carriage me-2"></i>Obstetrik USG Fetal Biyometri</h6>
                    </div>
                    <div class="card-body pt-0">
                        <div class="p-3 bg-light rounded border mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="small fw-bold">Gestasyonel Yaş (GA):</span>
                                <span class="badge bg-primary fs-6">32 Hafta 4 Gün (SAT Uyumlu)</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="small fw-bold">BPD (Biparietal Çap):</span>
                                <span class="fw-bold text-dark">82 mm (32 Hafta 2 Gün)</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="small fw-bold">FL (Femur Boyu) / AC:</span>
                                <span class="fw-bold text-dark">FL: 61 mm, AC: 278 mm</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="small fw-bold">EFW (Tahmini Bebek Ağırlığı):</span>
                                <span class="badge bg-success fs-6">1950 gram (Hadlock Formülü %50 Persentil)</span>
                            </div>
                        </div>

                        <div class="p-2 rounded border small text-dark" style="background-color: #fce7f3; border-color: #fbcfe8 !important;">
                            <i class="fa-solid fa-circle-check me-1" style="color: #ec4899;"></i><strong>Amniyotik Sıvı (AFI):</strong> Amniyotik Mayi İndeksi 14 cm (Normohidramniyoz), Plasenta Anterior Yerleşimli.
                        </div>
                    </div>
                </div>
            </div>

            <!-- NST Non-Stress Test & Cervical Smear Card -->
            <div class="col-md-6">
                <div class="card obgyn-card h-100 border-start border-4 border-warning">
                    <div class="card-header bg-white border-0 py-3">
                        <h6 class="fw-bold text-warning-emphasis mb-0"><i class="fa-solid fa-heart-pulse me-2"></i>NST (Non-Stres Test) & Servikal Smear</h6>
                    </div>
                    <div class="card-body pt-0">
                        <div class="p-3 bg-light rounded border mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="small fw-bold">NST (Non-Stres Test) Yanıtı:</span>
                                <span class="badge bg-success fs-6">NST Reaktif (Fetal Kalp Hızı: 142 bpm)</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="small fw-bold">Fetal Akselerasyon Sayısı:</span>
                                <span class="badge bg-primary">20 Dakikada 3 Akselerasyon (+)</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="small fw-bold">Uterin Kontraksiyon (Tokometre):</span>
                                <span class="badge bg-success">Uterin Ağrı/Kasılma Yok (Aktivite Negatif)</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="small fw-bold">Servikal PAP Smear Taraması:</span>
                                <span class="fw-bold text-dark">Bethesda Sınıflaması: Benign / Negatif</span>
                            </div>
                        </div>

                        <div class="p-2 bg-warning-subtle rounded border border-warning small text-dark">
                            <strong>Routine Gebelik Takibi:</strong> 36. Haftada Grubu B Streptokok (GBS) Vajinal Kültürü Planlandı.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Exam Form -->
        <div class="card obgyn-card mb-4">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="fw-bold text-dark mb-0">
                    <i class="fa-solid fa-file-medical me-2" style="color: #ec4899;"></i>Kadın Doğum Muayene & USG Biyometri Formu
                </h5>
            </div>
            <div class="card-body pt-0">
                <form action="{{ route('obgyn.store_exam') }}" method="POST">
                    @csrf
                    <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
                    <input type="hidden" name="sub_specialty" value="general">
                    <input type="hidden" name="redirect_route" value="obgyn.index">

                    <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Gebelik Teşhisi & Gestasyonel Yaş</label>
                            <input type="text" name="diagnosis" class="form-control fw-bold border-pink" style="border-color: #ec4899 !important; color: #ec4899;" value="32H4D Gebelik - Obstetrik USG EFW: 1950gr (NST Reaktif)">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Reçete Edilen Destek / Takviye</label>
                            <select name="sub_specialty_data[obgyn_med]" class="form-select">
                                <option value="Demir (Ferro Sanol) + Folik Asit + Multivitamin">Ferro Sanol + Folik Asit + Multivitamin</option>
                                <option value="Kalsiyum D3 + Magnezyum Sitrat 250mg">Kalsiyum D3 + Magnezyum Sitrat</option>
                                <option value="Progesteron 200mg Vajinal Ovül (Erken Doğum Önleme)">Progesteron 200mg Vajinal Ovül</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">EFW Bebek Ağırlığı & AFI Mayi</label>
                            <input type="text" name="sub_specialty_data[efw_afi]" class="form-control" value="EFW: 1950 gr (%50 Persentil), AFI: 14 cm Normal">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Kadın Doğum Hekimi Muayene & USG Notları</label>
                        <textarea name="notes" class="form-control" rows="4" required placeholder="Fetal kalp atımı, prezentasyon (sefalik/makat), plasenta lokalizasyonu, servikal uzunluk ölçümü (transvajinal USG mm), NST akselerasyon kaydı ve doğum şekli planlaması..."></textarea>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Kadın Doğum Hekimi: Prof. Dr. Ayşe Şevket</span>
                        <button type="submit" class="btn text-white fw-bold px-4 py-2" style="background-color: #ec4899;">
                            <i class="fa-solid fa-floppy-disk me-2"></i>Kadın Doğum Kaydını Onayla
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- TAB 2: GEBELİK & TAKİP KAYDI (Obstetrics Inpatient Feature) -->
    <div class="tab-pane fade" id="tab-pregnancy" role="tabpanel">
        <div class="row">
            <div class="col-md-6 col-12 mb-4">
                <div class="card obgyn-card p-4 h-100 border-start border-4 border-primary">
                    <h5 class="fw-bold text-primary mb-3"><i class="fa-solid fa-notes-medical me-2"></i>Gebelik Takip Formu</h5>
                    <form action="{{ route('obgyn.store_exam') }}" method="POST">
                        @csrf
                        <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
                        <input type="hidden" name="sub_specialty" value="pregnancy_tracking">
                        <input type="hidden" name="redirect_route" value="obgyn.index">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Son Adet Tarihi (SAT / LMP)</label>
                            <input type="text" class="form-control" name="sub_specialty_data[lmp]" value="15.10.2025" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Gebelik Haftası</label>
                            <input type="number" class="form-control" name="sub_specialty_data[week]" value="32" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Risk Seviyesi</label>
                            <select class="form-select" name="sub_specialty_data[risk]" required>
                                <option value="Normal (Düşük Risk)">Normal (Düşük Risk)</option>
                                <option value="Yüksek Riskli (Preeklampsi / Gestasyonel Diyabet)">Yüksek Riskli (Preeklampsi / Gestasyonel Diyabet)</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Sorumlu Ebe / Hemşire</label>
                            <input type="text" class="form-control" name="sub_specialty_data[midwife]" value="Ebe Fatma Şen" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 fw-bold">
                            <i class="fa-solid fa-save me-1"></i>Gebelik Kaydını Güncelle
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-md-6 col-12 mb-4">
                <div class="card obgyn-card p-4 h-100 bg-light border">
                    <h5 class="fw-bold text-secondary mb-3"><i class="fa-solid fa-info-circle me-2"></i>Aktif Gebelik Takip Özeti</h5>
                    <div class="bg-white p-3 rounded border">
                        <p class="mb-2"><strong>Hasta Adı:</strong> {{ $selectedAdmission['patient_name'] }}</p>
                        <p class="mb-2"><strong>Son Adet Tarihi (SAT):</strong> 15.10.2025</p>
                        <p class="mb-2"><strong>Gestasyonel Hafta:</strong> 32 Hafta 4 Gün</p>
                        <p class="mb-2"><strong>Risk Seviyesi:</strong> <span class="badge bg-success">Normal (Düşük Risk)</span></p>
                        <p class="mb-2"><strong>Sorumlu Ebe:</strong> Ebe Fatma Şen</p>
                        <p class="mb-0"><strong>Takip Durumu:</strong> <span class="badge text-white" style="background-color: #ec4899;">Doğum Bekleniyor</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 3: DOĞUM GİRİŞİ & YENİDOĞAN KARTI (Obstetrics Inpatient Feature) -->
    <div class="tab-pane fade" id="tab-delivery" role="tabpanel">
        <div class="row">
            <div class="col-md-6 col-12 mb-4">
                <div class="card obgyn-card p-4 h-100 border-start border-4 border-success">
                    <h5 class="fw-bold text-success mb-3"><i class="fa-solid fa-baby me-2"></i>Doğum Girişi & Yenidoğan Kaydı</h5>
                    <form action="{{ route('obgyn.store_exam') }}" method="POST">
                        @csrf
                        <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
                        <input type="hidden" name="sub_specialty" value="delivery_record">
                        <input type="hidden" name="redirect_route" value="obgyn.index">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Doğum Tarihi & Saat</label>
                            <input type="text" class="form-control" name="sub_specialty_data[birth_date]" value="{{ now()->format('d.m.Y H:i') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Bebek Cinsiyeti</label>
                            <select class="form-select" name="sub_specialty_data[baby_gender]" required>
                                <option value="Kız">Kız</option>
                                <option value="Erkek">Erkek</option>
                            </select>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label fw-semibold">Doğum Ağırlığı</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="sub_specialty_data[weight]" value="3250" required>
                                    <span class="input-group-text">gr</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold">Boy</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="sub_specialty_data[height]" value="50" required>
                                    <span class="input-group-text">cm</span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">APGAR Skoru (1. / 5. Dakika)</label>
                            <input type="text" class="form-control" name="sub_specialty_data[apgar]" value="9 / 10" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Nöbetçi Çocuk Uzmanı</label>
                            <input type="text" class="form-control" name="sub_specialty_data[pediatrician]" value="Dr. Selin Saygı (Pediatri)" required>
                        </div>

                        <button type="submit" class="btn btn-success w-100 fw-bold">
                            <i class="fa-solid fa-check me-1"></i>Doğumu Kaydet & Yenidoğan Kartı Aç
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-md-6 col-12 mb-4">
                <div class="card obgyn-card p-4 h-100 bg-light border">
                    <h5 class="fw-bold text-secondary mb-3"><i class="fa-solid fa-child-dress me-2"></i>Doğum & Yenidoğan Kartı Durumu</h5>
                    <div class="alert alert-success border-0 shadow-sm mb-3">
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-circle-check fs-4 me-3"></i>
                            <div>
                                <h6 class="fw-bold mb-0">Doğum & Yenidoğan Kaydı Aktif</h6>
                                <p class="mb-0 small">Bebek Bileklik Barkodu ve Yenidoğan İşitme Taraması Tanımlandı.</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-3 bg-white rounded border small">
                        <p class="mb-1"><strong>Anne Adı:</strong> {{ $selectedAdmission['patient_name'] }}</p>
                        <p class="mb-1"><strong>Bebek Barkod kODU:</strong> YND-2026-{{ $selectedAdmission['id'] }}</p>
                        <p class="mb-1"><strong>APGAR Performansı:</strong> 9/10 (Optimal Vital Bulgular)</p>
                        <p class="mb-0"><strong>K Vitamini & Göz Damlası:</strong> Tamamlandı (Topuk Kanı Taraması Planlandı)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
