@extends('modules.ophthalmology.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-circle-dot me-2 text-danger"></i>Retina & Vitreoretinal Cerrahi Birimi
@endsection

@section('page_description')
    Makula OCT fovea kalınlığı, FFA fundus anjiyografisi, intravitreal Anti-VEGF enjeksiyonu & Pars Plana Vitrektomi (PPV).
@endsection

@section('ophthalmology_workspace')
<div class="row g-4 mb-4">
    <!-- Macular OCT & CFT Measurement Card -->
    <div class="col-md-6">
        <div class="card oph-card h-100 border-start border-4 border-danger">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-danger mb-0"><i class="fa-solid fa-layer-group me-2"></i>Makula OCT & Foveal Kalınlık (CFT)</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Santral Foveal Kalınlık (CFT):</span>
                        <span class="badge bg-danger fs-6">CFT: 410 µm (Diyabetik Makula Ödemi)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">İntrarektal Kistik Sıvı:</span>
                        <span class="badge bg-warning text-dark">Kistik Ödem & Subretinal Mayi Var</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Vitreomaküler Ara Yüzey:</span>
                        <span class="fw-bold text-dark">Vitreomaküler Traksiyon (VMT) Yok</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Anti-VEGF Yükleme Enjeksiyonu:</span>
                        <span class="badge bg-primary">3. Doz İntravitreal Aflibercept Enjeksiyonu</span>
                    </div>
                </div>

                <div class="p-2 bg-danger-subtle rounded border border-danger-subtle small text-dark">
                    <i class="fa-solid fa-circle-check me-1"></i><strong>Enjeksiyon Sonrası Takip:</strong> İntravitreal Aflibercept (Eylea 2mg/0.05ml) Ameliyathane Şartlarında Uygulandı.
                </div>
            </div>
        </div>
    </div>

    <!-- FFA Angiography & Vitreoretinal Surgery (PPV) Card -->
    <div class="col-md-6">
        <div class="card oph-card h-100 border-start border-4 border-primary">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-circle-dot me-2"></i>FFA Anjiyografi & Pars Plana Vitrektomi (PPV)</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">FFA Anjiyografi Bulgusu:</span>
                        <span class="badge bg-danger">Temporal Sızıntı & Neovaskülarizasyon</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Panretinal Fotokoagülasyon (PRP):</span>
                        <span class="badge bg-success">1500 Odak Argon Lazer Tamamlandı</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Pars Plana Vitrektomi (PPV):</span>
                        <span class="fw-bold text-dark">25G PPV + ILM Soyulması + C3F8 Gaz Tamponat</span>
                    </div>
                </div>

                <div class="p-2 bg-primary-subtle rounded border border-primary-subtle small text-dark">
                    <strong>Post-PPV Pozisyonu:</strong> Gaz Tamponatı Nedeniyle 5 Gün Yüz Üstü (Prone) Yatak Pozisyonu Önerildi.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card oph-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-circle-dot me-2 text-danger"></i>Retina Birimi Muayene & Anti-VEGF Kayıt Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('ophthalmology.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="retina">
            <input type="hidden" name="redirect_route" value="ophthalmology.retina">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Retina Teşhisi & Fovea Kalınlığı (CFT)</label>
                    <input type="text" name="diagnosis" class="form-control fw-bold border-danger text-danger" value="DMÖ Diyabetik Makula Ödemi - CFT: 410 µm (Aflibercept Enjeksiyonu)">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Anti-VEGF İlaç / Vitrektomi</label>
                    <select name="sub_specialty_data[retina_treatment]" class="form-select">
                        <option value="İntravitreal Aflibercept (Eylea) 2mg/0.05ml">İntravitreal Aflibercept (Eylea)</option>
                        <option value="İntravitreal Ranibizumab (Lucentis) 0.5mg">İntravitreal Ranibizumab (Lucentis)</option>
                        <option value="İntravitreal Deksametazon İmplant (Ozurdex)">İntravitreal Ozurdex İmplant</option>
                        <option value="25G Pars Plana Vitrektomi (PPV) + ILM Peeling">25G PPV Vitrektomi + ILM Peeling</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">FFA Anjiyo & Lazer Yanıtı</label>
                    <input type="text" name="sub_specialty_data[ffa_laser_status]" class="form-control" value="FFA'da Temporal Sızıntı, Panretinal Argon Lazer Yapıldı">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Retinolog Muayene Notları & Fundus Görüntüleme</label>
                <textarea name="notes" class="form-control" rows="4" required placeholder="Retina dekolmanı/yırtık varlığı, makula OCT fovea anatomisi (CFT µm), intraoküler gaz/silikon tamponat seviyesi ve anti-VEGF enjeksiyon seans takip notları..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Retinolog: Prof. Dr. Halil İbrahim Altın</span>
                <button type="submit" class="btn btn-danger text-white fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Retina Kaydını Onayla
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
