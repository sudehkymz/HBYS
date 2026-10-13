@extends('modules.specialized_clinics.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-dna text-success me-2"></i>Tıbbi Genetik (Tanısal & Danışmanlık)
@endsection

@section('page_description')
    Karyotip sitogenetik analizi, WES/WGS DNA dizileme, kalıtsal mutasyon testi ve genetik danışmanlık.
@endsection

@section('specialized_workspace')
<div class="row g-4 mb-4">
    <!-- Karyotype Cytogenetic Analysis Card -->
    <div class="col-md-6">
        <div class="card spec-card h-100 border-start border-4 border-success">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-success mb-0"><i class="fa-solid fa-microscope me-2"></i>Sitogenetik Karyotip Analizi</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Karyotip Formülü:</span>
                        <span class="badge bg-success">46, XX (Normal Dişi Karyotip)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Bantlama Tekniği:</span>
                        <span class="fw-bold text-dark">GTG-Bantlama (550 Bant Çözünürlük)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Kromozom Anomali:</span>
                        <span class="small text-muted">Sayısal/Yapısal Anomali Saptanmadı</span>
                    </div>
                </div>

                <div class="p-2 bg-success-subtle rounded border border-success small">
                    <i class="fa-solid fa-dna me-1"></i>20 Hücre Analiz Edildi: Tümü Nümeryal & Yapısal Olarak Dengeli.
                </div>
            </div>
        </div>
    </div>

    <!-- WES Next-Gen Sequencing Card -->
    <div class="col-md-6">
        <div class="card spec-card h-100 border-start border-4 border-info">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-info mb-0"><i class="fa-solid fa-vial-virus me-2"></i>WES (Tüm Ekzom Dizileme) Analizi</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Saptanan Mutasyon:</span>
                        <span class="badge bg-warning text-dark">Heterozigot VUS Mutasyon</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Hedef Gen:</span>
                        <span class="fw-bold text-dark">FBN1 Geni (c.4082G>A, p.R1361H)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Kalıtım Modeli:</span>
                        <span class="small text-muted">Otozomal Dominant Geçişli</span>
                    </div>
                </div>

                <div class="p-2 bg-info-subtle rounded border border-info-subtle small text-dark">
                    <strong>Genetik Danışmanlık:</strong> Aile içi segregasyon analizi için anne-baba DNA örneği istendi.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card spec-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-dna me-2 text-success"></i>Tıbbi Genetik Tanı & Danışmanlık Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('specialized.store_report') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="unit" value="medical_genetics">
            <input type="hidden" name="redirect_route" value="specialized.genetics">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Karyotip Sitogenetik Raporu</label>
                    <input type="text" name="status_score" class="form-control fw-bold border-success text-success" value="46, XX Normal Dişi Karyotip">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">WES / WGS Moleküler Genetik Sonucu</label>
                    <input type="text" name="sub_specialty_data[wes_result]" class="form-control" value="FBN1 Geni c.4082G>A (p.R1361H) Heterozigot">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Genetik Danışmanlık Statüsü</label>
                    <select name="sub_specialty_data[counseling_status]" class="form-select">
                        <option value="Pre-test Danışmanlık Verildi">Pre-test Danışmanlık Verildi</option>
                        <option value="Post-test Danışmanlık Verildi">Post-test Danışmanlık Verildi</option>
                        <option value="Aile İçi Segregasyon Analizi Planlandı">Aile İçi Segregasyon Analizi Planlandı</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Genetik Danışman Raporu & Dismorfoloji Notları</label>
                <textarea name="findings" class="form-control" rows="4" required placeholder="Dismorfik muayene bulguları, pedigri soyağacı analizi, prenatal tanı önerileri ve moleküler genetik sonuç dökümü..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Genetik Uzmanı: Uzm. Dr. Sevgi Yılmaz</span>
                <button type="submit" class="btn btn-success text-white fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Genetik Raporunu Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
