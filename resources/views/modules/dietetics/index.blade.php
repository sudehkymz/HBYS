@extends('layouts.app')

@push('styles')
<style>
    .dyt-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        background: #fff;
    }
    .patient-item {
        transition: all 0.2s ease;
        border-left: 4px solid transparent;
    }
    .patient-item:hover {
        background-color: #f8f9fa;
    }
    .patient-item.active {
        background-color: #f0fdf4;
        border-left-color: #16a34a;
    }
    .badge-allergen {
        font-size: 0.85rem;
        padding: 5px 10px;
        border-radius: 6px;
        font-weight: 600;
        background-color: #f8d7da;
        color: #842029;
        border: 1px solid #f5c2c7;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-3">
    <!-- Dietetics Main Department Header Banner -->
    <div class="card dyt-card mb-4 bg-white border-top border-4 border-success">
        <div class="card-body p-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-success p-3 d-flex align-items-center justify-content-center text-white" style="width: 52px; height: 52px;">
                        <i class="fa-solid fa-apple-whole fa-2x"></i>
                    </div>
                    <div>
                        <h2 class="h4 mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                            <i class="fa-solid fa-leaf text-success"></i>Beslenme ve Diyetetik Polikliniği
                        </h2>
                        <p class="text-muted small mb-0">BIA Vücut analiz (Tanita), VKİ (BMI) hesaplama, diyet reçeteleri, alerjen kontrolleri & tıbbi beslenme tedavisi.</p>
                    </div>
                </div>

                <div class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 fs-6 rounded-pill">
                    <i class="fa-solid fa-utensils me-1"></i>Tıbbi Beslenme & Diyet Polikliniği
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- Patient List Column -->
        <div class="col-lg-4 col-12 mb-4">
            <div class="card dyt-card h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-hospital-user me-2 text-success"></i>Diyet Hastaları
                    </h5>
                    <span class="badge bg-success-subtle text-success rounded-pill">{{ count($dytAdmissions) }} Hasta</span>
                </div>
                <div class="list-group list-group-flush" style="max-height: 750px; overflow-y: auto;">
                    @forelse($dytAdmissions as $adm)
                        <a href="{{ route('dietetics.index', ['admission_id' => $adm['id']]) }}" 
                           class="list-group-item list-group-item-action patient-item py-3 {{ ($selectedAdmission && $selectedAdmission['id'] == $adm['id']) ? 'active' : '' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-1 text-dark">{{ $adm['patient_name'] }}</h6>
                                <span class="badge bg-success-subtle text-success border border-success-subtle">{{ $adm['age'] }} Yaş</span>
                            </div>
                            <div class="text-muted small mt-1">
                                <div><i class="fa-solid fa-building me-1"></i><strong>{{ $adm['service'] }}</strong></div>
                                <div class="fw-medium text-secondary mt-1"><i class="fa-solid fa-notes-medical me-1"></i>{{ $adm['diagnosis'] }}</div>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="fa-solid fa-hospital-user fa-3x mb-3 opacity-30"></i>
                            <p>Aktif diyet hastası bulunmamaktadır.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Main Workspace Column -->
        <div class="col-lg-8 col-12">
            @if($selectedAdmission)
                <!-- Active Patient Dossier Card -->
                <div class="card dyt-card mb-4 border-start border-success border-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-success text-white mb-2">Aktif Diyetisyen Dosyası</span>
                                <h3 class="fw-bold text-dark mb-1">{{ $selectedAdmission['patient_name'] }}</h3>
                                <p class="text-muted small mb-0">
                                    <strong>T.C.:</strong> {{ $selectedAdmission['national_id'] }} | 
                                    <strong>Yaş/Cinsiyet:</strong> {{ $selectedAdmission['age'] }} Yaş ({{ $selectedAdmission['gender'] }}) | 
                                    <strong>Oda/Birim:</strong> {{ $selectedAdmission['room'] }}
                                </p>
                                <div class="mt-2 p-2 bg-light rounded border small">
                                    <i class="fa-solid fa-user-doctor text-success me-1"></i>
                                    <strong>Diyetisyen:</strong> {{ $selectedAdmission['attending_physician'] }} | 
                                    <strong>Tıbbi Beslenme Tanısı:</strong> {{ $selectedAdmission['diagnosis'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BIA Body Analysis & Nutrition Therapy Cards -->
                <div class="row g-4 mb-4">
                    <!-- BIA Bioelectrical Impedance Body Composition Card -->
                    <div class="col-md-6">
                        <div class="card dyt-card h-100 border-start border-4 border-success">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-success mb-0"><i class="fa-solid fa-weight-scale me-2"></i>BIA Vücut Analizi (Tanita) & VKİ</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Vücut Kitle İndeksi (VKİ / BMI):</span>
                                        <span class="badge bg-danger fs-6">32.4 kg/m² (Evre 1 Obezite)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Vücut Yağ Oranı (%):</span>
                                        <span class="badge bg-warning text-dark">%31.8 (Yağ Kütlesi: 31.1 kg)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Kas Kütlesi (Skeletal Muscle):</span>
                                        <span class="fw-bold text-dark">62.5 kg (Kas Kütlesi Korunmuş)</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">Bazal Metabolizma Hızı (BMR):</span>
                                        <span class="badge bg-primary">1890 kcal / Gün</span>
                                    </div>
                                </div>

                                <div class="p-2 bg-success-subtle rounded border border-success small text-dark">
                                    <i class="fa-solid fa-circle-check me-1"></i><strong>BIA Vücut Analizi:</strong> Visseral Yağ Seviyesi 11 (Orta Düzey Artış) Olarak Ölçüldü.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Medical Nutrition Therapy & Caloric Plan Card -->
                    <div class="col-md-6">
                        <div class="card dyt-card h-100 border-start border-4 border-primary">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-bowl-rice me-2"></i>Tıbbi Diyet Reçetesi & Makro Dengesi</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Günlük Kalori Reçetesi:</span>
                                        <span class="badge bg-primary fs-6">1800 kcal / Gün (Akdeniz Tipi)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Karbonhidrat Makro Dağılımı:</span>
                                        <span class="fw-bold text-dark">%50 Karbonhidrat (225gr CHO)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-bold">Protein Makro Dağılımı:</span>
                                        <span class="fw-bold text-dark">%20 Protein (90gr Protein)</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold">Yağ Dağılımı (Zeytinyağı):</span>
                                        <span class="fw-bold text-dark">%30 Sağlıklı Yağ (60gr Yağ)</span>
                                    </div>
                                </div>

                                <div class="p-2 bg-primary-subtle rounded border border-primary-subtle small text-dark">
                                    <strong>Kontrol Randevusu:</strong> 15 Gün Sonra 2. BIA Analizi ve Ağırlık Kaybı Değerlendirmesi Planlandı.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Diet Program Assignment & Allergen Checklist Card (Integrated from Nutrition Module) -->
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="card dyt-card p-4 h-100 border-start border-4 border-success">
                            <h5 class="fw-bold text-success mb-3"><i class="fa-solid fa-utensils me-2"></i>Diyet Programı & Alerjen Kontrolü</h5>
                            <form action="{{ route('dietetics.store_exam') }}" method="POST">
                                @csrf
                                <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Diyet Tipi / Reçete</label>
                                    <select class="form-select" name="form_data[diet_type]" required>
                                        <option value="1800 kcal Akdeniz Tipi Zayıflama Diyeti">1800 kcal Akdeniz Tipi Zayıflama Diyeti</option>
                                        <option value="Diyabetik Karbonhidrat Sayımı Diyeti">Diyabetik Karbonhidrat Sayımı Diyeti</option>
                                        <option value="Tuzsuz (Düşük Sodyum) Renal Diyet">Tuzsuz (Düşük Sodyum) Renal Diyet</option>
                                        <option value="Glutensiz Çölyak Diyet Protokolü">Glutensiz Çölyak Diyet Protokolü</option>
                                        <option value="Bariyatri Yüksek Proteinli Püre Diyeti">Bariyatri Yüksek Proteinli Püre Diyeti</option>
                                        <option value="Post-Op Berrak Sıvı Diyet">Post-Op Berrak Sıvı Diyet</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Bilinen Besin Alerjileri / Hassasiyetleri</label>
                                    <div class="p-2 border rounded bg-light" style="max-height: 150px; overflow-y: auto;">
                                        @foreach(['Gluten', 'Laktoz', 'Kuruyemiş', 'Çilek', 'Deniz Ürünleri', 'Soya'] as $all)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="form_data[allergens][]" value="{{ $all }}" id="all_{{ $loop->index }}">
                                                <label class="form-check-label" for="all_{{ $loop->index }}">{{ $all }} Alerjisi</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Sorumlu Diyetisyen</label>
                                    <input type="text" class="form-control" name="form_data[nutritionist]" value="{{ $selectedAdmission['attending_physician'] }}" required>
                                </div>

                                <button type="submit" class="btn btn-success w-100 fw-bold">
                                    <i class="fa-solid fa-save me-1"></i>Beslenme Planını Kaydet
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Active Diet Prescription & Printable Document Card -->
                    <div class="col-md-6">
                        <div class="card dyt-card p-4 h-100 border-start border-4 border-info">
                            <h5 class="fw-bold text-info mb-3"><i class="fa-solid fa-circle-info me-2"></i>Aktif Diyet Reçetesi & Yazdırma</h5>
                            <div id="activeDietDetails-{{ $selectedAdmission['id'] }}">
                                <div class="bg-light p-3 rounded border">
                                    <h6 class="fw-bold text-success mb-2"><i class="fa-solid fa-carrot me-2"></i>1800 kcal Akdeniz Tipi Zayıflama Diyeti</h6>
                                    <p class="text-muted small mb-3">Tüm temel besin gruplarını içeren, zeytinyağı ve lif açısından zengin tıbbi beslenme tedavisi.</p>
                                    
                                    <p class="mb-2"><strong>Hasta Adı:</strong> {{ $selectedAdmission['patient_name'] }}</p>
                                    <p class="mb-2"><strong>T.C. Kimlik:</strong> {{ $selectedAdmission['national_id'] }}</p>
                                    <p class="mb-2"><strong>Diyetisyen:</strong> {{ $selectedAdmission['attending_physician'] }}</p>
                                    <p class="mb-2"><strong>Düzenlenme Zamanı:</strong> {{ now()->format('d.m.Y H:i') }}</p>
                                    
                                    <div class="mt-3">
                                        <strong class="d-block mb-1 small text-secondary">Alerjen Rozetleri:</strong>
                                        <span class="badge-allergen me-1 d-inline-block">Laktoz Hassasiyeti</span>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle">Gluten Hassasiyeti Yok</span>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-outline-success btn-sm mt-3 w-100 fw-bold" onclick="printDiv('activeDietDetails-{{ $selectedAdmission['id'] }}', 'Diyet Reçete Belgesi')">
                                <i class="fa-solid fa-print me-1"></i>Diyeti Yazdır
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Main Examination & Clinical Notes Form -->
                <div class="card dyt-card mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="fa-solid fa-file-medical me-2 text-success"></i>Beslenme & Diyetisyeni Kayıt Formu
                        </h5>
                    </div>
                    <div class="card-body pt-0">
                        <form action="{{ route('dietetics.store_exam') }}" method="POST">
                            @csrf
                            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">

                            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Beslenme Tanısı & VKİ</label>
                                    <input type="text" name="diagnosis" class="form-control fw-bold border-success text-success" value="Evre 1 Obezite - VKİ: 32.4 kg/m² (1800 kcal Akdeniz Diyeti)">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Diyet Tedavi Protokolü</label>
                                    <select name="form_data[diet_protocol]" class="form-select">
                                        <option value="1800 kcal Akdeniz Tipi Zayıflama Diyeti">1800 kcal Akdeniz Tipi Zayıflama Diyeti</option>
                                        <option value="Diyabetik Karbonhidrat Sayımı Diyeti">Diyabetik Karbonhidrat Sayımı Diyeti</option>
                                        <option value="Düşük Sodyumlu Renal Beslenme Tedavisi">Düşük Sodyumlu Renal Beslenme Tedavisi</option>
                                        <option value="Bariyatri Yüksek Proteinli Püre Diyeti">Bariyatri Yüksek Proteinli Püre Diyeti</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">BIA Yağ % & BMR Değeri</label>
                                    <input type="text" name="form_data[bia_summary]" class="form-control" value="Yağ %31.8, BMR: 1890 kcal, Visseral Yağ: 11">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Diyetisyen Muayene Notları & Beslenme Günlüğü</label>
                                <textarea name="notes" class="form-control" rows="4" required placeholder="Beslenme alışkanlıkları günlüğü, öğün atlama durumu, su tüketimi (litre/gün), fiziksel aktivite seviyesi ve kaçınılması gereken gıdalar listesi..."></textarea>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Diyetisyen: {{ $selectedAdmission['attending_physician'] }}</span>
                                <button type="submit" class="btn btn-success text-white fw-bold px-4 py-2">
                                    <i class="fa-solid fa-floppy-disk me-2"></i>Diyet Kaydını Onayla
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            @else
                <div class="card dyt-card py-5 text-center">
                    <div class="card-body">
                        <i class="fa-solid fa-apple-whole fa-4x text-success mb-3 opacity-40"></i>
                        <h5>Diyet Hasta Başvurusu Seçiniz</h5>
                        <p class="text-muted">Sol listeden muayenesini gerçekleştirmek istediğiniz hastayı seçiniz.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function printDiv(divId, title) {
        const divToPrint = document.getElementById(divId);
        const newWin = window.open('', 'Print-Window');
        newWin.document.write(`
            <html>
            <head>
                <title>${title}</title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                <style>
                    body { padding: 30px; font-family: sans-serif; }
                    .print-header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #dee2e6; padding-bottom: 10px; }
                    .badge-allergen { font-size: 0.85rem; padding: 5px 10px; border-radius: 6px; font-weight: 600; background-color: #f8d7da; color: #842029; border: 1px solid #f5c2c7; }
                </style>
            </head>
            <body onload="window.print(); window.close();">
                <div class="print-header">
                    <h3>YEBSOFT SAĞLIK GRUBU</h3>
                    <h5>Tıbbi Beslenme & Diyet Belgesi</h5>
                </div>
        ` + divToPrint.innerHTML + `
            </body>
            </html>
        `);
        newWin.document.close();
    }
</script>
@endpush
