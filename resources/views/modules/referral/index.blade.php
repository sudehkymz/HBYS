@extends('layouts.app')

@section('title', 'Hastaneler & Klinikler Arası Sevk Yönetimi')

@section('content')
<div class="container-fluid px-0">

    {{-- Başlık & Aksiyon Barı --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4 pb-2 border-bottom">
        <div>
            <h3 class="fw-bold mb-1 text-dark">
                <i class="fa-solid fa-share-nodes text-primary me-2"></i>Hastaneler ve Klinikler Arası Sevk Takip Paneli
            </h3>
            <p class="text-muted small mb-0">İç sevkleri (Klinikler arası) ve dış sevkleri (Ambulans / Üst Merkez) izleyin ve yönetin.</p>
        </div>
        <div>
            <!-- Sayfa yönlendirmesi yapmadan açılan In-Page Modal Butonu -->
            <button type="button" class="btn btn-primary fw-bold px-4 shadow-sm text-nowrap" data-bs-toggle="modal" data-bs-target="#referralModal">
                <i class="fa-solid fa-plus me-1"></i> Yeni Sevk Kaydı Oluştur
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- İstatistik Rozetleri --}}
    <div class="row g-3 mb-4">
        <!-- Toplam Sevk Kaydı -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm p-3 position-relative overflow-hidden" style="border-radius:14px; background-color: #eff6ff !important; border-left: 5px solid #2563eb !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small fw-bold text-uppercase" style="color: #1e40af !important; letter-spacing: 0.5px;">Toplam Sevk Kaydı</div>
                        <div class="fs-2 fw-bold" style="color: #1e40af !important; font-weight: 800;">{{ $stats['total_count'] }} Kayıt</div>
                    </div>
                    <div style="width: 52px; height: 52px; background-color: #dbeafe; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #2563eb; font-size: 1.6rem;">
                        <i class="fa-solid fa-share-nodes"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- İç Sevk (Klinikler Arası) -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm p-3 position-relative overflow-hidden" style="border-radius:14px; background-color: #faf5ff !important; border-left: 5px solid #9333ea !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small fw-bold text-uppercase" style="color: #6b21a8 !important; letter-spacing: 0.5px;">İç Sevk (Klinikler Arası)</div>
                        <div class="fs-2 fw-bold" style="color: #6b21a8 !important; font-weight: 800;">{{ $stats['internal_count'] }} Sevk</div>
                    </div>
                    <div style="width: 52px; height: 52px; background-color: #f3e8ff; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #8b5cf6; font-size: 1.6rem;">
                        <i class="fa-solid fa-hospital-user"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dış Sevk (Üst Merkez/112) -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm p-3 position-relative overflow-hidden" style="border-radius:14px; background-color: #ecfeff !important; border-left: 5px solid #06b6d4 !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small fw-bold text-uppercase" style="color: #155e75 !important; letter-spacing: 0.5px;">Dış Sevk (Üst Merkez/112)</div>
                        <div class="fs-2 fw-bold" style="color: #155e75 !important; font-weight: 800;">{{ $stats['external_count'] }} Sevk</div>
                    </div>
                    <div style="width: 52px; height: 52px; background-color: #cff4fc; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #0891b2; font-size: 1.6rem;">
                        <i class="fa-solid fa-truck-medical"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Onay Bekleyenler -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm p-3 position-relative overflow-hidden" style="border-radius:14px; background-color: #fffbeb !important; border-left: 5px solid #f59e0b !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small fw-bold text-uppercase" style="color: #92400e !important; letter-spacing: 0.5px;">Onay Bekleyenler</div>
                        <div class="fs-2 fw-bold" style="color: #92400e !important; font-weight: 800;">{{ $stats['pending_count'] }} Bekleyen</div>
                    </div>
                    <div style="width: 52px; height: 52px; background-color: #fef3c7; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #d97706; font-size: 1.6rem;">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Sevk Listesi Tablosu --}}
    <div class="card border-0 shadow-sm dynamic-list-card" style="border-radius:14px;">
        <div class="card-header bg-white border-0 fw-bold py-3 d-flex justify-content-between align-items-center">
            <span class="fs-6"><i class="fa-solid fa-right-left text-primary me-2"></i>Hasta Sevk Kayıtları</span>
            <span class="badge bg-primary rounded-pill" id="referralBadge">{{ count($referrals) }} Sevk Kaydı</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive dynamic-table-scroll">
                <table class="table table-hover align-middle mb-0" data-dynamic-filter="true" data-count-badge="#referralBadge">
                    <thead class="sticky-table-header">
                        <tr>
                            <th class="ps-4">Sevk Kodu & Tarih</th>
                            <th>Hasta Bilgisi</th>
                            <th>Sevk Türü & Hedef</th>
                            <th>Sevk Nedeni / Gerekçesi</th>
                            <th>Ulaşım / Nakil</th>
                            <th>Durum</th>
                            <th class="text-end pe-4">Aksiyon</th>
                        </tr>
                        <tr class="table-filter-row">
                            <th class="ps-4"><input type="text" class="form-control table-filter-input" data-col-index="0" placeholder="Kod / Tarih ara..."></th>
                            <th><input type="text" class="form-control table-filter-input" data-col-index="1" placeholder="Hasta / TC ara..."></th>
                            <th><input type="text" class="form-control table-filter-input" data-col-index="2" placeholder="Tür / Hedef ara..."></th>
                            <th><input type="text" class="form-control table-filter-input" data-col-index="3" placeholder="Gerekçe ara..."></th>
                            <th><input type="text" class="form-control table-filter-input" data-col-index="4" placeholder="Ulaşım ara..."></th>
                            <th>
                                <select class="form-select table-filter-select" data-col-index="5">
                                    <option value="">Tüm Durumlar</option>
                                    <option value="bekliyor">Onay Bekliyor</option>
                                    <option value="onaylandı">Onaylandı</option>
                                    <option value="tamamlandı">Tamamlandı</option>
                                    <option value="iptal">İptal</option>
                                </select>
                            </th>
                            <th class="text-end pe-4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($referrals as $ref)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-primary">#{{ $ref->referral_code }}</div>
                                    <div class="text-muted small"><i class="fa-regular fa-clock me-1"></i>{{ $ref->created_at ? $ref->created_at->format('d.m.Y H:i') : '-' }}</div>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $ref->patient->full_name ?? 'Hasta' }}</div>
                                    <div class="text-muted small">T.C.: {{ $ref->patient->national_id ?? '-' }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border mb-1">
                                        {{ $ref->type_label }}
                                    </span>
                                    <div class="small fw-semibold text-dark">
                                        @if($ref->referral_type === 'internal')
                                            <i class="fa-solid fa-clinic-medical me-1 text-primary"></i>{{ $ref->targetClinic->name ?? 'Belirtilmedi' }}
                                        @else
                                            <i class="fa-solid fa-building-hospital me-1 text-info"></i>{{ $ref->target_hospital ?? 'Harici Kurum' }}
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="small text-secondary">{{ Str::limit($ref->reason, 45) }}</div>
                                </td>
                                <td>
                                    @if($ref->transport_type === 'ambulance')
                                        <span class="badge bg-danger text-white"><i class="fa-solid fa-ambulance me-1"></i>Ambulans / 112</span>
                                    @else
                                        <span class="badge bg-secondary text-white"><i class="fa-solid fa-person-walking me-1"></i>Kendi İmkânı</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ $ref->status_badge }} px-3 py-2 fs-6">
                                        {{ $ref->status_label }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group me-1">
                                        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                            Durum Değiştir
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                            <li>
                                                <form action="{{ route('referrals.status', $ref) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="approved">
                                                    <button type="submit" class="dropdown-item text-info"><i class="fa-solid fa-check-double me-2"></i>Onayla</button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('referrals.status', $ref) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="transferred">
                                                    <button type="submit" class="dropdown-item text-primary"><i class="fa-solid fa-truck-medical me-2"></i>Transfer Edildi</button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('referrals.status', $ref) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="completed">
                                                    <button type="submit" class="dropdown-item text-success"><i class="fa-solid fa-circle-check me-2"></i>Kabul Edildi / Tamamlandı</button>
                                                </form>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('referrals.status', $ref) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="cancelled">
                                                    <button type="submit" class="dropdown-item text-danger"><i class="fa-solid fa-ban me-2"></i>Sevk İptal</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                    <a href="{{ route('ehr.show', $ref->patient_id) }}" class="btn btn-sm btn-outline-primary" title="Hasta EHR Dosyası">
                                        <i class="fa-solid fa-folder-open"></i> EHR
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-share-nodes fs-1 text-secondary opacity-50 mb-3"></i>
                                    <p class="mb-0">Henüz oluşturulmuş iç veya dış sevk kaydı bulunmamaktadır.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- ========================================== -->
<!-- YENİ SEVK KAYDI MODALI (SAYFA DEĞİŞMEDEN) -->
<!-- ========================================== -->
<div class="modal fade" id="referralModal" tabindex="-1" aria-labelledby="referralModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="referralModalLabel">
                    <i class="fa-solid fa-share-nodes me-2"></i>Yeni Sevk / Transfer Kaydı
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Kapat"></button>
            </div>
            <form action="{{ route('referrals.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        {{-- Hasta Seçimi --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Sevk Edilecek Hasta <span class="text-danger">*</span></label>
                            <select name="patient_id" class="form-select" required>
                                <option value="">--- Hasta Seçiniz ---</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}">
                                        {{ $patient->full_name }} (T.C: {{ $patient->national_id }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Sevk Eden Hekim --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Sevk İsteyen Hekim</label>
                            <select name="referring_doctor_id" class="form-select">
                                <option value="">--- Hekim Seçiniz ---</option>
                                @foreach($doctors as $doc)
                                    <option value="{{ $doc->id }}">{{ $doc->name }} ({{ $doc->specialty }})</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Sevk Türü (İç / Dış) --}}
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Sevk Türü <span class="text-danger">*</span></label>
                            <div class="d-flex gap-4 p-3 bg-light rounded border">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="referral_type" id="ref_type_internal" value="internal" checked onchange="toggleReferralFields()">
                                    <label class="form-check-label fw-bold text-primary" for="ref_type_internal">
                                        <i class="fa-solid fa-hospital-user me-1"></i>İç Sevk (Klinikler Arası Transfer)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="referral_type" id="ref_type_external" value="external" onchange="toggleReferralFields()">
                                    <label class="form-check-label fw-bold text-info" for="ref_type_external">
                                        <i class="fa-solid fa-truck-medical me-1"></i>Dış Sevk (Başka Hastane / 112 Üst Merkez)
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- İç Sevk: Hedef Klinik --}}
                        <div class="col-md-6" id="field_target_clinic">
                            <label class="form-label fw-semibold">Hedef Poliklinik / Servis <span class="text-danger">*</span></label>
                            <select name="target_clinic_id" class="form-select">
                                <option value="">--- Hedef Klinik Seçiniz ---</option>
                                @foreach($clinics as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Dış Sevk: Hedef Hastane --}}
                        <div class="col-md-6 d-none" id="field_target_hospital">
                            <label class="form-label fw-semibold">Hedef Sağlık Kuruluşu / Hastane <span class="text-danger">*</span></label>
                            <input type="text" name="target_hospital" class="form-control" placeholder="Örn: Ankara Şehir Hastanesi Acil">
                        </div>

                        {{-- Nakil / Ulaşım Tipi --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Ulaşım / Nakil Tipi <span class="text-danger">*</span></label>
                            <select name="transport_type" class="form-select" required>
                                <option value="self">Kendi İmkânı / Yürüyerek</option>
                                <option value="ambulance">Ambulans / 112 Acil Servis</option>
                            </select>
                        </div>

                        {{-- Sevk Gerekçesi / Tıbbi Nedeni --}}
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Sevk Gerekçesi ve Klinik İntikal Notu <span class="text-danger">*</span></label>
                            <textarea name="reason" class="form-control" rows="3" placeholder="Hastanın sevk edilme tıbbi gerekçesi, klinik bulguları ve talebi yazınız..." required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary px-4 fw-bold">Sevk Kaydını Oluştur</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleReferralFields() {
        const isInternal = document.getElementById('ref_type_internal').checked;
        const clinicField = document.getElementById('field_target_clinic');
        const hospitalField = document.getElementById('field_target_hospital');

        if (isInternal) {
            clinicField.classList.remove('d-none');
            hospitalField.classList.add('d-none');
        } else {
            clinicField.classList.add('d-none');
            hospitalField.classList.remove('d-none');
        }
    }
</script>
@endsection
