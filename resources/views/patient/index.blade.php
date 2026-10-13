@extends('layouts.app')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
        <h2 class="h3 fw-bold mb-1"><i class="fa-solid fa-user-injured text-primary me-2"></i>Hasta Ana Kayıt & Arama</h2>
        <p class="text-muted small mb-0">Sistemdeki tüm hasta kayıtlarını arayın, görüntüleyin ve hızlıca yeni hasta tanımlayın.</p>
    </div>
    <!-- Sayfa değiştirmeden anında açılan Modal Butonu -->
    <button type="button" class="btn btn-primary shadow-sm text-nowrap" data-bs-toggle="modal" data-bs-target="#patientModal" onclick="openCreatePatientModal()">
        <i class="fa-solid fa-user-plus me-1"></i> Yeni Hasta Kaydı
    </button>
</div>

<!-- Hasta Arama Kartı -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3">
        <form action="{{ route('patients.index') }}" method="GET" class="row g-2">
            <div class="col-12 col-md-9 col-lg-10">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="T.C. Kimlik No, Ad, Soyad veya Telefon ile arayın..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-12 col-md-3 col-lg-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fa-solid fa-magnifying-glass me-1"></i> Ara
                </button>
                @if(request('search'))
                    <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary" title="Filtreyi Temizle">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm dynamic-list-card">
    <div class="card-header bg-white border-0 fw-bold py-3 d-flex justify-content-between align-items-center">
        <span class="fs-6"><i class="fa-solid fa-users text-primary me-2"></i>Kayıtlı Hasta Listesi</span>
        <span class="badge bg-primary rounded-pill" id="patientBadge">{{ count($patients) }} Hasta Kayıtlı</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive dynamic-table-scroll">
            <table class="table table-hover align-middle mb-0" data-dynamic-filter="true" data-count-badge="#patientBadge">
                <thead class="sticky-table-header">
                    <tr>
                        <th class="ps-3">T.C. Kimlik No</th>
                        <th>Ad Soyad</th>
                        <th>Doğum Tarihi / Cinsiyet</th>
                        <th>Kan Grubu</th>
                        <th>Telefon</th>
                        <th class="text-end pe-3">İşlemler</th>
                    </tr>
                    <tr class="table-filter-row">
                        <th class="ps-3"><input type="text" class="form-control table-filter-input" data-col-index="0" placeholder="TC Kimlik No ara..."></th>
                        <th><input type="text" class="form-control table-filter-input" data-col-index="1" placeholder="Ad Soyad ara..."></th>
                        <th>
                            <select class="form-select table-filter-select" data-col-index="2">
                                <option value="">Tüm Cinsiyetler</option>
                                <option value="erkek">Erkek</option>
                                <option value="kadın">Kadın</option>
                            </select>
                        </th>
                        <th>
                            <select class="form-select table-filter-select" data-col-index="3">
                                <option value="">Tüm Kan Grupları</option>
                                <option value="A Rh+">A Rh+</option>
                                <option value="A Rh-">A Rh-</option>
                                <option value="B Rh+">B Rh+</option>
                                <option value="B Rh-">B Rh-</option>
                                <option value="AB Rh+">AB Rh+</option>
                                <option value="AB Rh-">AB Rh-</option>
                                <option value="0 Rh+">0 Rh+</option>
                                <option value="0 Rh-">0 Rh-</option>
                            </select>
                        </th>
                        <th><input type="text" class="form-control table-filter-input" data-col-index="4" placeholder="Telefon ara..."></th>
                        <th class="text-end pe-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patients as $patient)
                        <tr>
                            <td class="ps-3 fw-bold text-secondary">{{ $patient->national_id }}</td>
                            <td class="fw-semibold">
                                <a href="{{ route('patients.show', $patient) }}" class="text-decoration-none text-dark fw-bold" title="Hasta Dosyası & Tüm İşlemler">
                                    {{ $patient->full_name }}
                                </a>
                            </td>
                            <td>
                                {{ $patient->birth_date ? $patient->birth_date->format('d.m.Y') : '-' }} 
                                <span class="badge bg-light text-dark ms-1 border">
                                    {{ $patient->gender === 'male' ? 'Erkek' : ($patient->gender === 'female' ? 'Kadın' : 'Diğer') }}
                                </span>
                            </td>
                            <td>
                                @if($patient->blood_type)
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger-subtle">{{ $patient->blood_type }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $patient->phone ?? '-' }}</td>
                            <td class="text-end pe-3">
                                <!-- Desktop Button Group -->
                                <div class="d-none d-lg-inline-flex gap-1">
                                    <a href="{{ route('patients.show', $patient) }}" class="btn btn-sm btn-primary" title="Tüm Klinik İşlemler">
                                        <i class="fa-solid fa-folder-open me-1"></i> Detay / İşlemler
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-info" onclick="showPatientCard({{ $patient->id }})" title="Hızlı Önlizleme Kartı">
                                        <i class="fa-solid fa-id-card"></i> Hızlı Kart
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-warning" onclick="editPatient({{ $patient->id }})">
                                        <i class="fa-solid fa-pen"></i> Düzenle
                                    </button>
                                    <form action="{{ route('patients.destroy', $patient) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu hasta kaydını silmek istediğinize emin misiniz?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                <!-- Mobile / Tablet Dropdown Menu -->
                                <div class="dropdown d-inline-block d-lg-none">
                                    <button class="btn btn-sm btn-light border dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        İşlemler
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                        <li>
                                            <a class="dropdown-menu-item dropdown-item text-primary" href="{{ route('patients.show', $patient) }}">
                                                <i class="fa-solid fa-folder-open me-2"></i>Detay / İşlemler
                                            </a>
                                        </li>
                                        <li>
                                            <button class="dropdown-item" type="button" onclick="showPatientCard({{ $patient->id }})">
                                                <i class="fa-solid fa-id-card me-2 text-info"></i>Hızlı Kart
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item" type="button" onclick="editPatient({{ $patient->id }})">
                                                <i class="fa-solid fa-pen me-2 text-warning"></i>Düzenle
                                            </button>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('patients.destroy', $patient) }}" method="POST" onsubmit="return confirm('Bu hasta kaydını silmek istediğinize emin misiniz?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="fa-solid fa-trash me-2"></i>Sil
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                @if(request('search'))
                                    Arama kriterlerinize uygun hasta bulunamadı.
                                @else
                                    Henüz kayıtlı hasta bulunmamaktadır.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- 1. HASTA EKLE / DÜZENLE MODALI (SAYFA DEĞİŞMEDEN) -->
<!-- ========================================== -->
<div class="modal fade" id="patientModal" tabindex="-1" aria-labelledby="patientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="patientModalLabel"><i class="fa-solid fa-user-plus me-2"></i>Yeni Hasta Kaydı</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Kapat"></button>
            </div>
            <form id="patientForm" method="POST" action="{{ route('patients.store') }}">
                @csrf
                <input type="hidden" name="_method" id="patientFormMethod" value="POST">
                <input type="hidden" id="patientId" name="id">

                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">T.C. Kimlik No <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="national_id" id="national_id" maxlength="11" placeholder="11 haneli T.C. No" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Telefon</label>
                            <input type="text" class="form-control" name="phone" id="phone" placeholder="05XXXXXXXXX">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Ad <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="first_name" id="first_name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Soyad <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="last_name" id="last_name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Doğum Tarihi <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="birth_date" id="birth_date" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Cinsiyet <span class="text-danger">*</span></label>
                            <select class="form-select" name="gender" id="gender" required>
                                <option value="male">Erkek</option>
                                <option value="female">Kadın</option>
                                <option value="other">Diğer</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Kan Grubu</label>
                            <select class="form-select" name="blood_type" id="blood_type">
                                <option value="">Seçiniz</option>
                                <option value="A Rh+">A Rh+</option>
                                <option value="A Rh-">A Rh-</option>
                                <option value="B Rh+">B Rh+</option>
                                <option value="B Rh-">B Rh-</option>
                                <option value="AB Rh+">AB Rh+</option>
                                <option value="AB Rh-">AB Rh-</option>
                                <option value="0 Rh+">0 Rh+</option>
                                <option value="0 Rh-">0 Rh-</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Alerjiler</label>
                            <input type="text" class="form-control" name="allergies" id="allergies" placeholder="Örn: Penisilin, Parasetamol vb.">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Adres</label>
                            <textarea class="form-control" name="address" id="address" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary px-4" id="patientSubmitBtn">Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- 2. HASTA KARTI DETAY MODALI (SAYFA DEĞİŞMEDEN) -->
<!-- ========================================== -->
<div class="modal fade" id="patientCardModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fw-bold" id="cardModalTitle"><i class="fa-solid fa-id-card me-2 text-info"></i>Hasta Kartı Detayı</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="d-flex align-items-center mb-4 p-3 bg-light rounded-3">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3 fw-bold fs-3" style="width: 60px; height: 60px;" id="cardAvatar">
                        H
                    </div>
                    <div>
                        <h4 class="mb-1 fw-bold text-dark" id="cardFullName">Hasta Adı</h4>
                        <div class="text-muted small">
                            <span class="me-3"><i class="fa-solid fa-fingerprint me-1 text-primary"></i>T.C: <strong id="cardNationalId">12345678901</strong></span>
                            <span><i class="fa-solid fa-phone me-1 text-success"></i><span id="cardPhone">0555...</span></span>
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="border rounded p-3 text-center bg-white shadow-sm">
                            <div class="text-muted small">Doğum Tarihi / Cinsiyet</div>
                            <div class="fw-bold fs-6 mt-1" id="cardBirthGender">-</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded p-3 text-center bg-white shadow-sm">
                            <div class="text-muted small">Kan Grubu</div>
                            <div class="fw-bold fs-6 text-danger mt-1" id="cardBloodType">-</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded p-3 text-center bg-white shadow-sm">
                            <div class="text-muted small">Alerji Durumu</div>
                            <div class="fw-bold fs-6 text-warning mt-1" id="cardAllergies">Yok</div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="border rounded p-3 bg-white shadow-sm">
                            <div class="text-muted small mb-1">Kayıtlı Adres</div>
                            <div class="fw-semibold text-dark" id="cardAddress">-</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light border-0">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Kapat</button>
            </div>
        </div>
    </div>
</div>

<script>
    function openCreatePatientModal() {
        document.getElementById('patientModalLabel').innerHTML = '<i class="fa-solid fa-user-plus me-2"></i>Yeni Hasta Kaydı';
        document.getElementById('patientForm').action = "{{ route('patients.store') }}";
        document.getElementById('patientFormMethod').value = "POST";
        document.getElementById('patientForm').reset();
        document.getElementById('patientId').value = "";
    }

    function editPatient(id) {
        fetch('/patients/' + id + '/edit', {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const p = data.patient;
                document.getElementById('patientModalLabel').innerHTML = '<i class="fa-solid fa-user-pen me-2"></i>Hasta Bilgilerini Düzenle';
                document.getElementById('patientForm').action = '/patients/' + id;
                document.getElementById('patientFormMethod').value = "PUT";
                document.getElementById('patientId').value = p.id;

                document.getElementById('national_id').value = p.national_id;
                document.getElementById('phone').value = p.phone || '';
                document.getElementById('first_name').value = p.first_name;
                document.getElementById('last_name').value = p.last_name;
                document.getElementById('birth_date').value = p.birth_date ? p.birth_date.split('T')[0] : '';
                document.getElementById('gender').value = p.gender;
                document.getElementById('blood_type').value = p.blood_type || '';
                document.getElementById('allergies').value = p.allergies || '';
                document.getElementById('address').value = p.address || '';

                const modal = new bootstrap.Modal(document.getElementById('patientModal'));
                modal.show();
            }
        });
    }

    function showPatientCard(id) {
        fetch('/patients/' + id, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const p = data.patient;
                document.getElementById('cardFullName').innerText = p.first_name + ' ' + p.last_name;
                document.getElementById('cardAvatar').innerText = p.first_name.charAt(0).toUpperCase();
                document.getElementById('cardNationalId').innerText = p.national_id;
                document.getElementById('cardPhone').innerText = p.phone || '-';
                document.getElementById('cardBirthGender').innerText = (p.birth_date ? p.birth_date.split('T')[0] : '-') + ' / ' + (p.gender === 'male' ? 'Erkek' : 'Kadın');
                document.getElementById('cardBloodType').innerText = p.blood_type || 'Belirtilmedi';
                document.getElementById('cardAllergies').innerText = p.allergies || 'Bilinen alerji yok';
                document.getElementById('cardAddress').innerText = p.address || 'Adres bilgisi girilmedi';

                const modal = new bootstrap.Modal(document.getElementById('patientCardModal'));
                modal.show();
            }
        });
    }
</script>
@endsection
