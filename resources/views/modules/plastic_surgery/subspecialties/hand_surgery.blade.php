@extends('modules.plastic_surgery.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-hand me-2 text-danger"></i>El Cerrahisi (Ortak Yan Dal)
@endsection

@section('page_description')
    Fleksör tendon tenosütürü (Kleinert ateli), dijital sinir mikronöronafisi & nöroliz rekonstruksiyonu.
@endsection

@section('plastic_workspace')
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card plastic-card h-100 border-start border-4 border-primary">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-hand-sparkles me-2"></i>Zone II Fleksör Tendon Kesisi & Kleinert Ateli</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Yaralanma Bölgesi:</span>
                        <span class="badge bg-primary fs-6">Sol El Volar Zone II (No Man's Land)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Kore Sütür Tekniği:</span>
                        <span class="badge bg-success">4-Strand Supramid Core Suture + Epitendon 5-0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Tamir Edilen Tendonlar:</span>
                        <span class="fw-bold text-dark">FDP (Flexor Digitorum Profundus) + FDS Tamiri</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Atel Protokolü:</span>
                        <span class="badge bg-warning text-dark">Volar Dinamik Kleinert Ateli (Erken Hareket)</span>
                    </div>
                </div>
                <div class="p-2 bg-primary-subtle rounded border border-primary-subtle small text-dark">
                    <i class="fa-solid fa-circle-check me-1"></i><strong>Tendon İyileşmesi:</strong> Pasif Fleksiyon & Aktif Ekstansiyon Egzersizleri Başlatıldı.
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card plastic-card h-100 border-start border-4 border-danger">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-danger mb-0"><i class="fa-solid fa-brain me-2"></i>Dijital Sinir Mikronöronafisi & Nöroliz</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Dijital Sinir Yaralanması:</span>
                        <span class="badge bg-danger fs-6">Sol 2. Parmak Radial Dijital Sinir Kesisi</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Epineöral Dikiş Tekniği:</span>
                        <span class="badge bg-success">10-0 Prolene İle Epineöral Dikiş (Mikroskop Altında)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">İki Nokta Ayrımı (2PD Testi):</span>
                        <span class="fw-bold text-dark">Post-Op İyileşme Dönemi Duyusal Rejenerasyon</span>
                    </div>
                </div>
                <div class="p-2 bg-danger-subtle rounded border border-danger-subtle small text-dark">
                    <strong>Nörom İncelemesi:</strong> Sinir Uçlarında Gerilimsiz Primer Mikronöronafi Başarıyla Tamamlandı.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card plastic-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-hand me-2 text-danger"></i>El Cerrahisi Muayene & Tenorafi Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('plastic_surgery.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="hand_surgery">
            <input type="hidden" name="redirect_route" value="plastic_surgery.hand_surgery">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">El Cerrahisi Teşhisi & Zone</label>
                    <input type="text" name="diagnosis" class="form-control fw-bold border-danger text-danger" value="Volar Zone II FDP/FDS Kesis - Tenorafi & Dijital Sinir Mikronöronafisi">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Cerrahi Tamir Yöntemi</label>
                    <select name="sub_specialty_data[hand_surg_type]" class="form-select">
                        <option value="Zone II Fleksör Tendon Kore Tenorafisi">Zone II Fleksör Tendon Tenorafisi</option>
                        <option value="Dijital Sinir Mikronöronafisi (10-0 Prolene)">Dijital Sinir Mikronöronafisi</option>
                        <option value="Mikrovasküler Replantasyon Cerrahisi">Mikrovasküler Replantasyon</option>
                        <option value="Dupuytren Faskiyektomi & Z-Plasti">Dupuytren Faskiyektomi & Z-Plasti</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Atel & Mobilizasyon Protokolü</label>
                    <input type="text" name="sub_specialty_data[hand_metrics]" class="form-control" value="Dorsal Blok Kleinert Ateli (Wrist 30° Fleksiyonda)">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">El Cerrahı Muayene & Mikrocerrahi Notları</label>
                <textarea name="notes" class="form-control" rows="4" required placeholder="Tendon kore dikiş gerilimi, epineöral sinir adaptasyonu, pulpa hissi, kapiller dolum zamanı ve Kleinert atel egzersiz talimatları..."></textarea>
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
