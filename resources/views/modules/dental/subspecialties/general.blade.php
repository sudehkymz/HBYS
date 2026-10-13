@extends('modules.dental.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-stethoscope text-primary me-2"></i>Genel Diş Hekimliği
@endsection

@section('page_description')
    Genel ağız ve diş muayenesi, detertraj (diş taşı temizliği), ağız hijyeni eğitimi.
@endsection

@section('dental_workspace')
<div class="card dental-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-stethoscope me-2 text-primary"></i>Genel Diş Muayene & İşlem Giriş Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('dental.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="patient_id" value="{{ $selectedPatient['id'] }}">
            <input type="hidden" name="sub_specialty" value="dental_general">
            <input type="hidden" name="redirect_route" value="dental.index">

            <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Ağız Hijyeni İndeksi</label>
                    <select name="sub_specialty_data[hygiene_index]" class="form-select">
                        <option value="İyi (İdeal Hijyen)">İyi (İdeal Hijyen)</option>
                        <option value="Orta (Diş Taşı Mevcut)">Orta (Diş Taşı Mevcut)</option>
                        <option value="Kötü (Detertraj Gerekli)">Kötü (Detertraj Gerekli)</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Diş Taşı Temizliği (Detertraj)</label>
                    <select name="sub_specialty_data[scaling_done]" class="form-select">
                        <option value="Uygulanmadı">Uygulanmadı</option>
                        <option value="Ultrasonik Detertraj Yapıldı">Ultrasonik Detertraj Yapıldı</option>
                        <option value="Polisaj + Detertraj Yapıldı">Polisaj + Detertraj Yapıldı</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Sevk Edilecek Branş</label>
                    <select name="sub_specialty_data[referral_branch]" class="form-select">
                        <option value="Yok (İşlem Tamamlandı)">Yok (İşlem Tamamlandı)</option>
                        <option value="Endodonti (Kanal Tedavisi)">Endodonti (Kanal Tedavisi)</option>
                        <option value="Çene Cerrahisi">Çene Cerrahisi (20'lik Diş)</option>
                        <option value="Periodontoloji">Periodontoloji (Diş Eti)</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Diş Muayene & Tedavi Plan Notları</label>
                <textarea name="clinical_notes" class="form-control" rows="4" required placeholder="Genel ağız muayene bulguları, çürük diş tespitleri, detertraj ve hastaya verilen diş fırçalama önerileri..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Hekim: Dr. Dt. Ahmet Yılmaz</span>
                <button type="submit" class="btn btn-primary text-white fw-bold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Diş Muayenesini Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
