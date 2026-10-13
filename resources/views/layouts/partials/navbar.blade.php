<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom px-4">
    <div class="container-fluid p-0">
        <span class="navbar-brand fw-bold text-secondary mb-0">
            <i class="fa-solid fa-hospital-user text-primary me-2"></i>Hastane Bilgi Yönetim Sistemi
        </span>
        
        <div class="d-flex align-items-center ms-auto gap-3">
            @php
                $navUser = auth()->user();
                $navAlerts = app(\App\Modules\Notification\Services\NotificationService::class)->getActiveClinicalAlerts(0, $navUser);
            @endphp
            <!-- 🔔 Klinik Bildirimler & Uyarılar Dropdown -->
            <div class="dropdown">
                <a class="nav-link position-relative text-dark p-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" title="Klinik Bildirimler">
                    <i class="fa-solid fa-bell fs-5 text-warning"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light js-unread-count-badge {{ ($unreadNotificationCount ?? 0) > 0 ? '' : 'd-none' }}" style="font-size:0.65rem; padding: 0.25em 0.45em;">
                        {{ ($unreadNotificationCount ?? 0) > 9 ? '9+' : ($unreadNotificationCount ?? 0) }}
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end shadow-lg p-3 border-0" style="width: 380px; max-height: 480px; overflow-y: auto;">
                    <div class="d-flex justify-content-between align-items-center mb-2 border-bottom pb-2">
                        <h6 class="fw-bold mb-0 text-dark">
                            <i class="fa-solid fa-triangle-exclamation text-warning me-1"></i>
                            @if($navUser && $navUser->role === 'pharmacist')
                                Eczane İlaç Stok Uyarıları
                            @elseif($navUser && $navUser->role === 'nurse')
                                Hemşirelik & Servis Uyarıları
                            @else
                                Klinik Uyarılar & Bildirimler
                            @endif
                        </h6>
                        <span class="badge bg-danger js-unread-header-badge">{{ ($unreadNotificationCount ?? 0) }} Okunmamış</span>
                    </div>

                    <div class="list-group list-group-flush small" id="nav-dropdown-alerts-list">
                        @forelse($navAlerts as $alert)
                            <div class="list-group-item list-group-item-action border-0 border-start border-4 {{ $alert['severity'] === 'critical' ? 'border-danger' : ($alert['severity'] === 'high_risk' ? 'border-warning' : 'border-info') }} mb-1 rounded p-2 nav-alert-item-{{ $alert['id'] }} {{ empty($alert['is_read']) ? 'bg-light font-weight-bold' : 'bg-white text-muted opacity-75' }}">
                                <div class="d-flex justify-content-between font-weight-bold text-dark">
                                    <strong class="d-flex align-items-center gap-1">
                                        {{ $alert['title'] }}
                                        @if(empty($alert['is_read']))
                                            <span class="badge bg-danger rounded-circle p-1 nav-unread-dot" style="width:6px; height:6px;"></span>
                                        @endif
                                    </strong>
                                    <small class="text-muted">{{ $alert['created_at'] }}</small>
                                </div>
                                <div class="text-secondary small mt-1">{{ $alert['message'] }}</div>
                                @if(empty($alert['is_read']))
                                    <div class="text-end mt-1">
                                        <button type="button" class="btn btn-link p-0 text-primary small text-decoration-none" style="font-size:0.75rem;" onclick="markNavNotificationRead('{{ $alert['id'] }}', this)">
                                            <i class="fa-solid fa-check me-1"></i>Okundu Yap
                                        </button>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center text-muted py-2 small">Aktif bildirim bulunmuyor.</div>
                        @endforelse
                    </div>

                    <div class="d-flex justify-content-between align-items-center pt-2 border-top mt-2">
                        <button type="button" class="btn btn-link p-0 text-muted small text-decoration-none" style="font-size:0.75rem;" onclick="markAllNavNotificationsRead()">
                            <i class="fa-solid fa-check-double me-1"></i>Tümünü Okundu Yap
                        </button>
                        <a href="{{ route('notifications.index') }}" class="small fw-semibold text-primary text-decoration-none">
                            Tüm Bildirimler &rarr;
                        </a>
                    </div>
                </div>
            </div>

            <!-- Kullanıcı Profili -->
            @auth
            <div class="dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 text-dark fw-semibold"
                   href="#" role="button" data-bs-toggle="dropdown">
                    <span class="d-flex align-items-center justify-content-center rounded-circle bg-primary text-white"
                          style="width:34px;height:34px;font-size:0.85rem;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </span>
                    <div class="d-none d-md-block text-start" style="line-height:1.2;">
                        <div style="font-size:0.875rem;">{{ auth()->user()->name }}</div>
                        <div style="font-size:0.72rem;color:#6b7280;font-weight:400;">{{ auth()->user()->role_label }}</div>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="min-width:180px;border-radius:12px;">
                    <li>
                        <span class="dropdown-item-text text-muted small px-3 py-1">{{ auth()->user()->email }}</span>
                    </li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="fa-solid fa-right-from-bracket me-2"></i>Çıkış Yap
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
            @else
            <div class="dropdown">
                <a class="nav-link dropdown-toggle text-dark fw-semibold" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-user-doctor me-1 text-primary"></i> Dr. Mehmet Öz (Kardiyoloji)
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                    <li><a class="dropdown-item" href="#">Profilim</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="#">Çıkış Yap</a></li>
                </ul>
            </div>
            @endauth
        </div>
    </div>
</nav>