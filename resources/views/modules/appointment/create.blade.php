@extends('layouts.app')

@section('title', 'Yeni Randevu Al')

@section('content')
<div class="container-fluid px-0">

    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h3 class="fw-bold mb-1 text-dark">
                <i class="fa-solid fa-calendar-plus text-primary me-2"></i>Yeni Poliklinik Randevusu Oluştur
            </h3>
            <p class="text-muted small mb-0">Doktor ve tarih seçerek uygun zaman diliminden randevu oluşturabilirsiniz.</p>
        </div>
        <a href="{{ route('appointments.index') }}" class="btn btn-outline-secondary">
            <i class="fa-solid fa-arrow-left me-1"></i> Listeye Dön
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm" style="border-radius:14px;">
        <div class="card-body p-4">

            <form action="{{ route('appointments.store') }}" method="POST">
                @csrf

                <div class="row g-4">
                    {{-- Hasta Seçimi --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">1. Hasta Seçimi <span class="text-danger">*</span></label>
                        <select name="patient_id" class="form-select select2" required>
                            <option value="">-- Randevu Alınacak Hastayı Seçin --</option>
                            @foreach($patients as $p)
                                <option value="{{ $p->id }}" {{ ($selectedPatientId == $p->id || old('patient_id') == $p->id) ? 'selected' : '' }}>
                                    {{ $p->full_name }} (T.C.: {{ $p->national_id }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Doktor Seçimi --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">2. Hekim / Doktor Seçimi <span class="text-danger">*</span></label>
                        <select name="doctor_id" id="doctor_id" class="form-select" required>
                            <option value="">-- Randevu Verilecek Hekimi Seçin --</option>
                            @foreach($doctors as $d)
                                <option value="{{ $d->id }}" {{ old('doctor_id') == $d->id ? 'selected' : '' }}>
                                    {{ $d->name }} — Uzmanlık: {{ $d->specialty ?? 'Poliklinik' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tarih Seçimi --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">3. Randevu Tarihi <span class="text-danger">*</span></label>
                        <input type="date" name="appointment_date" id="appointment_date" class="form-control"
                               min="{{ date('Y-m-d') }}" value="{{ old('appointment_date', date('Y-m-d')) }}" required>
                    </div>

                    {{-- Şikayet / Not --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Şikayet / Ön Not</label>
                        <input type="text" name="notes" class="form-control" placeholder="Örn: Baş ağrısı ve rutin kontrol" value="{{ old('notes') }}">
                    </div>

                    {{-- Canlı Müsait Saat Dilimleri (Slots) --}}
                    <div class="col-12">
                        <label class="form-label fw-bold d-block">4. Müsait Saat Dilimi Seçin <span class="text-danger">*</span></label>
                        <input type="hidden" name="appointment_time" id="selected_time" value="{{ old('appointment_time') }}" required>

                        <div id="slots_container" class="p-3 border rounded bg-light min-height-100">
                            <p class="text-muted mb-0 small"><i class="fa-solid fa-info-circle me-1"></i>Lütfen saat dilimlerini yüklemek için önce Hekim ve Tarih seçiniz.</p>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top text-end">
                    <a href="{{ route('appointments.index') }}" class="btn btn-light me-2">İptal</a>
                    <button type="submit" class="btn btn-primary px-5 fw-bold"><i class="fa-solid fa-calendar-check me-2"></i>Randevuyu Onayla ve Oluştur</button>
                </div>

            </form>

        </div>
    </div>

</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const doctorSelect = document.getElementById('doctor_id');
        const dateInput = document.getElementById('appointment_date');
        const slotsContainer = document.getElementById('slots_container');
        const selectedTimeInput = document.getElementById('selected_time');

        function loadSlots() {
            const doctorId = doctorSelect.value;
            const dateVal = dateInput.value;

            if (!doctorId || !dateVal) {
                slotsContainer.innerHTML = '<p class="text-muted mb-0 small"><i class="fa-solid fa-info-circle me-1"></i>Lütfen saat dilimlerini yüklemek için Hekim ve Tarih seçiniz.</p>';
                return;
            }

            slotsContainer.innerHTML = '<p class="text-primary mb-0 small"><i class="fa-solid fa-spinner fa-spin me-1"></i>Müsait saat dilimleri sorgulanıyor...</p>';

            fetch(`{{ route('appointments.slots') }}?doctor_id=${doctorId}&appointment_date=${dateVal}`)
                .then(res => res.json())
                .then(data => {
                    if (!data.slots || data.slots.length === 0) {
                        slotsContainer.innerHTML = '<p class="text-danger mb-0 small">Bu tarihte uygun saat dilimi bulunamadı.</p>';
                        return;
                    }

                    let html = '<div class="row g-2">';
                    data.slots.forEach(slot => {
                        const disabled = slot.is_booked ? 'disabled' : '';
                        const btnClass = slot.is_booked ? 'btn-outline-secondary opacity-50' : 'btn-outline-primary slot-btn';
                        html += `
                            <div class="col-4 col-sm-3 col-md-2 col-lg-1">
                                <button type="button" class="btn ${btnClass} w-100 btn-sm py-2 fw-semibold" ${disabled} data-time="${slot.time}">
                                    ${slot.time}
                                </button>
                            </div>
                        `;
                    });
                    html += '</div>';
                    slotsContainer.innerHTML = html;

                    // Click event to select slot
                    document.querySelectorAll('.slot-btn').forEach(btn => {
                        btn.addEventListener('click', function () {
                            document.querySelectorAll('.slot-btn').forEach(b => {
                                b.classList.remove('btn-primary', 'text-white');
                                b.classList.add('btn-outline-primary');
                            });
                            this.classList.remove('btn-outline-primary');
                            this.classList.add('btn-primary', 'text-white');
                            selectedTimeInput.value = this.getAttribute('data-time');
                        });
                    });
                })
                .catch(() => {
                    slotsContainer.innerHTML = '<p class="text-danger mb-0 small">Saat dilimleri yüklenirken bir hata oluştu.</p>';
                });
        }

        doctorSelect.addEventListener('change', loadSlots);
        dateInput.addEventListener('change', loadSlots);

        if (doctorSelect.value && dateInput.value) {
            loadSlots();
        }
    });
</script>
@endpush
@endsection
