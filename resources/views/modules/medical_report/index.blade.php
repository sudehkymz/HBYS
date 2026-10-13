@extends('layouts.app')

@section('title', 'Tıbbi Rapor ve e-Rapor Yönetimi')

@push('styles')
<style>
    .header-bg { background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%); color: white; padding: 1.5rem; border-radius: 12px; border-bottom: 4px solid #3b82f6; }
    .card-custom { border: none; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
</style>
@endpush

@section('content')

    <header class="header-bg mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="fw-bold mb-1"><i class="bi bi-file-earmark-medical-fill me-2"></i>Tıbbi Rapor & e-Rapor Oluşturma Modülü</h3>
                <p class="mb-0 text-light opacity-75">İstirahat, İlaç Kullanım, Heyet & İş Göremezlik Raporları Oluşturma Portalı</p>
            </div>
            <div>
                @if(auth()->check() && auth()->user()->role === 'physician')
                <a href="{{ route('medical_report.chief_physician') }}" class="btn btn-outline-light btn-sm me-2">
                    <i class="bi bi-person-workspace me-1"></i> Doktor Paneli
                </a>
                @endif
                <a href="{{ route('ai.index') }}" class="btn btn-primary btn-sm fw-bold">
                    <i class="bi bi-cpu-fill me-1"></i> AI Asistan
                </a>
            </div>
        </div>
    </header>

    <div class="row">
        <!-- 1. Tıbbi Rapor Oluşturma Formu -->
        <div class="col-lg-6 mb-4">
            <div class="card card-custom p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0"><i class="bi bi-pencil-square me-2 text-primary"></i>Yeni Tıbbi Rapor Düzenle</h5>
                    <button type="button" class="btn btn-outline-indigo btn-sm fw-semibold" onclick="autoFillWithAi()">
                        <i class="bi bi-magic me-1"></i> AI İle Doldur
                    </button>
                </div>

                <form action="{{ route('medical_report.store') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Hasta ID</label>
                            <input type="number" id="patient_id" name="patient_id" class="form-control form-control-sm" value="1" required>
                            <small class="text-muted" style="font-size:0.75rem;">Hasta: Ahmet Yılmaz</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Rapor Türü</label>
                            <select id="report_type" name="report_type" class="form-select form-select-sm" required>
                                <option value="Ayaktan İstirahat Raporu">Ayaktan İstirahat Raporu</option>
                                <option value="SGK İlaç Kullanım Raporu">SGK İlaç Kullanım Raporu</option>
                                <option value="Durum Bildirir Sağlık Kurulu Raporu">Durum Bildirir Sağlık Kurulu Raporu</option>
                                <option value="Geçici İş Göremezlik Raporu">Geçici İş Göremezlik Raporu</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-8 position-relative">
                            <label class="form-label small fw-semibold">Tanı (ICD-10 Kodu & Arama)</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search text-success"></i></span>
                                <input type="text" id="diagnosis" name="diagnosis" class="form-control form-control-sm border-start-0 ps-0 fw-semibold" value="I10 - Essansiyel Hipertansiyon" placeholder="Kod veya hastalık adı yazarak canlı arayın..." autocomplete="off" required>
                            </div>
                            <div id="diagnosis_autocomplete_list" class="dropdown-menu shadow-lg border rounded-3 w-100 p-0 overflow-hidden mt-1" style="display:none; max-height:280px; overflow-y:auto; position:absolute; z-index:1060; top:100%; left:0;"></div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">İstirahat Süresi (Gün)</label>
                            <input type="number" id="rest_days" name="rest_days" class="form-control form-control-sm" value="5" min="1" max="30" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Rapor Klinik İçeriği & Hekim Açıklaması</label>
                        <textarea id="report_content" name="report_content" class="form-control form-control-sm" rows="4" required>Hastanın poliklinik muayenesinde istirahat ve ilaç takibi uygun görülmüştür.</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-semibold">
                        <i class="bi bi-file-earmark-check me-1"></i> Raporu Oluştur ve Doktor Onayına Gönder
                    </button>
                </form>
            </div>
        </div>

        <!-- 2. Oluşturulan Raporlar Listesi -->
        <div class="col-lg-6 mb-4">
            <div class="card card-custom p-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-folder2-open me-2 text-primary"></i>Oluşturulan Tıbbi Raporlar</h5>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Rapor No</th>
                                <th>Tür / Tanı</th>
                                <th>Onay Durumu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports as $r)
                            <tr>
                                <td>
                                    <div class="fw-bold text-dark">{{ $r->report_number }}</div>
                                    <small class="text-muted">{{ $r->created_at->format('d.m.Y H:i') }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $r->report_type }}</span>
                                    <div class="small fw-semibold mt-1">{{ $r->diagnosis }}</div>
                                    <span class="badge bg-info text-dark mt-1">{{ $r->rest_days }} Gün İstirahat</span>
                                </td>
                                <td>
                                    @if($r->chief_physician_approval_status === 'approved')
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Doktor Onaylı</span>
                                        <div class="small text-success font-monospace fw-bold mt-1" style="font-size:0.75rem;">{{ $r->e_rapor_no }}</div>
                                    @elseif($r->chief_physician_approval_status === 'rejected')
                                        <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i> Reddedildi</span>
                                    @else
                                        <span class="badge bg-warning text-dark"><i class="bi bi-clock me-1"></i> Onay Bekliyor</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">Henüz oluşturulmuş tıbbi rapor bulunmuyor.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    function autoFillWithAi() {
        const reportType = document.getElementById('report_type').value;

        fetch("{{ route('medical_report.ai_autofill') }}", {
            method: "POST",
            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
            body: JSON.stringify({ patient_id: 1, report_type: reportType })
        })
        .then(res => res.json())
        .then(data => {
            if(data.diagnosis) document.getElementById('diagnosis').value = data.diagnosis;
            if(data.rest_days) document.getElementById('rest_days').value = data.rest_days;
            if(data.report_content) document.getElementById('report_content').value = data.report_content;
            
            Swal.fire({
                icon: 'success',
                title: 'AI Taslağı Dolduruldu',
                text: 'Klinik protokol ve geçmiş muayene verilerine göre rapor otomatik oluşturuldu.',
                timer: 2000,
                showConfirmButton: false
            });
        });
    }

    let allIcd10CodesCache = [];

    function initIcd10LiveSearch(inputId, containerId) {
        const inputEl = document.getElementById(inputId);
        const containerEl = document.getElementById(containerId);
        if (!inputEl || !containerEl) return;

        let activeIndex = -1;

        function trNormalize(str) {
            if (!str) return '';
            return str
                .replace(/İ/g, 'i')
                .replace(/I/g, 'ı')
                .replace(/Ğ/g, 'ğ')
                .replace(/Ü/g, 'ü')
                .replace(/Ş/g, 'ş')
                .replace(/Ö/g, 'ö')
                .replace(/Ç/g, 'ç')
                .toLowerCase()
                .trim();
        }

        function fetchCatalogIfNeeded(callback) {
            if (allIcd10CodesCache && allIcd10CodesCache.length > 0) {
                if (callback) callback();
                return;
            }
            fetch("{{ route('medical_report.icd10_search') }}")
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success' && data.data) {
                        allIcd10CodesCache = data.data;
                    }
                    if (callback) callback();
                })
                .catch(err => console.error("ICD-10 search error:", err));
        }

        function renderResults(query) {
            const normQuery = trNormalize(query);
            if (!normQuery || normQuery.length < 1) {
                containerEl.style.display = 'none';
                containerEl.innerHTML = '';
                return;
            }

            const matches = (allIcd10CodesCache || []).filter(item => {
                const codeNorm = trNormalize(item.code);
                const descNorm = trNormalize(item.description);
                return codeNorm.includes(normQuery) || descNorm.includes(normQuery);
            }).slice(0, 15);

            if (matches.length === 0) {
                containerEl.innerHTML = `
                    <div class="p-3 text-center text-muted small">
                        <i class="bi bi-search text-warning fs-5 d-block mb-1"></i>
                        "<strong>${query}</strong>" için ICD-10 tanı kodu bulunamadı.
                    </div>`;
                containerEl.style.display = 'block';
                return;
            }

            let html = '<div class="list-group list-group-flush small" style="font-size:0.82rem;">';
            matches.forEach((item, idx) => {
                const fullText = `${item.code} - ${item.description}`;
                html += `
                    <button type="button" class="list-group-item list-group-item-action py-2 px-3 border-bottom d-flex align-items-center justify-content-between icd-auto-item text-start" data-fulltext="${fullText.replace(/"/g, '&quot;')}" data-code="${item.code}" data-index="${idx}">
                        <div>
                            <span class="badge bg-success-subtle text-success font-monospace fw-bold me-2 px-2 py-1 border border-success-subtle" style="font-size:0.75rem;">${item.code}</span>
                            <strong class="text-dark">${item.description}</strong>
                        </div>
                        <span class="badge bg-light text-muted border ms-2 py-1 px-2" style="font-size:0.68rem;"><i class="bi bi-check2 me-0.5"></i>Seç</span>
                    </button>`;
            });
            html += '</div>';
            containerEl.innerHTML = html;
            containerEl.style.display = 'block';
            activeIndex = -1;

            containerEl.querySelectorAll('.icd-auto-item').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    selectItem(this.getAttribute('data-fulltext'));
                });
            });
        }

        function selectItem(fullText) {
            inputEl.value = fullText;
            containerEl.style.display = 'none';

            inputEl.classList.add('is-valid');
            setTimeout(() => inputEl.classList.remove('is-valid'), 1500);
        }

        inputEl.addEventListener('focus', function() {
            fetchCatalogIfNeeded(() => {
                if (inputEl.value.trim().length >= 1) {
                    renderResults(inputEl.value);
                }
            });
        });

        inputEl.addEventListener('input', function() {
            fetchCatalogIfNeeded(() => {
                renderResults(inputEl.value);
            });
        });

        inputEl.addEventListener('keydown', function(e) {
            const items = containerEl.querySelectorAll('.icd-auto-item');
            if (!items || items.length === 0 || containerEl.style.display === 'none') return;

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                activeIndex = (activeIndex + 1) % items.length;
                updateHighlight(items);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                activeIndex = (activeIndex - 1 + items.length) % items.length;
                updateHighlight(items);
            } else if (e.key === 'Enter' && activeIndex >= 0) {
                e.preventDefault();
                items[activeIndex].click();
            } else if (e.key === 'Escape') {
                containerEl.style.display = 'none';
            }
        });

        function updateHighlight(items) {
            items.forEach((item, idx) => {
                if (idx === activeIndex) {
                    item.classList.add('active', 'bg-success-subtle', 'text-dark');
                    item.scrollIntoView({ block: 'nearest' });
                } else {
                    item.classList.remove('active', 'bg-success-subtle', 'text-dark');
                }
            });
        }

        document.addEventListener('click', function(e) {
            if (!inputEl.contains(e.target) && !containerEl.contains(e.target)) {
                containerEl.style.display = 'none';
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        initIcd10LiveSearch('diagnosis', 'diagnosis_autocomplete_list');
    });
</script>
@endpush
