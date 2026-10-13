@extends('layouts.app')

@push('styles')
<style>
    .ts-card {
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
        background-color: #e0f2fe;
        border-left-color: #0284c7;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-3">
    <!-- Thoracic Surgery Main Department Header Banner -->
    <div class="card ts-card mb-4 bg-white border-top border-4 border-info" style="border-top-color: #0284c7 !important;">
        <div class="card-body p-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle p-3 d-flex align-items-center justify-content-center text-white" style="width: 52px; height: 52px; background-color: #0284c7;">
                        <i class="fa-solid fa-lungs fa-2x"></i>
                    </div>
                    <div>
                        <h2 class="h4 mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                            <i class="fa-solid fa-lungs" style="color: #0284c7;"></i>Göğüs Cerrahisi Polikliniği & Toraks Ameliyathanesi
                        </h2>
                        <p class="text-muted small mb-0">VATS / RATS kapalı akciğer cerrahisi, göğüs tüpü (Bülau) hava kaçağı takibi & plevral dekortikasyon.</p>
                    </div>
                </div>

                <div class="badge border px-3 py-2 fs-6 rounded-pill" style="background-color: #e0f2fe; color: #0284c7; border-color: #bae6fd !important;">
                    <i class="fa-solid fa-lungs-virus me-1"></i>Toraks & Minimal İnvaziv VATS Cerrahi Merkezi
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
            <div class="card ts-card h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-hospital-user me-2" style="color: #0284c7;"></i>Göğüs Cerrahisi Başvuruları
                    </h5>
                    <span class="badge rounded-pill" style="background-color: #e0f2fe; color: #0284c7;">{{ count($tsAdmissions) }} Hasta</span>
                </div>
                <div class="list-group list-group-flush" style="max-height: 750px; overflow-y: auto;">
                    @forelse($tsAdmissions as $adm)
                        <a href="{{ route('thoracic_surgery.index', ['admission_id' => $adm['id']]) }}" 
                           class="list-group-item list-group-item-action patient-item py-3 {{ ($selectedAdmission && $selectedAdmission['id'] == $adm['id']) ? 'active' : '' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-1 text-dark">{{ $adm['patient_name'] }}</h6>
                                <span class="badge border" style="background-color: #e0f2fe; color: #0284c7; border-color: #bae6fd !important;">{{ $adm['age'] }} Yaş</span>
                            </div>
                            <div class="text-muted small mt-1">
                                <div><i class="fa-solid fa-building me-1"></i><strong>{{ $adm['service'] }}</strong></div>
                                <div class="fw-medium text-secondary mt-1"><i class="fa-solid fa-notes-medical me-1"></i>{{ $adm['diagnosis'] }}</div>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="fa-solid fa-hospital-user fa-3x mb-3 opacity-30"></i>
                            <p>Aktif göğüs cerrahisi hastası bulunmamaktadır.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Main Workspace Column -->
        <div class="col-lg-8 col-12">
            @if($selectedAdmission)
                <!-- Active Patient Dossier Card -->
                <div class="card ts-card mb-4 border-start border-4" style="border-left-color: #0284c7 !important;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge text-white mb-2" style="background-color: #0284c7;">Aktif Göğüs Cerrahisi Dosyası</span>
                                <h3 class="fw-bold text-dark mb-1">{{ $selectedAdmission['patient_name'] }}</h3>
                                <p class="text-muted small mb-0">
                                    <strong>T.C.:</strong> {{ $selectedAdmission['national_id'] }} | 
                                    <strong>Yaş/Cinsiyet:</strong> {{ $selectedAdmission['age'] }} Yaş ({{ $selectedAdmission['gender'] }}) | 
                                    <strong>Oda/Salon:</strong> {{ $selectedAdmission['room'] }}
                                </p>
                                <div class="mt-2 p-2 bg-light rounded border small">
                                    <i class="fa-solid fa-user-doctor me-1" style="color: #0284c7;"></i>
                                    <strong>Toraks Cerrahı:</strong> {{ $selectedAdmission['attending_physician'] }} | 
                                    <strong>Cerrahi Endikasyon:</strong> {{ $selectedAdmission['diagnosis'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Thoracic Surgery Specific Workspace Cards -->
                <div class="row g-4 mb-4">
                    <!-- VATS / RATS Thoracoscopic Surgery & Resection Card -->
                    <div class="col-md-6">
                        <div class="card ts-card h-100 border-start border-4" style="border-left-color: #0284c7 !important;">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold mb-0" style="color: #0284c7;"><i class="fa-solid fa-video me-2"></i>VATS / RATS Kapalı Toraks Cerrahi Yaklaşımı</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Cerrahi Yaklaşım Tekniği:</span>
                                        <span class="badge bg-primary fs-6">VATS (2 Port Kapalı Video Torakoskopi)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Rezeksiyon Türü:</span>
                                        <span class="fw-bold text-dark">Sağ Üst Lobektomi + Mediastinal Lenf Diseksiyonu</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Pre-Op SFT FEV1 Değeri:</span>
                                        <span class="badge bg-success">FEV1: %82 (Pulmoner Tolerans Yüksek)</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">Bronşial Zımba (Stapler):</span>
                                        <span class="badge bg-secondary">Endo GIA Yeşil Kartuş Sızdırmaz</span>
                                    </div>
                                </div>

                                <div class="p-2 rounded border small text-dark" style="background-color: #e0f2fe; border-color: #bae6fd !important;">
                                    <i class="fa-solid fa-circle-check me-1" style="color: #0284c7;"></i><strong>Anatomik Rezeksiyon:</strong> Pulmoner Arter, Ven ve Bronş Kökü Ayrı Ayrı Bağlanarak Lobektomi Tamamlandı.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Chest Tube (Bülau Dren) & Underwater Air Leak Monitor Card -->
                    <div class="col-md-6">
                        <div class="card ts-card h-100 border-start border-4 border-warning">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-warning-emphasis mb-0"><i class="fa-solid fa-bottle-water me-2"></i>Göğüs Tüpü (Bülau Dren) & Hava Kaçağı</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Bülau Göğüs Tüpü Debisi:</span>
                                        <span class="badge bg-warning text-dark fs-6">120 ml / Gün Seröz Mayi</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Su Altı Drenajı Hava Kaçağı:</span>
                                        <span class="badge bg-success">Grade 0 (Hava Kaçağı Yok, Bubbling Negatif)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Akciğer Ekspansiyonu:</span>
                                        <span class="badge bg-success">Tele-Akciğer Grafisinde Parankim Tam Açık</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">Göğüs Tüpü Çekilme Planı:</span>
                                        <span class="fw-bold text-dark">Post-op 2. Gün Dren Çekilmesi Uygun</span>
                                    </div>
                                </div>

                                <div class="p-2 bg-warning-subtle rounded border border-warning small text-dark">
                                    <strong>Plevral Drenaj Takibi:</strong> Pnömotoraks/Hemotoraks Bulgusu Yoktur, Su Altı Drenajı Klemplenerek Çekilebilir.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Form -->
                <div class="card ts-card mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="fa-solid fa-file-medical me-2" style="color: #0284c7;"></i>Göğüs Cerrahisi Muayene & Ameliyat Formu
                        </h5>
                    </div>
                    <div class="card-body pt-0">
                        <form action="{{ route('thoracic_surgery.store_exam') }}" method="POST">
                            @csrf
                            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">

                            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Göğüs Cerrahisi Teşhisi & SFT</label>
                                    <input type="text" name="diagnosis" class="form-control fw-bold border-info" style="border-color: #0284c7 !important; color: #0284c7;" value="Sağ Üst Lob Akciğer Ca - VATS Anatomi Lobektomi (Göğüs Tüpü 120 ml/gün, Kaçak Yok)">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Toraks Cerrahi Prosedürü</label>
                                    <select name="form_data[ts_surg_type]" class="form-select">
                                        <option value="VATS Kapalı Anatomi Lobektomi + Lenf Diseksiyonu">VATS Kapalı Lobektomi</option>
                                        <option value="Göğüs Tüpü Torakostomi (Spontan Pnömotoraks)">Göğüs Tüpü Torakostomi</option>
                                        <option value="RATS Robotik Total Timektomi">RATS Robotik Total Timektomi</option>
                                        <option value="VATS Plevral Dekortikasyon (Empiyem)">VATS Plevral Dekortikasyon</option>
                                        <option value="Rijit Bronkoskopi + Kriyorezeksiyon / Stent">Rijit Bronkoskopi + Stent</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Göğüs Tüpü & Hava Kaçağı</label>
                                    <input type="text" name="form_data[chest_tube_status]" class="form-control" value="Su Altı Drenajı Hava Kaçağı Yok (Grade 0), 120 ml/gün Seröz">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Toraks Cerrahı Muayene Notları</label>
                                <textarea name="notes" class="form-control" rows="4" required placeholder="Solunum sesleri (bilateral eşit/doğal), torakostomi tüp insizyon pansumanı, su altı drenaj şişesi osilasyon ve hava kaçağı takibi, kontrol PA akciğer grafisi ekspansiyonu..."></textarea>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Toraks Cerrahı: Prof. Dr. Semih Halezeroğlu</span>
                                <button type="submit" class="btn text-white fw-bold px-4 py-2" style="background-color: #0284c7;">
                                    <i class="fa-solid fa-floppy-disk me-2"></i>Göğüs Cerrahisi Kaydını Onayla
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            @else
                <div class="card ts-card py-5 text-center">
                    <div class="card-body">
                        <i class="fa-solid fa-lungs fa-4x mb-3 opacity-40" style="color: #0284c7;"></i>
                        <h5>Göğüs Cerrahisi Hasta Başvurusu Seçiniz</h5>
                        <p class="text-muted">Sol listeden muayenesini gerçekleştirmek istediğiniz hastayı seçiniz.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
