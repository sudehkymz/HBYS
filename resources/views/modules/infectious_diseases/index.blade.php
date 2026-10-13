@extends('layouts.app')

@push('styles')
<style>
    .inf-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        background: #fff;
    }
    .patient-item {
        transition: all 0.2s ease;
        border-left: 4px solid transparent;
    }
    .patient-item:hover {
        background-color: #f8f9fa;
    }
    .patient-item.active {
        background-color: #fef2f2;
        border-left-color: #dc2626;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-3">
    <!-- Infectious Diseases Main Department Header Banner -->
    <div class="card inf-card mb-4 bg-white border-top border-4 border-danger">
        <div class="card-body p-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-danger-subtle p-3 d-flex align-items-center justify-content-center text-danger" style="width: 52px; height: 52px;">
                        <i class="fa-solid fa-shield-virus fa-2x"></i>
                    </div>
                    <div>
                        <h2 class="h4 mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                            <i class="fa-solid fa-bacteria text-danger"></i>Enfeksiyon Hastalıkları ve Klinik Mikrobiyoloji
                        </h2>
                        <p class="text-muted small mb-0">Kültür antibiyogram duyarlılığı, kısıtlı antibiyotik onayı (KUP), viral yük paneli (HBV/HIV) & sepsis izlemi.</p>
                    </div>
                </div>

                <div class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 fs-6 rounded-pill">
                    <i class="fa-solid fa-vial-virus me-1"></i>Klinik Mikrobiyoloji & İzolasyon Servisi
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- Patient List Column -->
        <div class="col-lg-4 col-12 mb-4">
            <div class="card inf-card h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-hospital-user me-2 text-danger"></i>Enfeksiyon Hasta Başvuruları
                    </h5>
                    <span class="badge bg-danger-subtle text-danger rounded-pill">{{ count($infAdmissions) }} Hasta</span>
                </div>
                <div class="list-group list-group-flush" style="max-height: 750px; overflow-y: auto;">
                    @forelse($infAdmissions as $adm)
                        <a href="{{ route('infectious_diseases.index', ['admission_id' => $adm['id']]) }}" 
                           class="list-group-item list-group-item-action patient-item py-3 {{ ($selectedAdmission && $selectedAdmission['id'] == $adm['id']) ? 'active' : '' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-1 text-dark">{{ $adm['patient_name'] }}</h6>
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle">{{ $adm['age'] }} Yaş</span>
                            </div>
                            <div class="text-muted small mt-1">
                                <div><i class="fa-solid fa-building me-1"></i><strong>{{ $adm['service'] }}</strong></div>
                                <div class="fw-medium text-secondary mt-1"><i class="fa-solid fa-notes-medical me-1"></i>{{ $adm['diagnosis'] }}</div>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="fa-solid fa-hospital-user fa-3x mb-3 opacity-30"></i>
                            <p>Aktif hasta bulunmamaktadır.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Main Workspace Column -->
        <div class="col-lg-8 col-12">
            @if($selectedAdmission)
                <!-- Active Patient Dossier Card -->
                <div class="card inf-card mb-4 border-start border-danger border-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-danger text-white mb-2">Aktif Enfeksiyon Hasta Dosyası</span>
                                <h3 class="fw-bold text-dark mb-1">{{ $selectedAdmission['patient_name'] }}</h3>
                                <p class="text-muted small mb-0">
                                    <strong>T.C.:</strong> {{ $selectedAdmission['national_id'] }} | 
                                    <strong>Yaş/Cinsiyet:</strong> {{ $selectedAdmission['age'] }} Yaş ({{ $selectedAdmission['gender'] }}) | 
                                    <strong>Oda/Birim:</strong> {{ $selectedAdmission['room'] }}
                                </p>
                                <div class="mt-2 p-2 bg-light rounded border small">
                                    <i class="fa-solid fa-user-doctor text-danger me-1"></i>
                                    <strong>Enfeksiyon Uzmanı:</strong> {{ $selectedAdmission['attending_physician'] }} | 
                                    <strong>Tanı:</strong> {{ $selectedAdmission['diagnosis'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Infectious Diseases Specific Workspace Cards -->
                <div class="row g-4 mb-4">
                    <!-- Culture Antibiogram & Antimicrobial Susceptibility Card -->
                    <div class="col-md-6">
                        <div class="card inf-card h-100 border-start border-4 border-danger">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-danger mb-0"><i class="fa-solid fa-vial-virus me-2"></i>Kültür & Antibiyogram Duyarlılık Paneli</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Üreyen Mikroorganizma:</span>
                                        <span class="badge bg-danger">Klebsiella pneumoniae (ESBL +)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Meropenem (Carbapenem):</span>
                                        <span class="badge bg-success">Hassas (S) - MIC: 0.25 µg/mL</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Sefotaksim / Sefepim:</span>
                                        <span class="badge bg-danger">Dirençli (R) - MIC: >16 µg/mL</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">Kolistin (Colistin):</span>
                                        <span class="badge bg-success">Hassas (S) - MIC: 0.5 µg/mL</span>
                                    </div>
                                </div>

                                <div class="p-2 bg-danger-subtle rounded border border-danger-subtle small text-dark">
                                    <i class="fa-solid fa-shield-virus me-1"></i><strong>Direnç Profili:</strong> Genişletilmiş Spektrumlu Beta-Laktamaz (ESBL) Pozitif Saptandı.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Restricted Antibiotic Approval (KUP Form) Card -->
                    <div class="col-md-6">
                        <div class="card inf-card h-100 border-start border-4 border-warning">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-warning-emphasis mb-0"><i class="fa-solid fa-file-signature me-2"></i>Kısıtlı Antibiyotik Onayı (KUP Masası)</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Talep Edilen Antibiyotik:</span>
                                        <span class="fw-bold text-dark">Meropenem 1g IV İnfizyon (3x1)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">KUP Formu Onay Durumu:</span>
                                        <span class="badge bg-success">Enfeksiyon Uzmanı Tarafından Onaylandı</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Tedavi Süresi Sınırı:</span>
                                        <span class="fw-bold text-dark">7 Gün (Revizyon Tarihi: 12.08.2026)</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">Prokalsitonin (PCT) Düzeyi:</span>
                                        <span class="badge bg-danger">PCT: 4.8 ng/mL (Sepsis Göstergesi)</span>
                                    </div>
                                </div>

                                <div class="p-2 bg-warning-subtle rounded border border-warning small text-dark">
                                    <strong>İzolasyon Önlemi:</strong> Temas İzolasyonu & Tek Yataklı Özel İzolasyon Odası Kararı Alındı.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Second Row: Chronic Viral Load (HBV/HIV) & Sepsis Monitor Cards -->
                <div class="row g-4 mb-4">
                    <!-- Chronic Viral Load & Antiviral Panel Card -->
                    <div class="col-md-6">
                        <div class="card inf-card h-100 border-start border-4 border-primary">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-dna me-2"></i>HBV / HCV / HIV Viral Yük Paneli</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">HBV DNA Viral Yük:</span>
                                        <span class="badge bg-danger">4.2 x 10^6 IU/mL (Yüksek Yük)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">HBeAg / Anti-HBe:</span>
                                        <span class="badge bg-warning text-dark">HBeAg Pozitif (Aktif Replikasyon)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">CD4+ T-Lenfosit Sayısı:</span>
                                        <span class="fw-bold text-dark">480 hücre/µL (%28)</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">HIV RNA Viral Yük:</span>
                                        <span class="badge bg-success">Saptanamadı (<20 kopya/mL)</span>
                                    </div>
                                </div>

                                <div class="p-2 bg-primary-subtle rounded border border-primary-subtle small text-dark">
                                    <strong>Antiviral Reçete:</strong> Tenofovir Alafenamid (TAF 25mg 1x1) Kesintisiz Tedavi Planlandı.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SOFA Sepsis Monitor & Travel Vaccination Card -->
                    <div class="col-md-6">
                        <div class="card inf-card h-100 border-start border-4 border-dark">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-dark mb-0"><i class="fa-solid fa-temperature-arrow-up me-2"></i>SOFA Sepsis Monitorü & Seyahat Aşıları</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">qSOFA Sepsis Skoru:</span>
                                        <span class="badge bg-warning text-dark">1 / 3 Puan (Düşük/Orta Risk)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Kanda Laktat Düzeyi:</span>
                                        <span class="fw-bold text-danger">Laktat: 2.4 mmol/L (Doku Perfüzyon Takibi)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Sarı Humma Aşı Karnesi:</span>
                                        <span class="badge bg-success">Uluslararası Aşı Karnesi Verildi</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">Kuduz Temas Proflaksisi:</span>
                                        <span class="small text-muted">RIG + 4 Doz Aşı Şeması Uygulandı</span>
                                    </div>
                                </div>

                                <div class="p-2 bg-dark-subtle rounded border border-dark-subtle small text-dark">
                                    <strong>Ateş Etiyolojisi (FUO):</strong> Kümeler Halinde Kan Kültürleri Tekrarlandı.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Form -->
                <div class="card inf-card mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="fa-solid fa-file-medical me-2 text-danger"></i>Enfeksiyon Hastalıkları Konsültasyon & KUP Formu
                        </h5>
                    </div>
                    <div class="card-body pt-0">
                        <form action="{{ route('infectious_diseases.store_exam') }}" method="POST">
                            @csrf
                            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">

                            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Mikrobiyolojik Teşhis / Suş</label>
                                    <input type="text" name="diagnosis" class="form-control fw-bold border-danger text-danger" value="ESBL (+) K.pneumoniae - Meropenem Hassas (PCT: 4.8 ng/mL)">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">KUP Kısıtlı Antibiyotik Kararı</label>
                                    <select name="form_data[kup_decision]" class="form-select">
                                        <option value="Meropenem 1g 3x1 (Onaylandı - 7 Gün)">Meropenem 1g 3x1 (Onaylandı - 7 Gün)</option>
                                        <option value="Kolistin 3 milyon IU 3x1 (Onaylandı)">Kolistin 3M IU 3x1 (Onaylandı)</option>
                                        <option value="Vankomisin 1g 2x1 (Trough Düzey Takipli)">Vankomisin 1g 2x1 (Taktikli)</option>
                                        <option value="Direnç Nedeniyle Tedavi Değişikliği">Direnç Nedeniyle Tedavi Değişikliği</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">İzolasyon Tipi</label>
                                    <input type="text" name="form_data[isolation_type]" class="form-control" value="Temas İzolasyonu + Negatif Basınçlı Oda">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Enfeksiyon Uzmanı Konsültasyon Notları</label>
                                <textarea name="notes" class="form-control" rows="4" required placeholder="Ateş takibi (TPR grafiği), kültür sonuç değerlendirmesi, antibiyogram MIC değerleri, KUP formu onay gerekçesi ve durdurma kriterleri..."></textarea>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Enfeksiyon Uzmanı: Prof. Dr. Hakan Erdem</span>
                                <button type="submit" class="btn btn-danger text-white fw-bold px-4 py-2">
                                    <i class="fa-solid fa-floppy-disk me-2"></i>Enfeksiyon Kaydını Onayla
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            @else
                <div class="card inf-card py-5 text-center">
                    <div class="card-body">
                        <i class="fa-solid fa-shield-virus fa-4x text-danger mb-3 opacity-40"></i>
                        <h5>Enfeksiyon Hastalıkları Başvurusu Seçiniz</h5>
                        <p class="text-muted">Sol listeden muayenesini gerçekleştirmek istediğiniz hastayı seçiniz.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
