@extends('modules.pediatrics.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-baby text-indigo me-2"></i>Neonatoloji (Yenidoğan & Yoğun Bakım)
@endsection

@section('page_description')
    Prematüre bebek takibi, YDYB fototerapi bilirubin nomogramı, TPN sıvı-elektrolit hesabı.
@endsection

@section('subspecialty_workspace')
<div class="row g-4 mb-4">
    <!-- APGAR Score Calculator Card -->
    <div class="col-md-6">
        <div class="card ped-card h-100 border-start border-4 border-indigo">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-indigo mb-0"><i class="fa-solid fa-square-poll-vertical me-2"></i>APGAR Skor Değerlendirmesi</h6>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered text-center align-middle small">
                        <thead class="table-light">
                            <tr>
                                <th>Kriter</th>
                                <th>0 Puan</th>
                                <th>1 Puan</th>
                                <th>2 Puan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-bold">Cilt Rengi</td>
                                <td>Mavi/Soluk</td>
                                <td>Gövde Pembe</td>
                                <td>Tüm Vücut Pembe</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Kalp Hızı</td>
                                <td>Yok</td>
                                <td><100/dk</td>
                                <td>>100/dk</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Refleks Yanıtı</td>
                                <td>Yanıt Yok</td>
                                <td>Hafif Mimik</td>
                                <td>Öksürük/Ağlama</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Kas Tonusu</td>
                                <td>Gevşek</td>
                                <td>Hafif Fleksiyon</td>
                                <td>Aktif Hareket</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Solunum</td>
                                <td>Yok</td>
                                <td>Zayıf/Yavaş</td>
                                <td>Güçlü Ağlama</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-2 p-2 bg-light rounded">
                    <span class="small fw-bold">Hesaplanan APGAR (1. dk / 5. dk):</span>
                    <span class="badge bg-success fs-6">8 / 10 (Normal)</span>
                </div>
            </div>
        </div>
    </div>

    <!-- TPN Dosing & Bilirubin Nomogram Card -->
    <div class="col-md-6">
        <div class="card ped-card h-100 border-start border-4 border-warning">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-warning-emphasis mb-0"><i class="fa-solid fa-flask-vial me-2"></i>TPN Hesabı & Fototerapi Nomogramı</h6>
            </div>
            <div class="card-body pt-0">
                <div class="mb-3 p-3 bg-light rounded border">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small fw-bold text-dark">TPN Sıvı Hesabı (Doğum Kilosuna Göre):</span>
                        <span class="badge bg-indigo">120 mL/kg/gün</span>
                    </div>
                    <div class="progress mb-2" style="height: 10px;">
                        <div class="progress-bar bg-indigo" role="progressbar" style="width: 75%"></div>
                    </div>
                    <div class="d-flex justify-content-between small text-muted">
                        <span>Dekstroz %10: 160 mL</span>
                        <span>Aminoasit: 3.5 g/kg</span>
                        <span>Lipid %20: 2 g/kg</span>
                    </div>
                </div>

                <div class="p-3 bg-warning-subtle rounded border border-warning">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="fw-bold text-dark small"><i class="fa-solid fa-sun text-warning me-1"></i>Bilirubin Düzeyi:</span>
                        <span class="fw-bold text-danger">14.8 mg/dL (36. Saat)</span>
                    </div>
                    <div class="small text-dark">
                        Bhutani Nomogramı: <strong>Yüksek-Orta Risk Bölgesi</strong>. Yoğun Fototerapi Başlanması Önerilir.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card ped-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-baby me-2 text-indigo"></i>Yenidoğan & YDYB Klinik Değerlendirme Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('pediatrics.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="neonatology">
            <input type="hidden" name="redirect_route" value="pediatrics.neonatology">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-3 col-6">
                    <label class="form-label small fw-bold">Doğum Haftası</label>
                    <input type="text" name="sub_specialty_data[gestational_week]" class="form-control" value="31+4 Hafta">
                </div>
                <div class="col-md-3 col-6">
                    <label class="form-label small fw-bold">Düzeltilmiş Yaş</label>
                    <input type="text" name="sub_specialty_data[corrected_age]" class="form-control" value="2 Hafta Düzeltilmiş">
                </div>
                <div class="col-md-3 col-6">
                    <label class="form-label small fw-bold">APGAR (1. dk / 5. dk)</label>
                    <input type="text" name="sub_specialty_data[apgar]" class="form-control" value="8 / 10">
                </div>
                <div class="col-md-3 col-6">
                    <label class="form-label small fw-bold">Doğum Kilosu (g)</label>
                    <input type="number" name="sub_specialty_data[birth_weight]" class="form-control" value="1850">
                </div>
                <div class="col-md-6 col-12">
                    <label class="form-label small fw-bold">Bilirubin (mg/dL) & Fototerapi Nomogramı</label>
                    <div class="input-group">
                        <input type="number" step="0.1" name="sub_specialty_data[bilirubin]" class="form-control" value="14.8">
                        <span class="input-group-text bg-warning text-dark fw-bold">Yoğun Fototerapi Başla</span>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <label class="form-label small fw-bold">TPN Sıvı-Elektrolit Otomatik Hesabı (mL/kg/gün)</label>
                    <input type="text" name="sub_specialty_data[tpn_fluid]" class="form-control" value="120 mL/kg/gün (Dextrose %10 + Na + K)">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Neonatoloji Muayene & Küvöz Takip Notları</label>
                <textarea name="clinical_notes" class="form-control" rows="4" required placeholder="Solunum desteği (CPAP/Entübe), beslenme toleransı, sarılık takibi ve küvöz parametreleri..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Hekim: {{ auth()->user()->name ?? 'Doç. Dr. Ayşe Demirel' }}</span>
                <button type="submit" class="btn btn-indigo text-white fw-bold px-4 py-2" {{ (empty($selectedAdmission['triage']['completed'])) ? 'disabled' : '' }}>
                    <i class="fa-solid fa-floppy-disk me-2"></i>Neonatoloji Muayenesini Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
