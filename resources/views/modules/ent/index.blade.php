@extends('layouts.app')

@push('styles')
<style>
    .ent-card {
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
        background-color: #f0fdf4;
        border-left-color: #16a34a;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-3">
    <!-- Main Department Header Banner -->
    <div class="card ent-card mb-4 bg-white border-top border-4 border-success">
        <div class="card-body p-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-success p-3 d-flex align-items-center justify-content-center text-white" style="width: 52px; height: 52px;">
                        <i class="fa-solid fa-ear-listen fa-2x"></i>
                    </div>
                    <div>
                        <h2 class="h4 mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                            <i class="fa-solid fa-head-side-cough text-success"></i>Kulak Burun Boğaz Hastalıkları (KBB) Polikliniği
                        </h2>
                        <p class="text-muted small mb-0">Rigid endoskopi, odyometri işitme testi, FESS sinüs cerrahisi, timpanoplasti & septorinoplasti.</p>
                    </div>
                </div>

                <div class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 fs-6 rounded-pill">
                    <i class="fa-solid fa-scalpel me-1"></i>2. Cerrahi Tıp Bilimleri
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
            <div class="card ent-card h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-hospital-user me-2 text-success"></i>KBB Hasta Listesi
                    </h5>
                    <span class="badge bg-success-subtle text-success rounded-pill">{{ count($entAdmissions) }} Hasta</span>
                </div>
                <div class="list-group list-group-flush" style="max-height: 750px; overflow-y: auto;">
                    @forelse($entAdmissions as $adm)
                        <a href="{{ route('ent.index', ['admission_id' => $adm['id']]) }}" 
                           class="list-group-item list-group-item-action patient-item py-3 {{ ($selectedAdmission && $selectedAdmission['id'] == $adm['id']) ? 'active' : '' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-1 text-dark">{{ $adm['patient_name'] }}</h6>
                                <span class="badge bg-success-subtle text-success border border-success-subtle">{{ $adm['age'] }} Yaş</span>
                            </div>
                            <div class="text-muted small mt-1">
                                <div><i class="fa-solid fa-building me-1"></i><strong>{{ $adm['service'] }}</strong></div>
                                <div class="fw-medium text-secondary mt-1"><i class="fa-solid fa-notes-medical me-1"></i>{{ $adm['diagnosis'] }}</div>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="fa-solid fa-hospital-user fa-3x mb-3 opacity-30"></i>
                            <p>Aktif KBB hastası bulunmamaktadır.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Main Workspace Column -->
        <div class="col-lg-8 col-12">
            @if($selectedAdmission)
                <!-- Active Patient Dossier Card -->
                <div class="card ent-card mb-4 border-start border-success border-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-success text-white mb-2">Aktif KBB Muayene Dosyası</span>
                                <h3 class="fw-bold text-dark mb-1">{{ $selectedAdmission['patient_name'] }}</h3>
                                <p class="text-muted small mb-0">
                                    <strong>T.C.:</strong> {{ $selectedAdmission['national_id'] }} | 
                                    <strong>Yaş/Cinsiyet:</strong> {{ $selectedAdmission['age'] }} Yaş ({{ $selectedAdmission['gender'] }}) | 
                                    <strong>Oda/Birim:</strong> {{ $selectedAdmission['room'] }}
                                </p>
                                <div class="mt-2 p-2 bg-light rounded border small">
                                    <i class="fa-solid fa-user-doctor text-success me-1"></i>
                                    <strong>KBB Uzmanı:</strong> {{ $selectedAdmission['attending_physician'] }} | 
                                    <strong>Tanı:</strong> {{ $selectedAdmission['diagnosis'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KBB Workspace Cards -->
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="card ent-card h-100 border-start border-4 border-success">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-success mb-0"><i class="fa-solid fa-ear-listen me-2"></i>Odyometri & Timpanometri İşitme Testi</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Saf Ses Ortalaması (SSO):</span>
                                        <span class="badge bg-success fs-6">Sağ: 15 dB / Sol: 18 dB (Normal)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Timpanogram Grafiği:</span>
                                        <span class="badge bg-primary">Tip A (Orta Kulak Basıncı Normal)</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">Stapes Akustik Refleks:</span>
                                        <span class="fw-bold text-dark">Ipsilateral & Kontralateral Pozitif</span>
                                    </div>
                                </div>
                                <div class="p-2 bg-success-subtle rounded border border-success small text-dark">
                                    <i class="fa-solid fa-circle-check me-1"></i><strong>Otolojik Muayene:</strong> Kulak Zarı Intakt, Işık Üçgeni Doğal Görünümde.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card ent-card h-100 border-start border-4 border-primary">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-camera me-2"></i>Rigid Nazal & Laringeal Endoskopi</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Nazal Septum Görünümü:</span>
                                        <span class="badge bg-danger">Sol S-Tipi Septum Deviasyonu</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Alt Konka Hipertrofisi:</span>
                                        <span class="badge bg-warning text-dark">Bilateral Grade 2 Konka Şişliği</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">Ses Telleri (Vokal Kord):</span>
                                        <span class="fw-bold text-dark">Kord Vokal Hareketli, Nodül Yok</span>
                                    </div>
                                </div>
                                <div class="p-2 bg-primary-subtle rounded border border-primary-subtle small text-dark">
                                    <strong>Planlanan Cerrahi:</strong> Endoskopik Sinüs Cerrahisi (FESS) + Septoplasti Ameliyatı Onaylandı.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Form -->
                <div class="card ent-card mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="fa-solid fa-file-medical me-2 text-success"></i>KBB Muayene & Endoskopi Kayıt Formu
                        </h5>
                    </div>
                    <div class="card-body pt-0">
                        <form action="{{ route('ent.store_exam') }}" method="POST">
                            @csrf
                            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">

                            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">KBB Teşhisi & Cerrahi Kararı</label>
                                    <input type="text" name="diagnosis" class="form-control fw-bold border-success text-success" value="Septum Deviasyonu & FESS Endoskopik Sinüs Cerrahisi (SSO: 15 dB)">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Reçete / Uygulanan Operasyon</label>
                                    <select name="form_data[ent_procedure]" class="form-select">
                                        <option value="Septoplasti + FESS (Endoskopik Sinüs Cerrahisi)">Septoplasti + FESS Sinüs Cerrahisi</option>
                                        <option value="Adenotonsillektomi (Geniz Eti ve Bademcik)">Adenotonsillektomi (Koblör Yöntemi)</option>
                                        <option value="Timpanoplasti (Kulak Zarı Onarımı)">Timpanoplasti Greftleme</option>
                                        <option value="Septorinoplasti Estetik & Fonksiyonel Ameliyat">Septorinoplasti Cerrahisi</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Odyometri & Endoskopi Skoru</label>
                                    <input type="text" name="form_data[ent_metrics]" class="form-control" value="Tip A Timpanogram, Sol Deviasyon (+)">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">KBB Hekimi Muayene Notları</label>
                                <textarea name="notes" class="form-control" rows="4" required placeholder="Kulak zarı otroskopisi, orofarenks tonsil evresi, nazal pasaj açıklığı, ostiyomeatal kompleks tıkanıklığı ve post-op tampon seçimi notları..."></textarea>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>KBB Hekimi: Prof. Dr. Suat Şahin</span>
                                <button type="submit" class="btn btn-success text-white fw-bold px-4 py-2">
                                    <i class="fa-solid fa-floppy-disk me-2"></i>KBB Kaydını Onayla
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            @else
                <div class="card ent-card py-5 text-center">
                    <div class="card-body">
                        <i class="fa-solid fa-ear-listen fa-4x text-success mb-3 opacity-40"></i>
                        <h5>KBB Hasta Başvurusu Seçiniz</h5>
                        <p class="text-muted">Sol listeden muayenesini gerçekleştirmek istediğiniz hastayı seçiniz.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
