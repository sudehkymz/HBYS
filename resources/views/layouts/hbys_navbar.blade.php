<!-- Entegre HBYS Ortak Navigasyon Menüsü -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm border-bottom border-primary sticky-top">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ (auth()->check() && auth()->user()->role === 'pharmacist') ? route('pharmacy.index') : route('medical_report.chief_physician') }}">
            <i class="bi bi-hospital-fill text-primary me-2 fs-4"></i>
            <span>HBYS <span class="badge bg-primary text-white ms-1" style="font-size:0.65rem;">Klinik Portal</span></span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#hbysNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="hbysNavbar">
            <!-- Modül Navigasyon Linkleri -->
                <!-- Çocuk Sağlığı & Poliklinikler Top Navbar Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('pediatrics.*') ? 'active text-indigo fw-bold' : '' }}" href="#" id="pediatricsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-hearts text-info me-1"></i> Çocuk Sağlığı & Poliklinikler
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark shadow-lg border-primary" aria-labelledby="pediatricsDropdown" style="max-height: 480px; overflow-y: auto;">
                        <li><h6 class="dropdown-header text-primary fw-bold"><i class="bi bi-hospital me-1"></i>Çocuk Poliklinikleri & Yan Dallar</h6></li>
                        <li><a class="dropdown-item small" href="{{ route('pediatrics.index') }}"><i class="bi bi-child me-2 text-info"></i>Çocuk Sağlığı (Ana Branş)</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item small" href="{{ route('pediatrics.neonatology') }}"><i class="bi bi-egg-freq me-2 text-info"></i>Neonatoloji (Yenidoğan)</a></li>
                        <li><a class="dropdown-item small" href="{{ route('pediatrics.neurology') }}"><i class="bi bi-activity me-2 text-info"></i>Çocuk Nörolojisi</a></li>
                        <li><a class="dropdown-item small" href="{{ route('pediatrics.developmental') }}"><i class="bi bi-emoji-smile me-2 text-info"></i>Gelişimsel Pediatri</a></li>
                        <li><a class="dropdown-item small" href="{{ route('pediatrics.hematology_oncology') }}"><i class="bi bi-droplet-fill me-2 text-danger"></i>Çocuk Hematolojisi & Onkoloji</a></li>
                        <li><a class="dropdown-item small" href="{{ route('pediatrics.endocrinology') }}"><i class="bi bi-dna me-2 text-info"></i>Çocuk Endokrinolojisi</a></li>
                        <li><a class="dropdown-item small" href="{{ route('pediatrics.metabolism') }}"><i class="bi bi-funnel me-2 text-info"></i>Çocuk Metabolizma Hast.</a></li>
                        <li><a class="dropdown-item small" href="{{ route('pediatrics.pulmonology') }}"><i class="bi bi-lungs me-2 text-info"></i>Çocuk Göğüs Hastalıkları</a></li>
                        <li><a class="dropdown-item small" href="{{ route('pediatrics.allergy_immunology') }}"><i class="bi bi-flower1 me-2 text-info"></i>Çocuk İmmünolojisi & Alerji</a></li>
                        <li><a class="dropdown-item small" href="{{ route('pediatrics.cardiology') }}"><i class="bi bi-heart-pulse me-2 text-danger"></i>Çocuk Kardiyolojisi</a></li>
                        <li><a class="dropdown-item small" href="{{ route('pediatrics.gastroenterology') }}"><i class="bi bi-prescription me-2 text-info"></i>Çocuk Gastroenterolojisi</a></li>
                        <li><a class="dropdown-item small" href="{{ route('pediatrics.nephrology') }}"><i class="bi bi-water me-2 text-info"></i>Çocuk Nefrolojisi</a></li>
                        <li><a class="dropdown-item small" href="{{ route('pediatrics.rheumatology') }}"><i class="bi bi-bounding-box-circles me-2 text-info"></i>Çocuk Romatolojisi</a></li>
                        <li><a class="dropdown-item small" href="{{ route('pediatrics.infectious') }}"><i class="bi bi-shield-x me-2 text-info"></i>Çocuk Enfeksiyon Hast.</a></li>
                        <li><a class="dropdown-item small" href="{{ route('pediatrics.genetics') }}"><i class="bi bi-diagram-2 me-2 text-info"></i>Çocuk Genetik Hastalıkları</a></li>
                        <li><a class="dropdown-item small" href="{{ route('pediatrics.surgery') }}"><i class="bi bi-scissors me-2 text-info"></i>Çocuk Cerrahisi</a></li>
                        <li><a class="dropdown-item small" href="{{ route('pediatrics.cardiovascular_surgery') }}"><i class="bi bi-heartbreak me-2 text-danger"></i>Çocuk KDC (Kalp Damar)</a></li>
                        <li><a class="dropdown-item small" href="{{ route('pediatrics.urology') }}"><i class="bi bi-clipboard2-pulse me-2 text-info"></i>Çocuk Ürolojisi</a></li>
                        <li><a class="dropdown-item small" href="{{ route('pediatrics.psychiatry') }}"><i class="bi bi-shield-lock me-2 text-warning"></i>Çocuk Psikiyatrisi (Gizli Protokol)</a></li>
                    </ul>
                </li>
            </ul>

            <!-- Sağ Taraf: Aktif Kullanıcı & Bildirim -->
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('notifications.index') }}" class="position-relative text-light me-2" title="Klinik Bildirimler">
                    <i class="bi bi-bell fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light js-unread-count-badge {{ ($unreadNotificationCount ?? 0) > 0 ? '' : 'd-none' }}" style="font-size:0.65rem; padding: 0.25em 0.5em;">
                        {{ ($unreadNotificationCount ?? 0) > 9 ? '9+' : ($unreadNotificationCount ?? 0) }}
                    </span>
                </a>
                <div class="d-flex align-items-center bg-secondary bg-opacity-25 px-3 py-1 rounded-pill border border-secondary border-opacity-50">
                    <i class="bi bi-person-circle text-primary me-2"></i>
                    <span class="small text-light">
                        {{ auth()->user()->name ?? 'Dr. Mehmet Öz' }} ({{ (auth()->check() && auth()->user()->role === 'pharmacist') ? 'Eczacı' : ((auth()->check() && auth()->user()->role === 'admin') ? 'Yönetici' : 'Kardiyoloji') }})
                    </span>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Şık Aktif Hasta Bilgi Barı -->
<div class="bg-white border-bottom shadow-sm py-2">
    <div class="container-fluid px-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 small">
            <div class="d-flex align-items-center gap-3">
                <span class="fw-bold text-dark"><i class="bi bi-person-badge text-primary me-1"></i> Muayene Eden Hekim:</span>
                <span class="fw-semibold text-indigo">Dr. Mehmet Öz</span>
                <span class="text-muted">| Kardiyoloji Polikliniği</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-light text-dark border"><i class="bi bi-building me-1"></i> Merkez Hastanesi</span>
                <span class="badge bg-success"><i class="bi bi-shield-check me-1"></i> e-Imza Aktif</span>
            </div>
        </div>
    </div>
</div>
