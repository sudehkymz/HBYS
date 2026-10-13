@extends('modules.pediatrics.subspecialties.layout')

@section('page_title')
    <i class="fa-solid fa-child-reaching text-indigo me-2"></i>Çocuk Sağlığı ve Hastalıkları (Ana Branş)
@endsection

@section('page_description')
    0-18 yaş genel fiziksel muayene, koruyucu hekimlik, büyüme ve gelişme takibi.
@endsection

@section('subspecialty_workspace')
<div class="card ped-card mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-stethoscope me-2 text-indigo"></i>Genel Pediatri Muayene & Reçete Formu
        </h5>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('pediatrics.store_exam') }}" method="POST">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $selectedAdmission['id'] }}">
            <input type="hidden" name="sub_specialty" value="pediatrics_general">
            <input type="hidden" name="redirect_route" value="pediatrics.index">

            <div class="mb-3">
                <label class="form-label fw-bold">Genel Pediatri Şikayet & Muayene Notları</label>
                <textarea name="clinical_notes" class="form-control" rows="5" required placeholder="Genel fizik muayene bulguları, boğaz, kulak, beslenme ve aşı takvimi kontrolü..."></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fa-solid fa-user-doctor me-1"></i>Hekim: {{ auth()->user()->name ?? 'Prof. Dr. Ahmet Can' }}</span>
                <button type="submit" class="btn btn-indigo text-white fw-bold px-4 py-2" {{ (empty($selectedAdmission['triage']['completed'])) ? 'disabled' : '' }}>
                    <i class="fa-solid fa-floppy-disk me-2"></i>Genel Pediatri Muayenesini Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
