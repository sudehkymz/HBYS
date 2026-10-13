@extends('layouts.app')

@section('title', 'Taburculuk & Epikriz Raporu')

@push('styles')
<style>
    .discharge-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }
    .form-section-title {
        color: #0d6efd;
        border-bottom: 2px solid #e9ecef;
        padding-bottom: 8px;
        margin-bottom: 20px;
        font-weight: 700;
    }
    .patient-summary-box {
        background-color: #f8f9fa;
        border-left: 4px solid #dc3545;
        border-radius: 6px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-2">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">
                <i class="fa-solid fa-door-open text-danger me-2"></i>Hasta Taburculuk & Epikriz Raporu
            </h1>
            <p class="text-muted mb-0">Yatan hastaların taburculuk işlemlerini tamamlayın ve detaylı epikriz belgesi düzenleyin.</p>
        </div>
        <a href="{{ route('inpatient.admission.index') }}" class="btn btn-outline-secondary">
            <i class="fa-solid fa-arrow-left me-1"></i>Yatak Paneline Dön
        </a>
    </div>

    <div class="row g-4">
        <!-- Form Column -->
        <div class="col-lg-8 col-12">
            <div class="card discharge-card shadow-sm p-4 mb-4">
                <form action="{{ route('inpatient.discharge.store') }}" method="POST" id="dischargeForm">
                    @csrf
                    
                    <!-- Patient Select -->
                    <div class="mb-4">
                        <label for="admission_id" class="form-label fw-bold">Taburcu Edilecek Hasta Seçimi <span class="text-danger">*</span></label>
                        <select class="form-select form-select-lg @error('admission_id') is-invalid @enderror" id="admission_id" name="admission_id" required onchange="handlePatientSelect(this)">
                            <option value="" disabled {{ !$selectedAdmission ? 'selected' : '' }}>-- Taburcu Edilecek Aktif Yatan Hastayı Seçin --</option>
                            @foreach($admissions as $adm)
                                <option value="{{ $adm['id'] }}" 
                                    data-national="{{ $adm['national_id'] }}"
                                    data-age="{{ $adm['age'] }}"
                                    data-gender="{{ $adm['gender'] }}"
                                    data-service="{{ $adm['service'] }}"
                                    data-room="{{ $adm['room'] }}"
                                    data-bed="{{ $adm['bed'] }}"
                                    data-date="{{ $adm['admission_date'] }}"
                                    data-diagnosis="{{ $adm['diagnosis'] }}"
                                    data-physician="{{ $adm['attending_physician'] }}"
                                    {{ ($selectedAdmission && $selectedAdmission['id'] == $adm['id']) ? 'selected' : '' }}>
                                    {{ $adm['patient_name'] }} (TC: {{ $adm['national_id'] }} - Oda: {{ $adm['room'] }})
                                </option>
                            @endforeach
                        </select>
                        @error('admission_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Accordion Form Sections -->
                    <div class="accordion" id="epicrisisAccordion">
                        
                        <!-- SECTION 1: Taburculuk Bilgileri -->
                        <div class="accordion-item border-0 mb-3 shadow-sm rounded">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button rounded fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <i class="fa-solid fa-door-open me-2 text-danger"></i>1. Taburculuk Genel Bilgileri
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#epicrisisAccordion">
                                <div class="accordion-body bg-white p-4">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="discharge_date" class="form-label fw-semibold">Taburcu Tarihi/Saati <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="discharge_date" name="discharge_date" value="{{ now()->format('d.m.Y H:i') }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="discharge_status" class="form-label fw-semibold">Taburculuk Durumu <span class="text-danger">*</span></label>
                                            <select class="form-select" id="discharge_status" name="discharge_status" required>
                                                <option value="Şifa" selected>Şifa (Tam İyileşme)</option>
                                                <option value="Düzelme">Düzelme (Kısmi İyileşme)</option>
                                                <option value="Haliyle Taburcu">Haliyle Taburcu (Evde Bakım)</option>
                                                <option value="Kendi İsteğiyle Ayrılma">Kendi İsteğiyle Ayrılma</option>
                                                <option value="Başka Hastaneye Sevk">Başka Hastaneye Sevk</option>
                                                <option value="Yoğun Bakıma Transfer">Yoğun Bakıma Transfer</option>
                                                <option value="Eks">Eks (Vefat)</option>
                                                <option value="Tedaviyi Reddetme">Tedaviyi Reddetme</option>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label for="discharge_diagnosis" class="form-label fw-semibold">Taburculuk Çıkış Tanısı <span class="text-danger">*</span></label>
                                            <textarea class="form-control" id="discharge_diagnosis" name="discharge_diagnosis" rows="2" placeholder="Hastanın kesin çıkış tanısı..." required></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 2: Yapılan Tıbbi ve Cerrahi İşlemler -->
                        <div class="accordion-item border-0 mb-3 shadow-sm rounded">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed rounded fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <i class="fa-solid fa-stethoscope me-2 text-primary"></i>2. Tedavi Süreci ve İşlemler
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#epicrisisAccordion">
                                <div class="accordion-body bg-white p-4">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label for="procedures" class="form-label fw-semibold">Yapılan Tıbbi İşlemler ve Tedaviler <span class="text-danger">*</span></label>
                                            <textarea class="form-control" id="procedures" name="procedures" rows="2" placeholder="Yatış boyunca uygulanan tedaviler, medikal işlemler..." required></textarea>
                                        </div>
                                        <div class="col-12">
                                            <label for="surgeries" class="form-label fw-semibold">Ameliyat / Cerrahi Girişimler (Varsa)</label>
                                            <textarea class="form-control" id="surgeries" name="surgeries" rows="2" placeholder="Örn: Laparoskopik Kresentik Kolesistektomi (Tarih: 25.07.2026)"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 3: Laboratuvar ve Radyoloji Sonuçları -->
                        <div class="accordion-item border-0 mb-3 shadow-sm rounded">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed rounded fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <i class="fa-solid fa-flask me-2 text-warning"></i>3. Tetkik ve Sonuç Özetleri
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#epicrisisAccordion">
                                <div class="accordion-body bg-white p-4">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="lab_summary" class="form-label fw-semibold">Laboratuvar Sonuç Özeti</label>
                                            <textarea class="form-control" id="lab_summary" name="lab_summary" rows="3" placeholder="Kritik laboratuvar kan, idrar vb. sonuçları..."></textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="radiology_summary" class="form-label fw-semibold">Radyoloji / PACS Görüntüleme Özeti</label>
                                            <textarea class="form-control" id="radiology_summary" name="radiology_summary" rows="3" placeholder="Röntgen, BT, MR veya ultrason bulguları..."></textarea>
                                        </div>
                                        <div class="col-12">
                                            <label for="pathology_summary" class="form-label fw-semibold">Patoloji Bulguları (Varsa)</label>
                                            <textarea class="form-control" id="pathology_summary" name="pathology_summary" rows="2" placeholder="Varsa biyopsi veya patoloji sonuçları..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 4: İlaç Değişiklikleri ve Ev Reçetesi -->
                        <div class="accordion-item border-0 mb-3 shadow-sm rounded">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed rounded fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    <i class="fa-solid fa-pills me-2 text-info"></i>4. İlaç Yönetimi & Taburcu Reçetesi
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#epicrisisAccordion">
                                <div class="accordion-body bg-white p-4">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="active_medications" class="form-label fw-semibold">Yatış Sırasında Devam Eden İlaçlar</label>
                                            <textarea class="form-control" id="active_medications" name="active_medications" rows="2" placeholder="Kullanılmaya devam edilecek rutin ilaçlar..."></textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="stopped_medications" class="form-label fw-semibold">Yatışta Kesilen (Stoplanan) İlaçlar</label>
                                            <textarea class="form-control" id="stopped_medications" name="stopped_medications" rows="2" placeholder="Bu yatışla birlikte kullanımı durdurulan ilaçlar..."></textarea>
                                        </div>
                                        <div class="col-12">
                                            <label for="discharge_medications" class="form-label fw-semibold">Evde Kullanılacak Taburcu İlaçları (Reçete) <span class="text-danger">*</span></label>
                                            <textarea class="form-control" id="discharge_medications" name="discharge_medications" rows="3" placeholder="Hastanın evde kullanması gereken ilaç listesi, dozu ve kullanım sıklığı..." required></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 5: Evde Bakım, Beslenme ve Kontrol Planı -->
                        <div class="accordion-item border-0 mb-4 shadow-sm rounded">
                            <h2 class="accordion-header" id="headingFive">
                                <button class="accordion-button collapsed rounded fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    <i class="fa-solid fa-clipboard-list me-2 text-success"></i>5. Öneriler & Kontrol Randevusu
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#epicrisisAccordion">
                                <div class="accordion-body bg-white p-4">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="nutrition_recommendations" class="form-label fw-semibold">Beslenme ve Diyet Önerileri</label>
                                            <textarea class="form-control" id="nutrition_recommendations" name="nutrition_recommendations" rows="2" placeholder="Örn: Yağsız diyet, bol sıvı alımı, tuz kısıtlaması..."></textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="activity_recommendations" class="form-label fw-semibold">Aktivite ve İstirahat Önerileri</label>
                                            <textarea class="form-control" id="activity_recommendations" name="activity_recommendations" rows="2" placeholder="Örn: 10 gün ağır kaldırmama, yatak istirahati..."></textarea>
                                        </div>
                                        <div class="col-12">
                                            <label for="wound_care" class="form-label fw-semibold">Yara Bakımı ve Pansuman Bilgisi</label>
                                            <textarea class="form-control" id="wound_care" name="wound_care" rows="2" placeholder="Örn: Gün aşırı batikonlu pansuman, dikişlerin alınma tarihi..."></textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="follow_up_date" class="form-label fw-semibold">Kontrol Randevu Tarihi</label>
                                            <input type="date" class="form-control" id="follow_up_date" name="follow_up_date">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="follow_up_clinic" class="form-label fw-semibold">Kontrol Randevu Kliniği</label>
                                            <select class="form-select" id="follow_up_clinic" name="follow_up_clinic">
                                                <option value="" disabled selected>Klinik Seçin</option>
                                                <option value="Genel Cerrahi Polikliniği">Genel Cerrahi Polikliniği</option>
                                                <option value="İç Hastalıkları (Dahiliye) Polikliniği">İç Hastalıkları Polikliniği</option>
                                                <option value="Kadın Hastalıkları ve Doğum Polikliniği">Kadın Doğum Polikliniği</option>
                                                <option value="Çocuk Sağlığı ve Hastalıkları Polikliniği">Çocuk Sağlığı Polikliniği</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Form Action -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-danger btn-lg rounded-pill fw-bold py-3 shadow" id="submitBtn" {{ !$selectedAdmission ? 'disabled' : '' }}>
                            <i class="fa-solid fa-file-signature me-2"></i>Epikriz Raporunu İmzala ve Hastayı Taburcu Et
                        </button>
                    </div>

                </form>
            </div>
        </div>

        <!-- Inpatient Info Column (Right Column) -->
        <div class="col-lg-4 col-12">
            <div class="card discharge-card shadow-sm p-4 h-100 bg-white">
                <h5 class="fw-bold text-secondary mb-3"><i class="fa-solid fa-id-card me-2"></i>Yatış Detay Kartı</h5>
                
                <div id="patientDetailsPanel" class="{{ !$selectedAdmission ? 'd-none' : '' }}">
                    <div class="patient-summary-box p-3 mb-3">
                        <h6 class="fw-bold text-danger mb-1" id="panelName">{{ $selectedAdmission ? $selectedAdmission['patient_name'] : '-' }}</h6>
                        <small class="text-muted d-block" id="panelNational">TC: {{ $selectedAdmission ? $selectedAdmission['national_id'] : '-' }}</small>
                        <small class="text-muted" id="panelAgeGender">{{ $selectedAdmission ? $selectedAdmission['age'] . ' Yaş / ' . $selectedAdmission['gender'] : '-' }}</small>
                    </div>

                    <ul class="list-group list-group-flush mb-4" style="font-size: 0.9rem;">
                        <li class="list-group-item d-flex justify-content-between p-2">
                            <span class="text-muted">Servis:</span>
                            <span class="fw-bold" id="panelService">{{ $selectedAdmission ? $selectedAdmission['service'] : '-' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between p-2">
                            <span class="text-muted">Yatak/Oda:</span>
                            <span class="fw-bold" id="panelBedRoom">{{ $selectedAdmission ? 'Oda ' . $selectedAdmission['room'] . ' / Yatak ' . $selectedAdmission['bed'] : '-' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between p-2">
                            <span class="text-muted">Yatış Tarihi:</span>
                            <span class="fw-bold" id="panelDate">{{ $selectedAdmission ? $selectedAdmission['admission_date'] : '-' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between p-2">
                            <span class="text-muted">Sorumlu Hekim:</span>
                            <span class="fw-bold text-primary" id="panelPhysician">{{ $selectedAdmission ? $selectedAdmission['attending_physician'] : '-' }}</span>
                        </li>
                        <li class="list-group-item p-2">
                            <span class="text-muted d-block mb-1">Giriş / Yatış Tanısı:</span>
                            <div class="bg-light p-2 rounded small" id="panelDiagnosis">{{ $selectedAdmission ? $selectedAdmission['diagnosis'] : '-' }}</div>
                        </li>
                    </ul>

                    <div class="alert alert-info py-2" style="font-size: 0.85rem;">
                        <i class="fa-solid fa-circle-exclamation me-1"></i>Taburcu işlemi onaylandığında, hastanın yatağı otomatik olarak <strong>Temizlik Bekliyor</strong> durumuna getirilecektir.
                    </div>
                </div>

                <div id="noPatientPanel" class="text-center py-5 text-muted {{ $selectedAdmission ? 'd-none' : '' }}">
                    <i class="fa-solid fa-user-injured fa-3x mb-3 opacity-30"></i>
                    <p class="mb-0">Ayrıntıları görmek ve formu aktifleştirmek için lütfen soldan bir hasta seçin.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Handles patient select dropdown changes to update summary card on the right
    function handlePatientSelect(select) {
        const selectedOption = select.options[select.selectedIndex];
        
        if (selectedOption.value) {
            const national = selectedOption.getAttribute('data-national');
            const age = selectedOption.getAttribute('data-age');
            const gender = selectedOption.getAttribute('data-gender');
            const service = selectedOption.getAttribute('data-service');
            const room = selectedOption.getAttribute('data-room');
            const bed = selectedOption.getAttribute('data-bed');
            const date = selectedOption.getAttribute('data-date');
            const diagnosis = selectedOption.getAttribute('data-diagnosis');
            const physician = selectedOption.getAttribute('data-physician');
            const name = selectedOption.textContent.split('(TC:')[0].trim();

            // Update details panel
            document.getElementById('panelName').textContent = name;
            document.getElementById('panelNational').textContent = `TC: ${national}`;
            document.getElementById('panelAgeGender').textContent = `${age} Yaş / ${gender}`;
            document.getElementById('panelService').textContent = service;
            document.getElementById('panelBedRoom').textContent = `Oda ${room} / Yatak ${bed}`;
            document.getElementById('panelDate').textContent = date;
            document.getElementById('panelPhysician').textContent = physician;
            document.getElementById('panelDiagnosis').textContent = diagnosis;

            // Trigger visual transitions
            document.getElementById('noPatientPanel').classList.add('d-none');
            document.getElementById('patientDetailsPanel').classList.remove('d-none');
            document.getElementById('submitBtn').disabled = false;
        } else {
            document.getElementById('noPatientPanel').classList.remove('d-none');
            document.getElementById('patientDetailsPanel').classList.add('d-none');
            document.getElementById('submitBtn').disabled = true;
        }
    }
</script>
@endpush
