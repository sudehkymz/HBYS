@extends('layouts.app')

@section('title', 'Elektronik Hasta Dosyası (EHR)')

@section('content')
<div class="container-fluid px-0">

    {{-- Başlık ve Hızlı Aksiyon Barı --}}
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h3 class="fw-bold mb-1 text-dark">
                <i class="fa-solid fa-folder-open text-primary me-2"></i>Elektronik Hasta Dosyası (EHR) & Tıbbi Zaman Tüneli
            </h3>
            <p class="text-muted small mb-0">
                Hasta: <strong>{{ $patient->full_name }}</strong> (T.C.: {{ $patient->national_id }}) | Dosya No: #EHR-{{ str_pad($patient->id, 6, '0', STR_PAD_LEFT) }}
            </p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#vitalsModal">
                <i class="fa-solid fa-heart-pulse me-1"></i> Hayati Bulgu Gir
            </button>
            <a href="{{ route('prescription.index') }}?patient_id={{ $patient->id }}" class="btn btn-purple text-white" style="background:#8b5cf6;">
                <i class="fa-solid fa-pills me-1"></i> E-Reçete Yaz
            </a>
            <a href="{{ route('ai.index') }}" class="btn btn-info text-white">
                <i class="fa-solid fa-robot me-1"></i> AI Özeti
            </a>
            <a href="{{ route('ehr.print', $patient) }}" target="_blank" class="btn btn-outline-secondary">
                <i class="fa-solid fa-print me-1"></i> Yazdır / PDF
            </a>
            <a href="{{ route('patients.show', $patient) }}" class="btn btn-outline-dark">
                <i class="fa-solid fa-arrow-left me-1"></i> Hasta Kartına Dön
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">

        {{-- Sol Kolon: Hasta Künyesi & Son Hayati Bulgular --}}
        <div class="col-lg-4">
            
            {{-- Hasta Kimlik Kartı --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius:14px;">
                <div class="card-body p-4 text-center">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 76px; height: 76px; font-size: 2.2rem;">
                        <i class="fa-solid fa-user-doctor"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-1">{{ $patient->full_name }}</h4>
                    <p class="text-muted small mb-3">
                        {{ $patient->gender === 'male' ? 'Erkek' : 'Kadın' }} &bull; {{ $patient->birth_date ? $patient->birth_date->age . ' Yaşında' : '-' }} (Doğum: {{ $patient->birth_date ? $patient->birth_date->format('d.m.Y') : '-' }})
                    </p>

                    <div class="d-flex justify-content-center gap-2 mb-3">
                        @if($patient->blood_type)
                            <span class="badge bg-danger fs-6"><i class="fa-solid fa-droplet me-1"></i>{{ $patient->blood_type }}</span>
                        @endif
                        <span class="badge bg-primary fs-6"><i class="fa-solid fa-id-card me-1"></i>T.C. {{ $patient->national_id }}</span>
                    </div>

                    {{-- İstatistik Rozetleri --}}
                    <div class="row g-2 pt-3 border-top text-center">
                        <div class="col-4">
                            <div class="fw-bold fs-5 text-primary">{{ $stats['total_encounters'] }}</div>
                            <div class="text-muted small" style="font-size:0.75rem;">Muayene</div>
                        </div>
                        <div class="col-4">
                            <div class="fw-bold fs-5 text-purple" style="color:#8b5cf6;">{{ $stats['total_prescriptions'] }}</div>
                            <div class="text-muted small" style="font-size:0.75rem;">Reçete</div>
                        </div>
                        <div class="col-4">
                            <div class="fw-bold fs-5 text-success">{{ $stats['total_reports'] }}</div>
                            <div class="text-muted small" style="font-size:0.75rem;">Rapor</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Hayati Bulgular Kartı (Vitals Panel) --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius:14px;">
                <div class="card-header bg-white border-0 fw-bold py-3 d-flex justify-content-between align-items-center">
                    <span><i class="fa-solid fa-heart-pulse text-danger me-2"></i>Son Hayati Bulgular (Vitals)</span>
                    <span class="badge bg-light text-muted fw-normal" style="font-size:0.75rem;">{{ $vitals['last_update'] }}</span>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted"><i class="fa-solid fa-stethoscope me-2 text-primary"></i>Kan Basıncı (Tansiyon)</span>
                            <span class="fw-bold text-dark fs-6">{{ $vitals['blood_pressure'] }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted"><i class="fa-solid fa-heart me-2 text-danger"></i>Nabız</span>
                            <span class="fw-bold text-dark fs-6">{{ $vitals['pulse'] }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted"><i class="fa-solid fa-temperature-high me-2 text-warning"></i>Vücut Sıcaklığı (Ateş)</span>
                            <span class="fw-bold text-dark fs-6">{{ $vitals['fever'] }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted"><i class="fa-solid fa-lungs me-2 text-info"></i>Oksijen Doygunluğu (SpO2)</span>
                            <span class="fw-bold text-dark fs-6">{{ $vitals['spo2'] }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted"><i class="fa-solid fa-wind me-2 text-secondary"></i>Solunum Sayısı</span>
                            <span class="fw-bold text-dark fs-6">{{ $vitals['respiration'] }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Tıbbi Uarılar & Alerjiler --}}
            <div class="card border-0 shadow-sm border-start border-4 border-warning" style="border-radius:14px;">
                <div class="card-header bg-white border-0 fw-bold py-3">
                    <i class="fa-solid fa-triangle-exclamation text-warning me-2"></i>Klinik Riskler & Uyarılar
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="small text-muted fw-bold text-uppercase d-block mb-1">Alerjiler</label>
                        @if($patient->allergies)
                            <div class="p-2 bg-warning bg-opacity-10 text-dark rounded border border-warning border-opacity-25 small fw-semibold">
                                <i class="fa-solid fa-circle-exclamation text-warning me-1"></i>{{ $patient->allergies }}
                            </div>
                        @else
                            <span class="text-muted small">Bilinen alerjisi yok.</span>
                        @endif
                    </div>
                    <div>
                        <label class="small text-muted fw-bold text-uppercase d-block mb-1">Kronik Tanılar</label>
                        @if($patient->chronic_conditions)
                            <div class="p-2 bg-info bg-opacity-10 text-dark rounded border border-info border-opacity-25 small fw-semibold">
                                <i class="fa-solid fa-notes-medical text-info me-1"></i>{{ $patient->chronic_conditions }}
                            </div>
                        @else
                            <span class="text-muted small">Kayıtlı kronik hastalığı yok.</span>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        {{-- Sağ Kolon: Tıbbi Zaman Tüneli (Medical Timeline) --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius:14px;">
                <div class="card-header bg-white border-0 fw-bold py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="fa-solid fa-timeline text-primary me-2"></i>Tıbbi Geçmiş Zaman Tüneli</h5>
                    <span class="badge bg-primary rounded-pill">{{ count($timeline) }} İşlem Kaydı</span>
                </div>
                <div class="card-body p-4">

                    @forelse($timeline as $event)
                        <div class="d-flex gap-3 mb-4 timeline-item position-relative">
                            {{-- İkon Dairesi --}}
                            <div class="flex-shrink-0" style="z-index: 2;">
                                <div style="width:46px;height:46px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.2rem;"
                                     class="bg-{{ $event['badge'] ?? 'primary' }} bg-opacity-10 text-{{ $event['badge'] ?? 'primary' }} border border-{{ $event['badge'] ?? 'primary' }} border-opacity-25">
                                    <i class="fa-solid {{ $event['icon'] }}"></i>
                                </div>
                            </div>

                            {{-- İçerik Kartı --}}
                            <div class="flex-grow-1 card border border-light-subtle shadow-sm p-3" style="border-radius:12px; background:#f9fafb;">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <span class="badge bg-{{ $event['badge'] ?? 'primary' }} text-white mb-1">
                                            {{ $event['type'] }}
                                        </span>
                                        <h6 class="fw-bold text-dark mb-0 fs-6">{{ $event['title'] }}</h6>
                                    </div>
                                    <span class="text-muted small fw-semibold"><i class="fa-regular fa-clock me-1"></i>{{ $event['date'] }}</span>
                                </div>

                                <p class="text-secondary small mb-2">{{ $event['subtitle'] }}</p>

                                @if(!empty($event['description']))
                                    <div class="p-2 bg-white rounded border text-dark small mb-2">
                                        {{ $event['description'] }}
                                    </div>
                                @endif

                                <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top">
                                    <span class="badge bg-light text-dark border">
                                        <i class="fa-solid fa-circle-info me-1 text-primary"></i>{{ $event['status'] }}
                                    </span>
                                    @if(!empty($event['link']))
                                        <a href="{{ $event['link'] }}" class="btn btn-link btn-sm p-0 text-decoration-none fw-semibold">
                                            Detay Gör <i class="fa-solid fa-chevron-right ms-1" style="font-size:0.7rem;"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="fa-solid fa-folder-open fs-1 mb-3 text-secondary opacity-50"></i>
                            <p class="mb-0">Hastaya ait kayıtlı tıbbi zaman tüneli verisi bulunamadı.</p>
                        </div>
                    @endforelse

                </div>
            </div>
        </div>

    </div>
</div>

{{-- Hayati Bulgu (Vitals) Ekleme Modalı --}}
<div class="modal fade" id="vitalsModal" tabindex="-1" aria-labelledby="vitalsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="vitalsModalLabel"><i class="fa-solid fa-heart-pulse me-2"></i>Yeni Hayati Bulgu (Vitals) Kaydı</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('ehr.vitals.store', $patient) }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kan Basıncı (Tansiyon)</label>
                        <input type="text" name="blood_pressure" class="form-control" placeholder="Örn: 120/80" value="120/80" required>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">Nabız (/dk)</label>
                            <input type="number" name="pulse" class="form-control" placeholder="72" value="75" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Vücut Ateşi (°C)</label>
                            <input type="number" step="0.1" name="fever" class="form-control" placeholder="36.6" value="36.7" required>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">SpO2 (Oksijen Doygunluğu %)</label>
                            <input type="number" name="spo2" class="form-control" placeholder="98" value="98" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Solunum Sayısı (/dk)</label>
                            <input type="number" name="respiration" class="form-control" placeholder="16" value="16">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check me-1"></i>Kaydet & Güncelle</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
