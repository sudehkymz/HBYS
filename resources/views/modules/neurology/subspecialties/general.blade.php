@extends('modules.neurology.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-brain me-2" style="color: #7c3aed;"></i>Nöroloji Polikliniği (Ana Branş)
@endsection

@section('page_description')
    Akut inme NIHSS skoru, tPA tromboliz, Multipl Skleroz EDSS takibi, Parkinson UPDRS ve anti-epileptik ilaç düzeyleri.
@endsection

@section('neurology_workspace')
<div class="row g-4 mb-4">
    <!-- NIHSS Acute Stroke Score & tPA Thrombolysis Card -->
    <div class="col-md-6">
        <div class="card neuro-card h-100 border-start border-4 border-danger">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-danger mb-0"><i class="fa-solid fa-hospital-user me-2"></i>NIHSS Akut İnme Skoru & IV tPA Tromboliz</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">NIHSS Akut Skoru:</span>
                        <span class="badge bg-danger fs-6">NIHSS: 14 Puan (Orta-Şiddetli İnme)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">IV tPA (Alteplase) Dozu:</span>
                        <span class="badge bg-success">0.9 mg/kg (İnfüzyon Sonrası NIHSS 6)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">MR Difüzyon (DWI):</span>
                        <span class="fw-bold text-dark">Sol Kapsula İnterna Akut İskemik Enfarkt</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Göz/Yüz Motoru & Konuşma:</span>
                        <span class="small text-muted">Dizarthri + Sağ Hemiparezili Akut Tablo</span>
                    </div>
                </div>

                <div class="p-2 bg-danger-subtle rounded border border-danger-subtle small text-dark">
                    <i class="fa-solid fa-bolt me-1"></i><strong>İnme Ünitesi Takibi:</strong> Tromboliz Sonrası 24. Saat Kontrol Beyin BT Kanama Yok.
                </div>
            </div>
        </div>
    </div>

    <!-- Multiple Sclerosis EDSS Score & Parkinson UPDRS Card -->
    <div class="col-md-6">
        <div class="card neuro-card h-100 border-start border-4" style="border-left-color: #7c3aed !important;">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold mb-0" style="color: #7c3aed;"><i class="fa-solid fa-microscope me-2"></i>MS (EDSS Skoru) & Parkinson (UPDRS Skoru)</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">MS EDSS Özürlülük Skoru:</span>
                        <span class="badge bg-primary">EDSS: 3.5 (Orta Piramidal/Serebellar)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Parkinson UPDRS Skoru:</span>
                        <span class="badge bg-warning text-dark">UPDRS: 26 / 108 (ON Dönemi)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Kranial MR Plak Yükü:</span>
                        <span class="fw-bold text-dark">14 Adet T2/FLAIR Hiperintens Plak</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Levetirasetam Kan Düzeyi:</span>
                        <span class="badge bg-success">32 µg/mL (Terapötik Hedefte)</span>
                    </div>
                </div>

                <div class="p-2 rounded border small text-dark" style="background-color: #f5f3ff; border-color: #ddd6fe !important;">
                    <strong>MS Biyolojik Tedavisi:</strong> Ocrelizumab 600mg Altı Aylık İnfaz Protokolü Onaylandı.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card neuro-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-brain me-2" style="color: #7c3aed;"></i>Nöroloji Muayene & Nörolojik Skalalar Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('neurology.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="general">
            <input type="hidden" name="redirect_route" value="neurology.index">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Nörolojik Teşhis & Skala</label>
                    <input type="text" name="diagnosis" class="form-control fw-bold border-purple" style="border-color: #7c3aed !important; color: #7c3aed;" value="Akut Sol MCA İnme NIHSS: 14 / MS EDSS: 3.5 (Tromboliz Yapıldı)">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Reçete Edilen Nörolojik İlaç</label>
                    <select name="sub_specialty_data[neurology_medication]" class="form-select">
                        <option value="Ocrelizumab 600mg İnfazı (MS Biyolojik)">Ocrelizumab 600mg İnfazı (MS Biyolojik)</option>
                        <option value="Levetirasetam 1000mg 2x1 (Anti-Epileptik)">Levetirasetam 1000mg 2x1 (Anti-Epileptik)</option>
                        <option value="Levodopa/Benserazid 100/25mg 4x1 (Parkinson)">Levodopa/Benserazid 100/25mg 4x1 (Parkinson)</option>
                        <option value="Klopidogrel 75mg 1x1 + Statin (İnme İkincil Koruma)">Klopidogrel 75mg + Statin (Sekonder Koruma)</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Nöro-Görüntüleme İlemi</label>
                    <input type="text" name="sub_specialty_data[imaging_request]" class="form-control" value="Kranial Difüzyon MR + Kontrastlı Brain MR">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Nörolog Muayene & Kraniyofasiyal Notlar</label>
                <textarea name="notes" class="form-control" rows="4" required placeholder="Kraniyal sinir muayenesi (I-XII), motor kas gücü (0-5), derin tendon refleksleri (DTR klonus), serebellar dismetri/dizdiyadokokinezi ve NIHSS/EDSS detaylı skorlama notları..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Nöroloji Uzmanı: Prof. Dr. Zafer Kara</span>
                <button type="submit" class="btn text-white fw-bold px-4 py-2" style="background-color: #7c3aed;">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Nöroloji Kaydını Onayla
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
