@extends('layouts.app')

@section('title', 'Klinik Bildirim & Karar Destek Portalı')

@push('styles')
<style>
    body { background-color: #f8fafc; color: #1e293b; }
    
    .card-clean {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04), 0 1px 2px rgba(15, 23, 42, 0.02);
        transition: all 0.2s ease;
    }

    .severity-critical { border-left: 5px solid #dc3545; background-color: #fff5f5; }
    .severity-high_risk { border-left: 5px solid #fd7e14; background-color: #fff9f5; }
    .severity-warning { border-left: 5px solid #ffc107; background-color: #fffdf5; }
    .severity-reminder { border-left: 5px solid #0dcaf0; background-color: #f5fcff; }
    .severity-info { border-left: 5px solid #0d6efd; background-color: #f5f8ff; }
    
    .filter-btn.active { background-color: #1e293b !important; color: white !important; }

    .bg-indigo-soft { background-color: #eef2ff; color: #4338ca; border: 1px solid #c7d2fe; }
    .bg-emerald-soft { background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
    .bg-amber-soft { background-color: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
    .bg-rose-soft { background-color: #fff1f2; color: #be123c; border: 1px solid #fecdd3; }
    .bg-slate-soft { background-color: #f1f5f9; color: #334155; border: 1px solid #cbd5e1; }
</style>
@endpush

@section('content')

    <!-- 1. ÜST SAYFA BAŞLIĞI -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h3 class="fw-bold mb-1 d-flex align-items-center gap-2 text-dark">
                <i class="bi bi-bell-fill text-warning"></i> Bildirim & Klinik Karar Destek Portalı
            </h3>
            <p class="text-muted mb-0 small">Giriş yapan kullanıcı rolüne ve ilgili hastalarına özel filtrelenmiş canlı uyarı ve bildirim akışı</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            @if(auth()->check() && auth()->user()->role === 'pharmacist')
                <span class="badge bg-emerald-soft px-3 py-2 fs-6 rounded-pill">
                    <i class="bi bi-boxes me-1"></i> Eczane İlaç Stok Bildirim Modu
                </span>
            @elseif(auth()->check() && auth()->user()->role === 'physician')
                <span class="badge bg-indigo-soft px-3 py-2 fs-6 rounded-pill">
                    <i class="bi bi-user-doctor me-1"></i> Doktor & Hastaya Özel Klinik Uarı Modu
                </span>
            @elseif(auth()->check() && auth()->user()->role === 'nurse')
                <span class="badge bg-amber-soft px-3 py-2 fs-6 rounded-pill">
                    <i class="bi bi-user-nurse me-1"></i> Hemşirelik & Servis Bakım Uyarısı Modu
                </span>
            @else
                <span class="badge bg-slate-soft px-3 py-2 fs-6 rounded-pill">
                    <i class="bi bi-hospital me-1"></i> Genel Klinik Bildirim Modu
                </span>
            @endif
        </div>
    </div>

    <!-- 2. ÖZET İSTATİSTİK KARTLARI -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card-clean p-3 d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold">Okunmamış / Toplam Bildirim</div>
                    <div class="fs-4 fw-bold text-dark">
                        <span id="stat-unread-count" class="text-primary">{{ $stats['unread'] ?? 0 }}</span> / <span id="stat-total-count">{{ $stats['total'] ?? count($alerts) }}</span>
                    </div>
                </div>
                <div class="p-3 bg-indigo-soft rounded-circle">
                    <i class="bi bi-bell fs-4"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-clean p-3 d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold">Kritik Seviye</div>
                    <div class="fs-4 fw-bold text-danger" id="stat-critical-count">{{ $stats['critical'] ?? 0 }}</div>
                </div>
                <div class="p-3 bg-rose-soft rounded-circle">
                    <i class="bi bi-exclamation-triangle-fill fs-4"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-clean p-3 d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold">Yüksek Risk / SKT</div>
                    <div class="fs-4 fw-bold text-warning" id="stat-high-risk-count">{{ $stats['high_risk'] ?? 0 }}</div>
                </div>
                <div class="p-3 bg-amber-soft rounded-circle">
                    <i class="bi bi-shield-exclamation fs-4"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-clean p-3 d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold">Hatırlatmalar</div>
                    <div class="fs-4 fw-bold text-info" id="stat-reminder-count">{{ $stats['reminder'] ?? 0 }}</div>
                </div>
                <div class="p-3 bg-slate-soft rounded-circle">
                    <i class="bi bi-info-circle-fill fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. ANA İÇERİK (SOL: BİLDİRİM LİSTESİ & FİLTRELER, SAĞ: BİLDİRİM DETAY & UYARI DETAYLARI) -->
    <div class="row g-4">
        <!-- Sol Kolon: Bildirim Akışı ve Filtreler -->
        <div class="col-lg-8 mb-4">
            <div class="card-clean p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-list-stars me-2 text-warning"></i>Role Özel Aktif Bildirim Akışı
                    </h5>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" onclick="submitAllMarkRead()" class="btn btn-sm btn-outline-primary rounded-pill px-3 shadow-none fw-semibold">
                            <i class="bi bi-check2-all me-1"></i> Tümünü Okundu İşaretle
                        </button>
                        <span class="badge bg-slate-soft">Otomatik Güncel</span>
                    </div>
                </div>

                <!-- Önem Seviyesi Filtreleme Butonları -->
                <div class="d-flex gap-1 flex-wrap mb-4" id="severity-filter-bar">
                    <button class="btn btn-sm btn-outline-dark filter-btn active" onclick="filterAlerts('all', this)">Tümü ({{ count($alerts) }})</button>
                    <button class="btn btn-sm btn-outline-danger filter-btn" onclick="filterAlerts('critical', this)">🚨 Kritik ({{ $stats['critical'] ?? 0 }})</button>
                    <button class="btn btn-sm btn-outline-warning text-dark filter-btn" onclick="filterAlerts('high_risk', this)">⚠️ Yüksek Risk / SKT ({{ $stats['high_risk'] ?? 0 }})</button>
                    <button class="btn btn-sm btn-outline-secondary filter-btn" onclick="filterAlerts('warning', this)">⚡ Dikkat ({{ $stats['warning'] ?? 0 }})</button>
                    <button class="btn btn-sm btn-outline-info text-dark filter-btn" onclick="filterAlerts('reminder', this)">🔔 Hatırlatma ({{ $stats['reminder'] ?? 0 }})</button>
                </div>

                <div id="alerts-list">
                    @forelse($alerts as $alert)
                        <div class="card p-3 mb-3 severity-{{ $alert['severity'] }} alert-card-item rounded-3 border-0 shadow-sm {{ empty($alert['is_read']) ? 'border-2 border-primary' : 'opacity-75' }}" data-severity="{{ $alert['severity'] }}" data-alert-id="{{ $alert['id'] }}">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h6 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                                    {{ $alert['title'] }}
                                    @if(empty($alert['is_read']))
                                        <span class="badge bg-danger p-1 rounded-circle alert-unread-dot" style="width:8px; height:8px;" title="Okunmadı"></span>
                                    @endif
                                </h6>
                                <small class="text-muted"><i class="bi bi-clock me-1"></i>{{ $alert['created_at'] }}</small>
                            </div>
                            <p class="small text-dark mb-2">{{ $alert['message'] }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-2">
                                    @if($alert['severity'] === 'critical')
                                        <span class="badge bg-danger">Kritik Seviye</span>
                                    @elseif($alert['severity'] === 'high_risk')
                                        <span class="badge bg-warning text-dark">Yüksek Risk Seviyesi</span>
                                    @elseif($alert['severity'] === 'warning')
                                        <span class="badge bg-warning text-dark">Dikkat Seviyesi</span>
                                    @elseif($alert['severity'] === 'reminder')
                                        <span class="badge bg-info text-dark">Hatırlatma Seviyesi</span>
                                    @else
                                        <span class="badge bg-primary">Bilgi Seviyesi</span>
                                    @endif

                                    @if(empty($alert['is_read']))
                                        <button type="button" class="btn btn-link btn-sm text-decoration-none p-0 small text-primary alert-mark-btn" onclick="markSingleRead('{{ $alert['id'] }}', this)">
                                            <i class="bi bi-check-circle"></i> Okundu Yap
                                        </button>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary small alert-read-badge"><i class="bi bi-check2-all"></i> Okundu</span>
                                    @endif
                                </div>
                                <span class="text-muted small font-monospace"><i class="bi bi-person me-1"></i>{{ $alert['patient_name'] ?? 'Sistem' }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-check-circle-fill fs-1 text-success opacity-75"></i>
                            <h6 class="mt-2 fw-semibold text-dark">Aktif Bildirim Bulunmuyor</h6>
                            <p class="small mb-0">Role özel takibinizde şu an müdahale gerektiren aktif bir klinik veya stok uyarısı bulunmamaktadır.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sağ Kolon: Rol Bilgilendirme ve Karar Destek Rehberi -->
        <div class="col-lg-4 mb-4">
            <div class="card-clean p-4 mb-4">
                <h5 class="fw-bold mb-3 text-dark">
                    <i class="bi bi-info-circle me-2 text-primary"></i>Kullanıcı Yetki & Kapsam Bilgisi
                </h5>
                <div class="p-3 rounded-3 mb-3 bg-light border">
                    <div class="fw-bold text-dark mb-1">{{ auth()->user()->name ?? 'Kullanıcı' }}</div>
                    <div class="small text-muted mb-2">Rol: <span class="fw-semibold text-primary">{{ auth()->user()->role_label ?? 'Kullanıcı' }}</span></div>
                    <p class="small text-secondary mb-0">
                        @if(auth()->check() && auth()->user()->role === 'nurse')
                            Hemşirelik portalınızda sadece sorumlu olduğunuz klinik servisteki yatan hastaların vitals, serum/ilaç zamanı ve bakım uyarıları listelenmektedir.
                        @elseif(auth()->check() && auth()->user()->role === 'physician')
                            Doktor portalınızda sadece kendi takibinizdeki hastaların kritik laboratuvar sonuçları, alerji ilaç uyarıları ve kontrol tarihi hatırlatmaları görüntülenir.
                        @elseif(auth()->check() && auth()->user()->role === 'pharmacist')
                            Eczane portalınızda kritik ilaç stokları, son kullanma tarihi yaklaşan ürünler ve İTS karekod bildirimleri filtrelenmektedir.
                        @else
                            Sisteminizde tüm aktif klinik karar destek ve servis bildirimleri gösterilmektedir.
                        @endif
                    </p>
                </div>
            </div>

            <div class="card-clean p-4">
                <h6 class="fw-bold mb-3 text-dark">
                    <i class="bi bi-shield-check me-2 text-success"></i>Bildirim İpuçları
                </h6>
                <ul class="list-unstyled small text-muted mb-0">
                    <li class="mb-2 d-flex align-items-start gap-2">
                        <i class="bi bi-dot fs-5 text-danger leading-none"></i>
                        <span><strong>Kritik Uyarılar:</strong> Acil klinik müdahale veya ilaç değişimi gerektirir.</span>
                    </li>
                    <li class="mb-2 d-flex align-items-start gap-2">
                        <i class="bi bi-dot fs-5 text-warning leading-none"></i>
                        <span><strong>Yüksek Risk:</strong> Alerji, SKT veya kontrendikasyon durumlarını gösterir.</span>
                    </li>
                    <li class="d-flex align-items-start gap-2">
                        <i class="bi bi-dot fs-5 text-info leading-none"></i>
                        <span><strong>Hatırlatmalar:</strong> İlaç saati, kontrol randevusu ve genel takip uyarılarıdır.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    function filterAlerts(severity, btn) {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        document.querySelectorAll('.alert-card-item').forEach(item => {
            if (severity === 'all' || item.getAttribute('data-severity') === severity) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    function updatePageStats(stats, unreadCount) {
        if (typeof unreadCount !== 'undefined') {
            const statUnread = document.getElementById('stat-unread-count');
            if (statUnread) statUnread.textContent = unreadCount;

            if (window.updateNotificationBadgeCount) {
                window.updateNotificationBadgeCount(unreadCount);
            }
        }

        if (stats) {
            if (document.getElementById('stat-total-count')) document.getElementById('stat-total-count').textContent = stats.total ?? 0;
            if (document.getElementById('stat-critical-count')) document.getElementById('stat-critical-count').textContent = stats.critical ?? 0;
            if (document.getElementById('stat-high-risk-count')) document.getElementById('stat-high-risk-count').textContent = stats.high_risk ?? 0;
            if (document.getElementById('stat-warning-count')) document.getElementById('stat-warning-count').textContent = stats.warning ?? 0;
            if (document.getElementById('stat-reminder-count')) document.getElementById('stat-reminder-count').textContent = stats.reminder ?? 0;
        }
    }

    function markSingleRead(id, btnElement) {
        fetch("{{ url('/notifications/mark-read') }}/" + id, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                const card = btnElement.closest('.alert-card-item');
                if (card) {
                    card.classList.add('opacity-75');
                    card.classList.remove('border-2', 'border-primary');
                    const redDot = card.querySelector('.alert-unread-dot');
                    if (redDot) redDot.remove();
                }
                btnElement.outerHTML = '<span class="badge bg-secondary-subtle text-secondary small alert-read-badge"><i class="bi bi-check2-all"></i> Okundu</span>';
                
                updatePageStats(data.stats, data.unread_count);

                // Navbar dropdown item sync
                const navItem = document.querySelector('.nav-alert-item-' + id);
                if (navItem) {
                    navItem.classList.remove('bg-light', 'font-weight-bold');
                    navItem.classList.add('bg-white', 'text-muted', 'opacity-75');
                    const navDot = navItem.querySelector('.nav-unread-dot');
                    if (navDot) navDot.remove();
                    const navBtn = navItem.querySelector('button');
                    if (navBtn) navBtn.remove();
                }

                if (typeof Swal !== 'undefined') {
                    const toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    toast.fire({
                        icon: 'success',
                        title: 'Bildirim okundu olarak işaretlendi'
                    });
                }
            }
        })
        .catch(err => console.error(err));
    }

    function submitAllMarkRead() {
        fetch("{{ route('notifications.mark_all_read') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                document.querySelectorAll('.alert-card-item').forEach(card => {
                    card.classList.add('opacity-75');
                    card.classList.remove('border-2', 'border-primary');
                    const redDot = card.querySelector('.alert-unread-dot');
                    if (redDot) redDot.remove();
                    const btn = card.querySelector('.alert-mark-btn');
                    if (btn) {
                        btn.outerHTML = '<span class="badge bg-secondary-subtle text-secondary small alert-read-badge"><i class="bi bi-check2-all"></i> Okundu</span>';
                    }
                });

                updatePageStats(data.stats, data.unread_count);

                if (typeof window.markAllNavNotificationsRead === 'function') {
                    window.markAllNavNotificationsRead();
                }

                if (typeof Swal !== 'undefined') {
                    const toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    toast.fire({
                        icon: 'success',
                        title: 'Tüm bildirimler okundu olarak işaretlendi'
                    });
                }
            }
        })
        .catch(err => console.error(err));
    }
</script>
@endpush
