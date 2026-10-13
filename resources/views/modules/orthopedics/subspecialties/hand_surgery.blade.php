@extends('modules.orthopedics.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-hand me-2 text-danger"></i>El Cerrahisi (Ortak Yan Dal)
@endsection

@section('page_description')
    Mikrovasküler replantasyon cerrahisi, dijital nöroliz/tenorafi, Karpal Tünel (KTS) & tendon fleksiyon tamiri.
@endsection

@section('orthopedics_workspace')
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card ortho-card h-100 border-start border-4 border-danger">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-danger mb-0"><i class="fa-solid fa-microscope me-2"></i>Dijital Replantasyon & Mikrovasküler Anastomoz</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Amputasyon Seviyesi:</span>
                        <span class="badge bg-danger fs-6">Sağ 2. ve 3. Parmak Tam Dijital Amputasyon</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Mikrovasküler Arter/Ven Anastomozu:</span>
                        <span class="badge bg-success">10-0 Prolene İle 2 Arter + 3 Ven Anastomozu</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Kemik Fiksasyonu:</span>
                        <span class="fw-bold text-dark">K-Teli (Kirschner) İle Intramedüller Fiksasyon</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Doku Canlılık (Perfüzyon):</span>
                        <span class="badge bg-success fs-6">Pembe Sıcak, Kapiller Geri Dolum 1.5 sn</span>
                    </div>
                </div>
                <div class="p-2 bg-danger-subtle rounded border border-danger-subtle small text-dark">
                    <i class="fa-solid fa-circle-check me-1"></i><strong>Replantasyon Protokolü:</strong> Düşük Moleküler Ağırlıklı Heparin + Sıcak Oda Takibi Başlatıldı.
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card ortho-card h-100 border-start border-4 border-primary">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-hand-sparkles me-2"></i>Karpal Tünel (KTS) & Tendon Tenorafisi</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Nervus Medianus Basısı (KTS):</span>
                        <span class="badge bg-warning text-dark">Tinel / Phalen Testi (+++) Şiddetli KTS</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Fleksör Tendon Yaralanması:</span>
                        <span class="badge bg-primary">Zone II FDP + FDS Tenorafi Tamiri</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Erken Mobilizasyon:</span>
                        <span class="fw-bold text-dark">Dorsal Blok Ateli (Kleinert Protokolü)</span>
                    </div>
                </div>
                <div class="p-2 bg-primary-subtle rounded border border-primary-subtle small text-dark">
                    <strong>Nöroliz Sonucu:</strong> Flexor Retinakulum Açıldı, Median Sinir Basısı Tamamen Giderildi.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card ortho-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-hand me-2 text-danger"></i>El Cerrahisi Muayene & Mikronörocerrahi Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('orthopedics.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="hand_surgery">
            <input type="hidden" name="redirect_route" value="orthopedics.hand_surgery">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">El Cerrahisi Teşhisi & Replantasyon</label>
                    <input type="text" name="diagnosis" class="form-control fw-bold border-danger text-danger" value="Tam Dijital Amputasyon - Mikrovasküler Replantasyon (Arter/Ven/Sinir Anastomozu)">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">El Cerrahisi Operasyonu</label>
                    <select name="sub_specialty_data[hand_surg_type]" class="form-select">
                        <option value="Mikrovasküler Dijital Replantasyon Cerrahisi">Mikrovasküler Dijital Replantasyon</option>
                        <option value="Karpal Tünel Gevşetme (KTS Nöroliz)">Karpal Tünel Gevşetme (KTS Nöroliz)</option>
                        <option value="Zone II Fleksör Tendon Tenorafi Tamiri">Zone II Fleksör Tendon Tenorafisi</option>
                        <option value="Dupuytren Kontraktürü Faskiyektomi">Dupuytren Kontraktürü Faskiyektomi</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Perfüzyon & Kleinert Ateli</label>
                    <input type="text" name="sub_specialty_data[hand_metrics]" class="form-control" value="Kapiller dolum: 1.5 sn, Dorsal Blok Kleinert Ateli Uygulandı">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">El Cerrahı Muayene & Mikrocerrahi Notları</label>
                <textarea name="notes" class="form-control" rows="4" required placeholder="Dijital arter ven akım kalitesi, sinir epineöral suturlama, tendon dikiş tekniği (4-strand core), iskemi süresi ve kapiller dolum takibi..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>El Cerrahisi Uzmanı: Doç. Dr. Barış Soner</span>
                <button type="submit" class="btn btn-danger text-white fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>El Cerrahısı Kaydını Onayla
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
