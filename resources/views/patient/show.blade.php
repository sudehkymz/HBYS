@extends('layouts.app')

@section('content')
<div class="d-flex flex-column flex-xl-row justify-content-between align-items-start align-items-xl-center gap-3 mb-4 pb-2 border-bottom">
    <div>
        <h2 class="h3 fw-bold mb-1"><i class="fa-solid fa-id-card text-primary me-2"></i>Hasta Kartı & Özet Ekranı</h2>
        <p class="text-muted small mb-0">Hasta ID: <strong>#{{ $patient->id }}</strong> | T.C. No: <strong>{{ $patient->national_id }}</strong></p>
    </div>
    <div class="d-flex gap-2 flex-wrap align-items-center">
        {{-- Primary Action Buttons --}}
        <a href="{{ route('ehr.show', $patient) }}" class="btn btn-primary text-white text-nowrap" title="Hastanın tüm elektronik hasta dosyasını ve zaman tünelini görüntüle">
            <i class="fa-solid fa-folder-open me-1"></i>EHR Dosyası
        </a>
        <a href="{{ route('prescription.index') }}?patient_id={{ $patient->id }}" class="btn text-white text-nowrap" style="background:#8b5cf6;" title="E-Reçete yaz">
            <i class="fa-solid fa-pills me-1"></i>E-Reçete
        </a>
        <a href="{{ route('emergency.create') }}?patient_id={{ $patient->id }}" class="btn btn-danger text-white text-nowrap" title="Acil triyaj kaydı">
            <i class="fa-solid fa-truck-medical me-1"></i>Acil Giriş
        </a>

        <!-- Desktop Quick Actions -->
        <div class="d-none d-md-flex gap-2 flex-wrap">
            <a href="{{ route('referrals.create') }}?patient_id={{ $patient->id }}" class="btn btn-secondary text-white text-nowrap">
                <i class="fa-solid fa-share-nodes me-1"></i>Sevk Et
            </a>
            <a href="{{ route('appointments.create') }}?patient_id={{ $patient->id }}" class="btn btn-success text-white text-nowrap">
                <i class="fa-solid fa-calendar-plus me-1"></i>Randevu
            </a>
            <a href="{{ route('inpatient.admission.index') }}" class="btn btn-warning text-dark text-nowrap">
                <i class="fa-solid fa-bed me-1"></i>Yatış
            </a>
            <a href="{{ route('ai.index') }}" class="btn btn-info text-white text-nowrap">
                <i class="fa-solid fa-robot me-1"></i>AI Analiz
            </a>
            <a href="{{ route('patients.edit', $patient) }}" class="btn btn-outline-secondary text-nowrap">
                <i class="fa-solid fa-pen me-1"></i>Düzenle
            </a>
            <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary text-nowrap">
                <i class="fa-solid fa-arrow-left me-1"></i>Listeye Dön
            </a>
        </div>

        <!-- Mobile More Actions Dropdown -->
        <div class="dropdown d-md-none">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Diğer İşlemler
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                <li><a class="dropdown-item" href="{{ route('referrals.create') }}?patient_id={{ $patient->id }}"><i class="fa-solid fa-share-nodes me-2 text-secondary"></i>Sevk Et</a></li>
                <li><a class="dropdown-item" href="{{ route('appointments.create') }}?patient_id={{ $patient->id }}"><i class="fa-solid fa-calendar-plus me-2 text-success"></i>Randevu Al</a></li>
                <li><a class="dropdown-item" href="{{ route('inpatient.admission.index') }}"><i class="fa-solid fa-bed me-2 text-warning"></i>Yatış İşlemi</a></li>
                <li><a class="dropdown-item" href="{{ route('ai.index') }}"><i class="fa-solid fa-robot me-2 text-info"></i>AI ile Analiz</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="{{ route('patients.edit', $patient) }}"><i class="fa-solid fa-pen me-2"></i>Düzenle</a></li>
                <li><a class="dropdown-item" href="{{ route('patients.index') }}"><i class="fa-solid fa-arrow-left me-2"></i>Listeye Dön</a></li>
            </ul>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row g-4">
    <!-- Sol Kolon: Temel Demografik Bilgiler & Kimlik Kartı -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body text-center p-4">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; font-size: 2.5rem;">
                    <i class="fa-solid fa-user"></i>
                </div>
                <h4 class="fw-bold mb-1">{{ $patient->full_name }}</h4>
                <p class="text-muted mb-3">
                    {{ $patient->gender === 'male' ? 'Erkek' : ($patient->gender === 'female' ? 'Kadın' : 'Diğer') }} | 
                    {{ $patient->birth_date ? $patient->birth_date->age . ' Yaşında' : '-' }}
                </p>
                <div class="d-flex justify-content-center gap-2 mb-2">
                    @if($patient->blood_type)
                        <span class="badge bg-danger fs-6"><i class="fa-solid fa-droplet me-1"></i>{{ $patient->blood_type }}</span>
                    @endif
                    <span class="badge bg-secondary fs-6"><i class="fa-solid fa-cake-candles me-1"></i>{{ $patient->birth_date ? $patient->birth_date->format('d.m.Y') : '-' }}</span>
                    @if($prescriptionCount > 0)
                        <span class="badge fs-6" style="background:#8b5cf6">
                            <i class="fa-solid fa-pills me-1"></i>{{ $prescriptionCount }} Reçete
                        </span>
                    @endif
                </div>
            </div>
            <ul class="list-group list-group-flush border-top">
                <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                    <span class="text-muted"><i class="fa-solid fa-phone me-2 text-primary"></i>Telefon</span>
                    <span class="fw-semibold">{{ $patient->phone ?? '-' }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                    <span class="text-muted"><i class="fa-solid fa-truck-medical me-2 text-danger"></i>Acil Durum</span>
                    <span class="fw-semibold">{{ $patient->emergency_contact ?? '-' }}</span>
                </li>
                <li class="list-group-item py-3">
                    <div class="text-muted mb-1"><i class="fa-solid fa-location-dot me-2 text-primary"></i>Adres</div>
                    <div class="fw-semibold">{{ $patient->address ?? '-' }}</div>
                </li>
            </ul>
        </div>

        <!-- Tıbbi Uarılar (Alerjiler & Kronik Hastalıklar) -->
        <div class="card border-0 shadow-sm border-start border-4 border-warning">
            <div class="card-header bg-white border-0 fw-bold py-3">
                <i class="fa-solid fa-triangle-exclamation text-warning me-2"></i>Tıbbi Uarılar & Riskler
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="small text-muted fw-bold text-uppercase d-block mb-1">Alerjiler</label>
                    @if($patient->allergies)
                        <div class="p-2 bg-warning bg-opacity-10 text-dark rounded border border-warning border-opacity-25 small">
                            {{ $patient->allergies }}
                        </div>
                    @else
                        <span class="text-muted small">Bilinen alerjisi bulunmuyor.</span>
                    @endif
                </div>
                <div>
                    <label class="small text-muted fw-bold text-uppercase d-block mb-1">Kronik Hastalıklar</label>
                    @if($patient->chronic_conditions)
                        <div class="p-2 bg-info bg-opacity-10 text-dark rounded border border-info border-opacity-25 small">
                            {{ $patient->chronic_conditions }}
                        </div>
                    @else
                        <span class="text-muted small">Kayıtlı kronik hastalık bulunmuyor.</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Sağ Kolon: Tedaviler & Hasta Kabulleri (Episodes of Care & Encounters) -->
    <div class="col-md-8">
        <!-- Aktif / Geçmiş Süreçler (Episodes of Care) -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 fw-bold py-3 d-flex justify-content-between align-items-center">
                <span><i class="fa-solid fa-folder-open text-primary me-2"></i>Hasta Tedavi Süreçleri (Episodes of Care)</span>
                <span class="badge bg-primary rounded-pill">{{ $patient->episodesOfCare->count() }} Süreç</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Başlık / Tanı</th>
                                <th>Başlangıç Tarihi</th>
                                <th>Durum</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($patient->episodesOfCare as $episode)
                                <tr>
                                    <td>{{ $episode->id }}</td>
                                    <td class="fw-semibold">{{ $episode->title }}</td>
                                    <td>{{ $episode->start_date ? $episode->start_date->format('d.m.Y H:i') : '-' }}</td>
                                    <td>
                                        @if($episode->status === 'active')
                                            <span class="badge bg-success">Aktif</span>
                                        @elseif($episode->status === 'finished')
                                            <span class="badge bg-secondary">Tamamlandı</span>
                                        @else
                                            <span class="badge bg-danger">İptal</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        Hastaya ait henüz aktif veya tamamlanmış tedavi süreci bulunmuyor.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Başvuru ve Muayene Geçmişi (Encounters) -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 fw-bold py-3 d-flex justify-content-between align-items-center">
                <span><i class="fa-solid fa-notes-medical text-success me-2"></i>Kabul ve Muayene Geçmişi (Encounters)</span>
                <span class="badge bg-success rounded-pill">{{ $patient->encounters->count() }} Kabul</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Tarih</th>
                                <th>Kabul Tipi</th>
                                <th>Doktor / Hekim</th>
                                <th>Durum</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($patient->encounters as $encounter)
                                <tr>
                                    <td>{{ $encounter->encounter_date ? $encounter->encounter_date->format('d.m.Y H:i') : '-' }}</td>
                                    <td>
                                        <span class="badge bg-info text-dark">{{ strtoupper($encounter->type) }}</span>
                                    </td>
                                    <td>{{ $encounter->physician->name ?? '-' }}</td>
                                    <td>
                                        @if($encounter->status === 'completed')
                                            <span class="badge bg-success">Tamamlandı</span>
                                        @elseif($encounter->status === 'in_progress')
                                            <span class="badge bg-warning text-dark">Devam Ediyor</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $encounter->status }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        Henüz muayene veya kabul kaydı bulunmamaktadır.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
