@extends('modules.dental.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-syringe text-primary me-2"></i>Endodonti (Kanal Tedavisi)
@endsection

@section('page_description')
    Kök kanal tedavisi, çalışma boyu tespiti (apex locator), döner alet eğeleri ve gutta-percha dolgusu.
@endsection

@section('dental_workspace')
<div class="row g-4 mb-4">
    <!-- Root Canal Working Length Matrix Card -->
    <div class="col-md-7">
        <div class="card dental-card h-100 border-start border-4 border-primary">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-ruler-vertical me-2"></i>Kök Kanal Çalışma Boyu & Eğe Ölçüm Tablosu (Diş #46)</h6>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered align-middle text-center small mb-2">
                        <thead class="table-light">
                            <tr>
                                <th>Kanal Adı</th>
                                <th>Referans Noktası</th>
                                <th>Apex Locator (mm)</th>
                                <th>Ana Eğe (Master File)</th>
                                <th>Durum</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-bold">Mesio-Buccal (MB)</td>
                                <td>MB Tüberkül Tepe</td>
                                <td>20.5 mm</td>
                                <td><span class="badge bg-indigo text-white">ProTaper F2 (#25)</span></td>
                                <td><span class="badge bg-success">Gutta Doldu</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Mesio-Lingual (ML)</td>
                                <td>ML Tüberkül Tepe</td>
                                <td>20.0 mm</td>
                                <td><span class="badge bg-indigo text-white">ProTaper F2 (#25)</span></td>
                                <td><span class="badge bg-success">Gutta Doldu</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Distal (D)</td>
                                <td>Distal Tüberkül</td>
                                <td>21.5 mm</td>
                                <td><span class="badge bg-primary text-white">ProTaper F3 (#30)</span></td>
                                <td><span class="badge bg-success">Gutta Doldu</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="p-2 bg-primary-subtle rounded border border-primary-subtle small">
                    <strong>İrigasyon Protokolü:</strong> %5.25 NaOCl + %17 EDTA + Ultrasonik Aktivasyon.
                </div>
            </div>
        </div>
    </div>

    <!-- Obturation & Canal Sealer Card -->
    <div class="col-md-5">
        <div class="card dental-card h-100 border-start border-4 border-info">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-info mb-0"><i class="fa-solid fa-fill-drip me-2"></i>Kanal Obüturasyon & Pat Bilgisi</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Obüturasyon Tekniği:</span>
                        <span class="badge bg-primary">Sıcak Gutta-Percha (Warm Vertical)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Kanal Patı:</span>
                        <span class="fw-bold text-dark">AH-Plus Reçine Patı</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">Geçici Restorasyon:</span>
                        <span class="badge bg-secondary">Kavit / Cam İyonomer</span>
                    </div>
                </div>

                <div class="p-2 bg-info-subtle rounded border border-info-subtle small">
                    <i class="fa-solid fa-check me-1"></i>Kontrol periapikal röntgeninde apikal örtücülük tam olarak sağlandı.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card dental-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-syringe me-2 text-primary"></i>Endodonti (Kanal Tedavisi) Klinik Kayıt Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('dental.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="patient_id" value="{{ $selectedPatient['id'] }}">
            <input type="hidden" name="sub_specialty" value="dental_endodontics">
            <input type="hidden" name="redirect_route" value="dental.endodontics">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Tedavi Edilen Diş #</label>
                    <input type="text" name="sub_specialty_data[tooth_no]" class="form-control" value="Diş #46 (Sağ Alt 1. Molar)">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Kanal Sayısı & Çalışma Boyu</label>
                    <input type="text" name="sub_specialty_data[working_length]" class="form-control" value="3 Kanal (MB:20.5mm, ML:20mm, D:21.5mm)">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Master Eğe & Döner Alet</label>
                    <input type="text" name="sub_specialty_data[master_file]" class="form-control" value="ProTaper Gold F2 / F3">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Kanal Tedavisi Seansı</label>
                    <select name="sub_specialty_data[session_status]" class="form-select">
                        <option value="Tek Seans Bitti">Tek Seans (Dolgu Bitti)</option>
                        <option value="1. Seans Pansuman (CaOH2)">1. Seans Pansuman (CaOH2 Konuldu)</option>
                        <option value="Kanal Yenileme (Retreatment)">Kanal Yenileme (Retreatment)</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Endodontik Muayene & Perküsyon Notları</label>
                <textarea name="clinical_notes" class="form-control" rows="4" required placeholder="Ağrı şikayeti, cold test yanıtı, dikey/yatay perküsyon hassasiyeti, sinus tract varlığı ve kanal dolgu kalitesi..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Endodontist: Dr. Dt. Ahmet Yılmaz</span>
                <button type="submit" class="btn btn-primary text-white fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Kanal Tedavisi Kaydını Onayla
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
