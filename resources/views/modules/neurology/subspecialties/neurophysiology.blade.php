@extends('modules.neurology.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-wave-square me-2 text-danger"></i>Klinik Nörofizyoloji Polikliniği (Yan Dal)
@endsection

@section('page_description')
    32 Kanallı Video-EEG monitorizasyonu, EMG sinir iletim hızları (KSK), Tek Lif EMG / Repetitif Uyarım (RNS) ve VEP/SEP uyarılmış potansiyeller.
@endsection

@section('neurology_workspace')
<div class="row g-4 mb-4">
    <!-- 32-Channel Video-EEG Monitoring Card -->
    <div class="col-md-6">
        <div class="card neuro-card h-100 border-start border-4 border-danger">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-danger mb-0"><i class="fa-solid fa-wave-square me-2"></i>32 Kanallı Video-EEG Monitorizasyonu</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Epileptiform Aktivite:</span>
                        <span class="badge bg-danger">Sol Temporal Keskin-Yavaş Dalga</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Zemin Ritmi (Zemin Aktivitesi):</span>
                        <span class="badge bg-success">8-9 Hz Posterior Alfa Ritmi (Normal)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Fotik Uyarım & Hiperventilasyon:</span>
                        <span class="fw-bold text-dark">Hiperventilasyonda Fokal Yavaşlama</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">İktal / İktal Öncesi Deşarj:</span>
                        <span class="small text-muted">Klinik Nörofizyoloji Raporu Onaylandı</span>
                    </div>
                </div>

                <div class="p-2 bg-danger-subtle rounded border border-danger-subtle small text-dark">
                    <i class="fa-solid fa-bolt me-1"></i><strong>Fokal Epilepsi Tanısı:</strong> Sol Temporal Lob Kaynaklı Epileptiform Deşarjlar Onaylandı.
                </div>
            </div>
        </div>
    </div>

    <!-- EMG Nerve Conduction (KSK) & Repetitive Stimulation (RNS) Card -->
    <div class="col-md-6">
        <div class="card neuro-card h-100 border-start border-4 border-warning">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-warning-emphasis mb-0"><i class="fa-solid fa-bolt-lightning me-2"></i>EMG Sinir İletim Hızları (KSK) & RNS / VEP</h6>
            </div>
            <div class="card-body pt-0">
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Motor Sinir İletim Hızı (Peroneal):</span>
                        <span class="badge bg-warning text-dark">34 m/s (Bilateral Nöropatik Yavaşlama)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">F-Dalga Latansı:</span>
                        <span class="badge bg-danger">Uzamış F-Dalga Latansı (Proksimal)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">RNS Repetitif Uyarım (Dekresendo):</span>
                        <span class="badge bg-success">Dekresendo Yanıt Yok (Myasthenia Ekarte)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small fw-bold">VEP (Görsel Uyarılmış Potansiyel):</span>
                        <span class="fw-bold text-dark">P100 Latansı: 104 ms (Normal Optik İletim)</span>
                    </div>
                </div>

                <div class="p-2 bg-warning-subtle rounded border border-warning small text-dark">
                    <strong>Nörofizyolojik Teşhis:</strong> Aksonal & Duyu-Motor Polinöropati Tablosu Uyumlu.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="card neuro-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-wave-square me-2 text-danger"></i>Klinik Nörofizyoloji Tetkik & İnceleme Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('neurology.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="neurophysiology">
            <input type="hidden" name="redirect_route" value="neurology.neurophysiology">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Nörofizyolojik İnceleme Tipi</label>
                    <select name="sub_specialty_data[neurophys_test_type]" class="form-select">
                        <option value="32 Kanallı Routine / Rutin EEG">32 Kanallı Rutin EEG</option>
                        <option value="Tüm Gece Uzun Süreli Video-EEG Monitorizasyonu">Tüm Gece Video-EEG Monitorizasyonu</option>
                        <option value="Üst & Alt Ekstremite Motor/Duyusal EMG (KSK)">EMG Sinir İletim Çalışması (KSK)</option>
                        <option value="RNS Repetitif Uyarım + Tek Lif EMG (Myasthenia)">RNS Repetitif Uyarım + Tek Lif EMG</option>
                        <option value="Uyarılmış Potansiyeller (VEP P100 / SEP / BAEP)">Uyarılmış Potansiyeller (VEP / SEP)</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Nörofizyolojik Bulgular / Teşhis</label>
                    <input type="text" name="diagnosis" class="form-control fw-bold border-danger text-danger" value="EEG: Sol Temporal Fokal Deşarj / EMG: Duyu-Motor Polinöropati">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">İğne EMG İnceleme Kasları</label>
                    <input type="text" name="sub_specialty_data[emg_muscles]" class="form-control" value="M.Tibialis Anterior, M.Gastrocnemius, M.Vastus Lateralis">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Klinik Nörofizyolog Rapor Notları</label>
                <textarea name="notes" class="form-control" rows="4" required placeholder="EEG deşarj lokalizasyonu, amplitude/frekans, EMG bileşik kas aksiyon potansiyeli (CMAP), duyu potansiyel genliği (SNAP) ve F-dalga latansları teknik değerlendirmesi..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Nörofizyolog: Prof. Dr. Zafer Kara</span>
                <button type="submit" class="btn btn-danger text-white fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Nörofizyoloji Kaydını Onayla
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
