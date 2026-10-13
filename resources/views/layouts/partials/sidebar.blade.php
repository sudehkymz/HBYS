@php
    $routes = Route::getRoutes()->getRoutesByName();
    $user = auth()->user();
@endphp

<div class="sidebar p-3 bg-white border-end" id="sidebar-wrapper" style="width: 280px; min-height: 100vh;">
    <!-- Logo & Header -->
    <div class="d-flex align-items-center mb-4 px-2">
        <i class="fa-solid fa-hospital text-primary me-2 fs-4"></i>
        <span class="fs-5 fw-bold text-dark">HBYS Portal</span>
    </div>

    <!-- Active User Card -->
    <div class="card border-0 bg-light rounded-3 p-2 mb-3">
        @auth
        <div class="d-flex align-items-center gap-2">
            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px; font-size: 0.9rem;">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="overflow-hidden" style="line-height: 1.2;">
                <div class="fw-bold text-truncate text-dark" style="font-size: 0.85rem;">{{ auth()->user()->name }}</div>
                <div class="text-muted text-truncate" style="font-size: 0.72rem;">{{ auth()->user()->role_label }}</div>
            </div>
        </div>
        @else
        <div class="small text-muted text-center">Giriş Yapılmadı</div>
        @endauth
    </div>

    <div class="accordion accordion-flush" id="sidebarAccordion">

        <!-- 1. HASTA & POLİKLİNİK İŞLEMLERİ (Sekreter, Doktor, Hemşire, Admin) -->
        @if(!$user || $user->hasRole(['admin', 'physician', 'chief_physician', 'receptionist', 'nurse']))
        <div class="accordion-item border-0 bg-transparent mb-1">
            <button class="sidebar-category-btn {{ request()->routeIs(['patients.*', 'outpatient.*', 'emergency.*', 'referrals.*', 'appointment.*']) ? '' : 'collapsed' }}" 
                    type="button" data-bs-toggle="collapse" data-bs-target="#collapsePatient" 
                    aria-expanded="{{ request()->routeIs(['patients.*', 'outpatient.*', 'emergency.*', 'referrals.*', 'appointment.*']) ? 'true' : 'false' }}">
                <span><i class="fa-solid fa-user-doctor me-2 text-secondary"></i>Hasta & Poliklinik</span>
                <i class="fa-solid fa-chevron-right arrow-icon"></i>
            </button>

            <div id="collapsePatient" class="accordion-collapse collapse {{ request()->routeIs(['patients.*', 'outpatient.*', 'emergency.*', 'referrals.*', 'appointment.*']) ? 'show' : '' }}" data-bs-parent="#sidebarAccordion">
                <div class="list-group list-group-flush ms-2 ps-2 border-start border-2 border-light mt-1">
                    @if(isset($routes['patients.index']) && (!$user || $user->hasRole(['admin', 'physician', 'chief_physician', 'receptionist', 'nurse'])))
                    <a href="{{ route('patients.index') }}" class="list-group-item list-group-item-action border-0 rounded {{ request()->routeIs('patients.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-id-card me-2"></i>Hasta Ana Kayıt
                    </a>
                    @endif

                    @if(isset($routes['outpatient.index']) && (!$user || $user->hasRole(['admin', 'physician', 'chief_physician'])))
                    <a href="{{ route('outpatient.index') }}" class="list-group-item list-group-item-action border-0 rounded {{ request()->routeIs('outpatient.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-stethoscope me-2"></i>Poliklinik Muayene
                    </a>
                    @endif

                    @if(isset($routes['emergency.index']) && (!$user || $user->hasRole(['admin', 'physician', 'chief_physician', 'nurse', 'receptionist'])))
                    <a href="{{ route('emergency.index') }}" class="list-group-item list-group-item-action border-0 rounded {{ request()->routeIs('emergency.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-truck-medical me-2 text-danger"></i>Acil Servis & Triyaj
                    </a>
                    @endif

                    @if(isset($routes['referrals.index']) && (!$user || $user->hasRole(['admin', 'physician', 'chief_physician', 'receptionist'])))
                    <a href="{{ route('referrals.index') }}" class="list-group-item list-group-item-action border-0 rounded {{ request()->routeIs('referrals.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-arrow-right-arrows-left me-2"></i>Sevk & Transfer
                    </a>
                    @endif

                    @if(isset($routes['appointment.index']) && (!$user || $user->hasRole(['admin', 'physician', 'chief_physician', 'receptionist'])))
                    <a href="{{ route('appointment.index') }}" class="list-group-item list-group-item-action border-0 rounded {{ request()->routeIs('appointment.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-calendar-check me-2"></i>Randevu Takibi
                    </a>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <!-- 2. KLİNİKLER & BRANŞLAR (Doktor, Hemşire, Admin) -->
        @if(!$user || $user->hasRole(['admin', 'physician', 'chief_physician', 'nurse', 'receptionist']))
        <div class="accordion-item border-0 bg-transparent mb-1">
            <button class="sidebar-category-btn {{ request()->routeIs(['pediatrics.*', 'dental.*', 'specialized.*', 'internal_medicine.*', 'family_medicine.*', 'cardiovascular_surgery.*', 'ent.*', 'orthopedics.*', 'plastic_surgery.*', 'urology.*', 'anesthesiology.*']) ? '' : 'collapsed' }}" 
                    type="button" data-bs-toggle="collapse" data-bs-target="#collapseClinicsSub" 
                    aria-expanded="{{ request()->routeIs(['pediatrics.*', 'dental.*', 'specialized.*', 'internal_medicine.*', 'family_medicine.*', 'cardiovascular_surgery.*', 'ent.*', 'orthopedics.*', 'plastic_surgery.*', 'urology.*', 'anesthesiology.*']) ? 'true' : 'false' }}">
                <span><i class="fa-solid fa-hospital me-2 text-primary"></i>Klinikler & Poliklinikler</span>
                <i class="fa-solid fa-chevron-right arrow-icon"></i>
            </button>

            <div id="collapseClinicsSub" class="accordion-collapse collapse {{ request()->routeIs(['pediatrics.*', 'dental.*', 'specialized.*', 'internal_medicine.*', 'family_medicine.*', 'dermatology.*', 'infectious_diseases.*', 'physical_rehab.*', 'pulmonology.*', 'cardiology.*', 'neurology.*', 'psychiatry.*', 'radiation_oncology.*', 'sports_medicine.*', 'aerospace_medicine.*', 'medical_ecology.*', 'general_surgery.*', 'neurosurgery.*', 'thoracic_surgery.*', 'ophthalmology.*', 'obgyn.*', 'dietetics.*', 'cardiovascular_surgery.*', 'ent.*', 'orthopedics.*', 'plastic_surgery.*', 'urology.*', 'anesthesiology.*']) ? 'show' : '' }}" data-bs-parent="#sidebarAccordion">
                <div class="list-group list-group-flush ms-2 ps-2 border-start border-2 border-light mt-1">
                    
                    <!-- 🏠 AİLE HEKİMLİĞİ POLİKLİNİĞİ -->
                    @if(isset($routes['family_medicine.index']))
                    <a href="{{ route('family_medicine.index') }}" class="list-group-item list-group-item-action border-0 rounded mb-1 {{ request()->routeIs('family_medicine.*') ? 'active fw-bold' : '' }}">
                        <i class="fa-solid fa-house-chimney-medical me-2 text-success"></i>Aile Hekimliği
                    </a>
                    @endif

                    <!-- 🧴 DERİ VE ZÜHREVİ HASTALIKLARI (CİLDİYE - ANA DAL) -->
                    @if(isset($routes['dermatology.index']))
                    <a href="{{ route('dermatology.index') }}" class="list-group-item list-group-item-action border-0 rounded mb-1 {{ request()->routeIs('dermatology.*') ? 'active fw-bold' : '' }}">
                        <i class="fa-solid fa-shield-cat me-2" style="color: #db2777;"></i>Deri ve Zührevi Hastalıkları (Cildiye)
                    </a>
                    @endif

                    <!-- 🦠 ENFEKSİYON HASTALIKLARI VE KLİNİK MİKROBİYOLOJİ (ANA DAL) -->
                    @if(isset($routes['infectious_diseases.index']))
                    <a href="{{ route('infectious_diseases.index') }}" class="list-group-item list-group-item-action border-0 rounded mb-1 {{ request()->routeIs('infectious_diseases.*') ? 'active fw-bold' : '' }}">
                        <i class="fa-solid fa-shield-virus me-2 text-danger"></i>Enfeksiyon Hastalıkları & Mikrobiyoloji
                    </a>
                    @endif

                    <!-- ♿ FİZİKSEL TIP VE REHABİLİTASYON (FTR - ANA DAL) -->
                    @if(isset($routes['physical_rehab.index']))
                    <a href="{{ route('physical_rehab.index') }}" class="list-group-item list-group-item-action border-0 rounded mb-1 {{ request()->routeIs('physical_rehab.*') ? 'active fw-bold' : '' }}">
                        <i class="fa-solid fa-person-walking-with-cane me-2 text-success"></i>Fiziksel Tıp ve Rehabilitasyon (FTR)
                    </a>
                    @endif

                    <!-- 🫁 GÖĞÜS HASTALIKLARI (ANA DAL) -->
                    @if(isset($routes['pulmonology.index']))
                    <a href="{{ route('pulmonology.index') }}" class="list-group-item list-group-item-action border-0 rounded mb-1 {{ request()->routeIs('pulmonology.*') ? 'active fw-bold' : '' }}">
                        <i class="fa-solid fa-lungs me-2" style="color: #0284c7;"></i>Göğüs Hastalıkları
                    </a>
                    @endif

                    <!-- ❤️ KARDİYOLOJİ (ANA DAL) -->
                    @if(isset($routes['cardiology.index']))
                    <a href="{{ route('cardiology.index') }}" class="list-group-item list-group-item-action border-0 rounded mb-1 {{ request()->routeIs('cardiology.*') ? 'active fw-bold' : '' }}">
                        <i class="fa-solid fa-heart-pulse me-2 text-danger"></i>Kardiyoloji
                    </a>
                    @endif

                    <!-- ☢️ RADYASYON ONKOLOJİSİ (ANA DAL) -->
                    @if(isset($routes['radiation_oncology.index']))
                    <a href="{{ route('radiation_oncology.index') }}" class="list-group-item list-group-item-action border-0 rounded mb-1 {{ request()->routeIs('radiation_oncology.*') ? 'active fw-bold' : '' }}">
                        <i class="fa-solid fa-radiation me-2" style="color: #ea580c;"></i>Radyasyon Onkolojisi
                    </a>
                    @endif

                    <!-- ⚽ SPOR HEKİMLİĞİ (ANA DAL) -->
                    @if(isset($routes['sports_medicine.index']))
                    <a href="{{ route('sports_medicine.index') }}" class="list-group-item list-group-item-action border-0 rounded mb-1 {{ request()->routeIs('sports_medicine.*') ? 'active fw-bold' : '' }}">
                        <i class="fa-solid fa-person-running me-2 text-success"></i>Spor Hekimliği
                    </a>
                    @endif

                    <!-- ✈️ HAVA VE UZAY HEKİMLİĞİ (ANA DAL) -->
                    @if(isset($routes['aerospace_medicine.index']))
                    <a href="{{ route('aerospace_medicine.index') }}" class="list-group-item list-group-item-action border-0 rounded mb-1 {{ request()->routeIs('aerospace_medicine.*') ? 'active fw-bold' : '' }}">
                        <i class="fa-solid fa-plane-up me-2" style="color: #0369a1;"></i>Hava ve Uzay Hekimliği
                    </a>
                    @endif

                    <!-- ♨️ TIBBİ EKOLOJİ VE HİDROKLİMATOLOJİ (ANA DAL) -->
                    @if(isset($routes['medical_ecology.index']))
                    <a href="{{ route('medical_ecology.index') }}" class="list-group-item list-group-item-action border-0 rounded mb-1 {{ request()->routeIs('medical_ecology.*') ? 'active fw-bold' : '' }}">
                        <i class="fa-solid fa-hot-tub-person me-2" style="color: #059669;"></i>Tıbbi Ekoloji & Hidroklimatoloji
                    </a>
                    @endif

                    <!-- 🔪 GENEL CERRAHİ Açılır Menü -->
                    @if(isset($routes['general_surgery.index']))
                    <div class="mb-1">
                        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 w-100 text-start py-1 px-2 small fw-semibold text-dark {{ request()->routeIs('general_surgery.*') ? 'text-danger fw-bold' : '' }}" data-bs-toggle="collapse" data-bs-target="#collapseGenSurgSub" aria-expanded="{{ request()->routeIs('general_surgery.*') ? 'true' : 'false' }}">
                            <i class="fa-solid fa-scalpel me-2 text-danger"></i>Genel Cerrahi
                            <i class="fa-solid fa-chevron-down ms-auto small opacity-50"></i>
                        </button>
                        <div class="collapse {{ request()->routeIs('general_surgery.*') ? 'show' : '' }} ms-3 border-start border-2 border-danger-subtle ps-2 mt-1" id="collapseGenSurgSub">
                            <a href="{{ route('general_surgery.index') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('general_surgery.index') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-scalpel me-1 text-danger"></i>Genel Cerrahi (Ana Branş)
                            </a>
                            <a href="{{ route('general_surgery.surgical_oncology') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('general_surgery.surgical_oncology') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-ribbon me-1 text-warning"></i>Cerrahi Onkolojisi (Yan Dal)
                            </a>
                            <a href="{{ route('general_surgery.gi_surgery') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('general_surgery.gi_surgery') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-stomach me-1 text-primary"></i>Gastroenteroloji Cerrahisi (Yan Dal)
                            </a>
                        </div>
                    </div>
                    @endif

                    <!-- 🧠 BEYİN VE SİNİR CERRAHİSİ (NÖROŞİRÜRJİ - ANA DAL) -->
                    @if(isset($routes['neurosurgery.index']))
                    <a href="{{ route('neurosurgery.index') }}" class="list-group-item list-group-item-action border-0 rounded mb-1 {{ request()->routeIs('neurosurgery.*') ? 'active fw-bold' : '' }}">
                        <i class="fa-solid fa-brain me-2" style="color: #7c3aed;"></i>Beyin ve Sinir Cerrahisi
                    </a>
                    @endif

                    <!-- 🫁 GÖĞÜS CERRAHİSİ (ANA DAL) -->
                    @if(isset($routes['thoracic_surgery.index']))
                    <a href="{{ route('thoracic_surgery.index') }}" class="list-group-item list-group-item-action border-0 rounded mb-1 {{ request()->routeIs('thoracic_surgery.*') ? 'active fw-bold' : '' }}">
                        <i class="fa-solid fa-lungs me-2" style="color: #0284c7;"></i>Göğüs Cerrahisi
                    </a>
                    @endif

                    <!-- 👁️ GÖĞÜS HASTALIKLARI / GÖZ HASTALIKLARI Açılır Menü -->
                    @if(isset($routes['ophthalmology.index']))
                    <div class="mb-1">
                        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 w-100 text-start py-1 px-2 small fw-semibold text-dark {{ request()->routeIs('ophthalmology.*') ? 'fw-bold' : '' }}" style="{{ request()->routeIs('ophthalmology.*') ? 'color: #0891b2;' : '' }}" data-bs-toggle="collapse" data-bs-target="#collapseOphSub" aria-expanded="{{ request()->routeIs('ophthalmology.*') ? 'true' : 'false' }}">
                            <i class="fa-solid fa-eye me-2" style="color: #0891b2;"></i>Göz Hastalıkları
                            <i class="fa-solid fa-chevron-down ms-auto small opacity-50"></i>
                        </button>
                        <div class="collapse {{ request()->routeIs('ophthalmology.*') ? 'show' : '' }} ms-3 border-start border-2 ps-2 mt-1" style="border-color: #a5f3fc !important;" id="collapseOphSub">
                            <a href="{{ route('ophthalmology.index') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('ophthalmology.index') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-eye me-1" style="color: #0891b2;"></i>Göz Hastalıkları (Ana Branş)
                            </a>
                            <a href="{{ route('ophthalmology.glaucoma') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('ophthalmology.glaucoma') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-gauge-high me-1 text-warning"></i>Glokom Birimi
                            </a>
                            <a href="{{ route('ophthalmology.retina') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('ophthalmology.retina') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-circle-dot me-1 text-danger"></i>Retina Birimi
                            </a>
                            <a href="{{ route('ophthalmology.strabismus') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('ophthalmology.strabismus') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-arrows-split-up-and-left me-1 text-primary"></i>Şaşılık Birimi
                            </a>
                            <a href="{{ route('ophthalmology.uvea') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('ophthalmology.uvea') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-shield-virus me-1 text-danger"></i>Uvea Birimi
                            </a>
                            <a href="{{ route('ophthalmology.cornea') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('ophthalmology.cornea') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-sun me-1 text-info"></i>Kornea Birimi
                            </a>
                            <a href="{{ route('ophthalmology.oculoplastics') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('ophthalmology.oculoplastics') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-wand-magic-sparkles me-1 text-success"></i>Oküloplasti Birimi
                            </a>
                        </div>
                    </div>
                    @endif

                    <!-- 🤰 KADIN HASTALIKLARI VE DOĞUM Açılır Menü -->
                    @if(isset($routes['obgyn.index']))
                    <div class="mb-1">
                        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 w-100 text-start py-1 px-2 small fw-semibold text-dark {{ request()->routeIs('obgyn.*') ? 'fw-bold' : '' }}" style="{{ request()->routeIs('obgyn.*') ? 'color: #ec4899;' : '' }}" data-bs-toggle="collapse" data-bs-target="#collapseObgynSub" aria-expanded="{{ request()->routeIs('obgyn.*') ? 'true' : 'false' }}">
                            <i class="fa-solid fa-person-pregnant me-2" style="color: #ec4899;"></i>Kadın Hastalıkları ve Doğum
                            <i class="fa-solid fa-chevron-down ms-auto small opacity-50"></i>
                        </button>
                        <div class="collapse {{ request()->routeIs('obgyn.*') ? 'show' : '' }} ms-3 border-start border-2 ps-2 mt-1" style="border-color: #fbcfe8 !important;" id="collapseObgynSub">
                            <a href="{{ route('obgyn.index') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('obgyn.index') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-person-pregnant me-1" style="color: #ec4899;"></i>Kadın Hastalıkları ve Doğum (Ana Branş)
                            </a>
                            <a href="{{ route('obgyn.gyn_oncology') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('obgyn.gyn_oncology') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-ribbon me-1 text-danger"></i>Jinekolojik Onkoloji Cerrahisi (Yan Dal)
                            </a>
                            <a href="{{ route('obgyn.perinatology') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('obgyn.perinatology') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-baby me-1 text-warning"></i>Perinatoloji (Yan Dal)
                            </a>
                            <a href="{{ route('obgyn.ivf') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('obgyn.ivf') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-vial-virus me-1 text-primary"></i>Tüp Bebek & İnfertilite (Özel Birim)
                            </a>
                        </div>
                    </div>
                    @endif

                    <!-- 🥗 BESLENME VE DİYETETİK (ANA DAL) -->
                    @if(isset($routes['dietetics.index']))
                    <a href="{{ route('dietetics.index') }}" class="list-group-item list-group-item-action border-0 rounded mb-1 {{ request()->routeIs('dietetics.*') ? 'active fw-bold' : '' }}">
                        <i class="fa-solid fa-apple-whole me-2 text-success"></i>Beslenme ve Diyetetik
                    </a>
                    @endif

                    <!-- ❤️ KALP VE DAMAR CERRAHİSİ (ANA DAL) -->
                    @if(isset($routes['cardiovascular_surgery.index']))
                    <a href="{{ route('cardiovascular_surgery.index') }}" class="list-group-item list-group-item-action border-0 rounded mb-1 {{ request()->routeIs('cardiovascular_surgery.*') ? 'active fw-bold' : '' }}">
                        <i class="fa-solid fa-heart-pulse me-2 text-danger"></i>Kalp ve Damar Cerrahisi
                    </a>
                    @endif

                    <!-- 👂 KULAK BURUN BOĞAZ HASTALIKLARI (KBB - ANA DAL) -->
                    @if(isset($routes['ent.index']))
                    <a href="{{ route('ent.index') }}" class="list-group-item list-group-item-action border-0 rounded mb-1 {{ request()->routeIs('ent.*') ? 'active fw-bold' : '' }}">
                        <i class="fa-solid fa-ear-listen me-2 text-success"></i>Kulak Burun Boğaz Hastalıkları
                    </a>
                    @endif

                    <!-- 🦴 ORTOPEDİ VE TRAVMATOLOJİ Açılır Menü -->
                    @if(isset($routes['orthopedics.index']))
                    <div class="mb-1">
                        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 w-100 text-start py-1 px-2 small fw-semibold text-dark {{ request()->routeIs('orthopedics.*') ? 'fw-bold' : '' }}" style="{{ request()->routeIs('orthopedics.*') ? 'color: #ea580c;' : '' }}" data-bs-toggle="collapse" data-bs-target="#collapseOrthoSub" aria-expanded="{{ request()->routeIs('orthopedics.*') ? 'true' : 'false' }}">
                            <i class="fa-solid fa-bone me-2" style="color: #ea580c;"></i>Ortopedi ve Travmatoloji
                            <i class="fa-solid fa-chevron-down ms-auto small opacity-50"></i>
                        </button>
                        <div class="collapse {{ request()->routeIs('orthopedics.*') ? 'show' : '' }} ms-3 border-start border-2 ps-2 mt-1" style="border-color: #fed7aa !important;" id="collapseOrthoSub">
                            <a href="{{ route('orthopedics.index') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('orthopedics.index') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-bone me-1" style="color: #ea580c;"></i>Ortopedi ve Travmatoloji (Ana Branş)
                            </a>
                            <a href="{{ route('orthopedics.hand_surgery') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('orthopedics.hand_surgery') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-hand me-1 text-danger"></i>El Cerrahisi (Ortak Yan Dal)
                            </a>
                        </div>
                    </div>
                    @endif

                    <!-- 😊 PLASTİK, REKONSTRÜKTİF VE ESTETİK CERRAHİ Açılır Menü -->
                    @if(isset($routes['plastic_surgery.index']))
                    <div class="mb-1">
                        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 w-100 text-start py-1 px-2 small fw-semibold text-dark {{ request()->routeIs('plastic_surgery.*') ? 'fw-bold' : '' }}" style="{{ request()->routeIs('plastic_surgery.*') ? 'color: #d97706;' : '' }}" data-bs-toggle="collapse" data-bs-target="#collapsePlasticSub" aria-expanded="{{ request()->routeIs('plastic_surgery.*') ? 'true' : 'false' }}">
                            <i class="fa-solid fa-face-smile me-2" style="color: #d97706;"></i>Plastik Cerrahi
                            <i class="fa-solid fa-chevron-down ms-auto small opacity-50"></i>
                        </button>
                        <div class="collapse {{ request()->routeIs('plastic_surgery.*') ? 'show' : '' }} ms-3 border-start border-2 ps-2 mt-1" style="border-color: #fde68a !important;" id="collapsePlasticSub">
                            <a href="{{ route('plastic_surgery.index') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('plastic_surgery.index') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-face-smile me-1" style="color: #d97706;"></i>Plastik, Rekonstrüktif ve Estetik Cerrahi (Ana Branş)
                            </a>
                            <a href="{{ route('plastic_surgery.hand_surgery') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('plastic_surgery.hand_surgery') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-hand me-1 text-danger"></i>El Cerrahisi (Ortak Yan Dal)
                            </a>
                        </div>
                    </div>
                    @endif

                    <!-- 💧 ÜROLOJİ (ANA DAL) -->
                    @if(isset($routes['urology.index']))
                    <a href="{{ route('urology.index') }}" class="list-group-item list-group-item-action border-0 rounded mb-1 {{ request()->routeIs('urology.*') ? 'active fw-bold' : '' }}">
                        <i class="fa-solid fa-droplet me-2 text-primary"></i>Üroloji
                    </a>
                    @endif

                    <!-- 💉 ANESTEZİYOLOJİ VE REANİMASYON Açılır Menü -->
                    @if(isset($routes['anesthesiology.index']))
                    <div class="mb-1">
                        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 w-100 text-start py-1 px-2 small fw-semibold text-dark {{ request()->routeIs('anesthesiology.*') ? 'fw-bold' : '' }}" style="{{ request()->routeIs('anesthesiology.*') ? 'color: #7c3aed;' : '' }}" data-bs-toggle="collapse" data-bs-target="#collapseAnsSub" aria-expanded="{{ request()->routeIs('anesthesiology.*') ? 'true' : 'false' }}">
                            <i class="fa-solid fa-syringe me-2" style="color: #7c3aed;"></i>Anesteziyoloji ve Reanimasyon
                            <i class="fa-solid fa-chevron-down ms-auto small opacity-50"></i>
                        </button>
                        <div class="collapse {{ request()->routeIs('anesthesiology.*') ? 'show' : '' }} ms-3 border-start border-2 ps-2 mt-1" style="border-color: #ddd6fe !important;" id="collapseAnsSub">
                            <a href="{{ route('anesthesiology.index') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('anesthesiology.index') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-syringe me-1" style="color: #7c3aed;"></i>Anesteziyoloji ve Reanimasyon (Ana Branş)
                            </a>
                            <a href="{{ route('anesthesiology.algology') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('anesthesiology.algology') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-bolt me-1 text-warning"></i>Algoloji (Ağrı Polikliniği) (Yan Dal)
                            </a>
                        </div>
                    </div>
                    @endif

                    <!-- 🧠 NÖROLOJİ Açılır Menü -->
                    @if(isset($routes['neurology.index']))
                    <div class="mb-1">
                        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 w-100 text-start py-1 px-2 small fw-semibold text-dark {{ request()->routeIs('neurology.*') ? 'fw-bold' : '' }}" style="{{ request()->routeIs('neurology.*') ? 'color: #7c3aed;' : '' }}" data-bs-toggle="collapse" data-bs-target="#collapseNeurologySub" aria-expanded="{{ request()->routeIs('neurology.*') ? 'true' : 'false' }}">
                            <i class="fa-solid fa-brain me-2" style="color: #7c3aed;"></i>Nöroloji
                            <i class="fa-solid fa-chevron-down ms-auto small opacity-50"></i>
                        </button>
                        <div class="collapse {{ request()->routeIs('neurology.*') ? 'show' : '' }} ms-3 border-start border-2 ps-2 mt-1" style="border-color: #ddd6fe !important;" id="collapseNeurologySub">
                            <a href="{{ route('neurology.index') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('neurology.index') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-brain me-1" style="color: #7c3aed;"></i>Nöroloji (Ana Branş)
                            </a>
                            <a href="{{ route('neurology.neurophysiology') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('neurology.neurophysiology') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-wave-square me-1 text-danger"></i>Klinik Nörofizyoloji (Yan Dal)
                            </a>
                        </div>
                    </div>
                    @endif

                    <!-- 🧠 RUH SAĞLIĞI VE HASTALIKLARI (PSİKİYATRİ & AMATEM) -->
                    @if(isset($routes['psychiatry.index']))
                    <div class="mb-1">
                        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 w-100 text-start py-1 px-2 small fw-semibold text-dark {{ request()->routeIs('psychiatry.*') ? 'fw-bold' : '' }}" style="{{ request()->routeIs('psychiatry.*') ? 'color: #0284c7;' : '' }}" data-bs-toggle="collapse" data-bs-target="#collapsePsychiatrySub" aria-expanded="{{ request()->routeIs('psychiatry.*') ? 'true' : 'false' }}">
                            <i class="fa-solid fa-head-side-virus me-2" style="color: #0284c7;"></i>Ruh Sağlığı ve Hastalıkları
                            <i class="fa-solid fa-chevron-down ms-auto small opacity-50"></i>
                        </button>
                        <div class="collapse {{ request()->routeIs('psychiatry.*') ? 'show' : '' }} ms-3 border-start border-2 ps-2 mt-1" style="border-color: #bae6fd !important;" id="collapsePsychiatrySub">
                            <a href="{{ route('psychiatry.index') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('psychiatry.index') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-brain me-1" style="color: #0284c7;"></i>Psikiyatri (Ana Branş)
                            </a>
                            <a href="{{ route('psychiatry.amatem') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('psychiatry.amatem') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-capsules me-1 text-danger"></i>AMATEM (Özel Birim)
                            </a>
                        </div>
                    </div>
                    @endif

                    <!-- 🩺 DAHİLİ (İÇ) TIP BİLİMLERİ (10 Yan Dal Açılır Menü) -->
                    @if(isset($routes['internal_medicine.index']))
                    <div class="mb-1">
                        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 w-100 text-start py-1 px-2 small fw-semibold text-dark {{ request()->routeIs('internal_medicine.*') ? 'text-primary fw-bold' : '' }}" data-bs-toggle="collapse" data-bs-target="#collapseInternalSub" aria-expanded="{{ request()->routeIs('internal_medicine.*') ? 'true' : 'false' }}">
                            <i class="fa-solid fa-notes-medical me-2 text-primary"></i>Dahili (İç) Tıp Bilimleri
                            <i class="fa-solid fa-chevron-down ms-auto small opacity-50"></i>
                        </button>
                        <div class="collapse {{ request()->routeIs('internal_medicine.*') ? 'show' : '' }} ms-3 border-start border-2 border-primary-subtle ps-2 mt-1" id="collapseInternalSub">
                            <a href="{{ route('internal_medicine.index') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('internal_medicine.index') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-stethoscope me-1"></i>İç Hastalıkları (Dahiliye)
                            </a>
                            <a href="{{ route('internal_medicine.endocrinology') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('internal_medicine.endocrinology') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-dna me-1"></i>Endokrinoloji & Metabolizma
                            </a>
                            <a href="{{ route('internal_medicine.gastroenterology') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('internal_medicine.gastroenterology') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-stomach me-1"></i>Gastroenteroloji
                            </a>
                            <a href="{{ route('internal_medicine.geriatrics') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('internal_medicine.geriatrics') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-person-cane me-1"></i>Geriatri
                            </a>
                            <a href="{{ route('internal_medicine.hematology') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('internal_medicine.hematology') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-droplet me-1 text-danger"></i>Hematoloji
                            </a>
                            <a href="{{ route('internal_medicine.allergy_immunology') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('internal_medicine.allergy_immunology') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-allergies me-1"></i>İmmünoloji & Alerji
                            </a>
                            <a href="{{ route('internal_medicine.occupational') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('internal_medicine.occupational') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-briefcase-medical me-1"></i>İş ve Meslek Hast.
                            </a>
                            <a href="{{ route('internal_medicine.nephrology') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('internal_medicine.nephrology') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-kidney me-1"></i>Nefroloji
                            </a>
                            <a href="{{ route('internal_medicine.rheumatology') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('internal_medicine.rheumatology') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-bone me-1"></i>Romatoloji
                            </a>
                            <a href="{{ route('internal_medicine.oncology') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('internal_medicine.oncology') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-ribbon me-1 text-primary"></i>Tıbbi Onkoloji
                            </a>
                        </div>
                    </div>
                    @endif

                    <!-- 🔴 ÇOCUK SAĞLIĞI & PEDİATRİ (19 Yan Dal Açılır Menü) -->
                    @if(isset($routes['pediatrics.index']))
                    <div class="mb-1">
                        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 w-100 text-start py-1 px-2 small fw-semibold text-dark {{ request()->routeIs('pediatrics.*') ? 'text-indigo fw-bold' : '' }}" data-bs-toggle="collapse" data-bs-target="#collapsePediatricsSub" aria-expanded="{{ request()->routeIs('pediatrics.*') ? 'true' : 'false' }}">
                            <i class="fa-solid fa-child-reaching me-2 text-indigo"></i>Çocuk Sağlığı & Pediatri
                            <i class="fa-solid fa-chevron-down ms-auto small opacity-50"></i>
                        </button>
                        <div class="collapse {{ request()->routeIs('pediatrics.*') ? 'show' : '' }} ms-3 border-start border-2 border-indigo-subtle ps-2 mt-1" id="collapsePediatricsSub">
                            <a href="{{ route('pediatrics.index') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('pediatrics.index') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-child me-1"></i>Çocuk Sağlığı (Ana)
                            </a>
                            <a href="{{ route('pediatrics.neonatology') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('pediatrics.neonatology') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-baby me-1"></i>Neonatoloji (Yenidoğan)
                            </a>
                            <a href="{{ route('pediatrics.neurology') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('pediatrics.neurology') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-brain me-1"></i>Çocuk Nörolojisi
                            </a>
                            <a href="{{ route('pediatrics.developmental') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('pediatrics.developmental') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-hands-holding-child me-1"></i>Gelişimsel Pediatri
                            </a>
                            <a href="{{ route('pediatrics.hematology_oncology') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('pediatrics.hematology_oncology') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-droplet me-1 text-danger"></i>Hematoloji & Onkoloji
                            </a>
                            <a href="{{ route('pediatrics.endocrinology') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('pediatrics.endocrinology') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-dna me-1"></i>Çocuk Endokrinolojisi
                            </a>
                            <a href="{{ route('pediatrics.metabolism') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('pediatrics.metabolism') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-flask me-1"></i>Metabolizma Hast.
                            </a>
                            <a href="{{ route('pediatrics.pulmonology') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('pediatrics.pulmonology') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-lungs me-1"></i>Çocuk Göğüs Hast.
                            </a>
                            <a href="{{ route('pediatrics.allergy_immunology') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('pediatrics.allergy_immunology') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-allergies me-1"></i>Alerji & İmmünoloji
                            </a>
                            <a href="{{ route('pediatrics.cardiology') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('pediatrics.cardiology') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-heart-pulse me-1 text-danger"></i>Çocuk Kardiyolojisi
                            </a>
                            <a href="{{ route('pediatrics.gastroenterology') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('pediatrics.gastroenterology') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-stomach me-1"></i>Çocuk Gastroenteroloji
                            </a>
                            <a href="{{ route('pediatrics.nephrology') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('pediatrics.nephrology') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-kidney me-1"></i>Çocuk Nefrolojisi
                            </a>
                            <a href="{{ route('pediatrics.rheumatology') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('pediatrics.rheumatology') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-bone me-1"></i>Çocuk Romatolojisi
                            </a>
                            <a href="{{ route('pediatrics.infectious') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('pediatrics.infectious') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-shield-virus me-1"></i>Çocuk Enfeksiyon
                            </a>
                            <a href="{{ route('pediatrics.genetics') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('pediatrics.genetics') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-microscope me-1"></i>Çocuk Genetik Hast.
                            </a>
                            <a href="{{ route('pediatrics.surgery') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('pediatrics.surgery') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-scalpel me-1"></i>Çocuk Cerrahisi
                            </a>
                            <a href="{{ route('pediatrics.cardiovascular_surgery') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('pediatrics.cardiovascular_surgery') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-heart-circle-check me-1 text-danger"></i>Çocuk KDC (Kalp Damar)
                            </a>
                            <a href="{{ route('pediatrics.urology') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('pediatrics.urology') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-notes-medical me-1"></i>Çocuk Ürolojisi
                            </a>
                            <a href="{{ route('pediatrics.psychiatry') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('pediatrics.psychiatry') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-head-side-virus me-1 text-warning"></i>Çocuk Psikiyatrisi (Gizli)
                            </a>
                        </div>
                    </div>
                    @endif

                    <!-- 🦷 DİŞ HEKİMLİĞİ & ODONTOLOJİ (9 Branş Açılır Menü) -->
                    @if(isset($routes['dental.index']))
                    <div class="mb-1">
                        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 w-100 text-start py-1 px-2 small fw-semibold text-dark {{ request()->routeIs('dental.*') ? 'text-primary fw-bold' : '' }}" data-bs-toggle="collapse" data-bs-target="#collapseDentalSub" aria-expanded="{{ request()->routeIs('dental.*') ? 'true' : 'false' }}">
                            <i class="fa-solid fa-tooth me-2 text-primary"></i>Diş Hekimliği (Odontoloji)
                            <i class="fa-solid fa-chevron-down ms-auto small opacity-50"></i>
                        </button>
                        <div class="collapse {{ request()->routeIs('dental.*') ? 'show' : '' }} ms-3 border-start border-2 border-primary-subtle ps-2 mt-1" id="collapseDentalSub">
                            <a href="{{ route('dental.index') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('dental.index') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-stethoscope me-1"></i>Genel Diş Hekimliği
                            </a>
                            <a href="{{ route('dental.surgery') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('dental.surgery') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-user-ninja me-1"></i>Ağız, Diş ve Çene Cerrahisi
                            </a>
                            <a href="{{ route('dental.radiology') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('dental.radiology') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-x-ray me-1"></i>Çene Radyolojisi
                            </a>
                            <a href="{{ route('dental.pedodontics') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('dental.pedodontics') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-child me-1"></i>Pedodonti (Çocuk Diş)
                            </a>
                            <a href="{{ route('dental.endodontics') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('dental.endodontics') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-syringe me-1"></i>Endodonti (Kanal)
                            </a>
                            <a href="{{ route('dental.orthodontics') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('dental.orthodontics') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-equals me-1"></i>Ortodonti (Tel)
                            </a>
                            <a href="{{ route('dental.periodontics') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('dental.periodontics') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-gear me-1"></i>Periodontoloji (Diş Eti)
                            </a>
                            <a href="{{ route('dental.prosthodontics') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('dental.prosthodontics') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-gem me-1"></i>Protetik Diş (Protez)
                            </a>
                            <a href="{{ route('dental.restorative') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('dental.restorative') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-sparkles me-1"></i>Restoratif Diş
                            </a>
                        </div>
                    </div>
                    @endif

                    <!-- 📋 TANISAL & ÖZEL POLİKLİNİKLER (9 Birim Açılır Menü) -->
                    @if(isset($routes['specialized.index']))
                    <div class="mb-1">
                        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 w-100 text-start py-1 px-2 small fw-semibold text-dark {{ request()->routeIs('specialized.*') ? 'text-success fw-bold' : '' }}" data-bs-toggle="collapse" data-bs-target="#collapseSpecializedSub" aria-expanded="{{ request()->routeIs('specialized.*') ? 'true' : 'false' }}">
                            <i class="fa-solid fa-notes-medical me-2 text-success"></i>Tanısal & Özel Poliklinikler
                            <i class="fa-solid fa-chevron-down ms-auto small opacity-50"></i>
                        </button>
                        <div class="collapse {{ request()->routeIs('specialized.*') ? 'show' : '' }} ms-3 border-start border-2 border-success-subtle ps-2 mt-1" id="collapseSpecializedSub">
                            <a href="{{ route('specialized.index') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('specialized.index') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-file-signature me-1"></i>Sağlık Kurulu Erişkin
                            </a>
                            <a href="{{ route('specialized.cozger') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('specialized.cozger') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-child-check me-1"></i>Sağlık Kurulu ÇÖZGER
                            </a>
                            <a href="{{ route('specialized.genetics') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('specialized.genetics') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-dna me-1"></i>Tıbbi Genetik
                            </a>
                            <a href="{{ route('specialized.nuclear_medicine') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('specialized.nuclear_medicine') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-radiation me-1"></i>Nükleer Tıp
                            </a>
                            <a href="{{ route('specialized.radiology') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('specialized.radiology') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-x-ray me-1"></i>Tanısal Radyoloji
                            </a>
                            <a href="{{ route('specialized.smoking_cessation') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('specialized.smoking_cessation') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-ban-smoking me-1"></i>Sigarayı Bıraktırma
                            </a>
                            <a href="{{ route('specialized.sleep') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('specialized.sleep') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-bed-pulse me-1"></i>Uyku Polikliniği
                            </a>
                            <a href="{{ route('specialized.getat') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('specialized.getat') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-leaf me-1"></i>GETAT (Tamamlayıcı Tıp)
                            </a>
                            <a href="{{ route('specialized.hyperbaric') }}" class="list-group-item list-group-item-action border-0 rounded py-1 px-2 small {{ request()->routeIs('specialized.hyperbaric') ? 'active fw-bold' : '' }}">
                                <i class="fa-solid fa-mask-ventilator me-1"></i>Hiperbarik Tıp
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <!-- 3. İLAÇ, REÇETE & RAPORLAR (Doktor, Eczacı, Admin) -->
        @if(!$user || $user->hasRole(['admin', 'physician', 'chief_physician', 'pharmacist']))
        <div class="accordion-item border-0 bg-transparent mb-1">
            <button class="sidebar-category-btn {{ request()->routeIs(['prescription.*', 'pharmacy.*', 'medical_report.*']) ? '' : 'collapsed' }}" 
                    type="button" data-bs-toggle="collapse" data-bs-target="#collapsePharmacy" 
                    aria-expanded="{{ request()->routeIs(['prescription.*', 'pharmacy.*', 'medical_report.*']) ? 'true' : 'false' }}">
                <span><i class="fa-solid fa-pills me-2 text-secondary"></i>Eczane & Reçete</span>
                <i class="fa-solid fa-chevron-right arrow-icon"></i>
            </button>

            <div id="collapsePharmacy" class="accordion-collapse collapse {{ request()->routeIs(['prescription.*', 'pharmacy.*', 'medical_report.*']) ? 'show' : '' }}" data-bs-parent="#sidebarAccordion">
                <div class="list-group list-group-flush ms-2 ps-2 border-start border-2 border-light mt-1">
                    @if(isset($routes['prescription.index']) && (!$user || $user->hasRole(['admin', 'physician', 'chief_physician'])))
                    <a href="{{ route('prescription.index') }}" class="list-group-item list-group-item-action border-0 rounded {{ request()->routeIs('prescription.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-file-prescription me-2"></i>E-Reçete Masası
                    </a>
                    @endif

                    @if(isset($routes['pharmacy.index']) && (!$user || $user->hasRole(['admin', 'pharmacist', 'physician', 'chief_physician'])))
                    <a href="{{ route('pharmacy.index') }}" class="list-group-item list-group-item-action border-0 rounded {{ request()->routeIs('pharmacy.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-prescription-bottle-medical me-2"></i>Eczane Masası
                    </a>
                    @endif

                    @if(isset($routes['medical_report.chief_physician']) && (!$user || $user->hasRole(['admin', 'chief_physician', 'physician'])))
                    <a href="{{ route('medical_report.chief_physician', ['patient_id' => 1]) }}" class="list-group-item list-group-item-action border-0 rounded {{ request()->routeIs('medical_report.*') || request()->routeIs('ai.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-user-doctor me-2 text-primary"></i>Doktor Paneli & AI Asistanı
                    </a>
                    @endif
                    
                    @if(isset($routes['chief_physician.index']) && (!$user || $user->hasRole(['admin', 'chief_physician'])))
                    <a href="{{ route('chief_physician.index') }}" class="list-group-item list-group-item-action border-0 rounded fw-bold text-primary mt-2 p-2 rounded-3 border border-primary-subtle {{ request()->routeIs('chief_physician.*') ? 'active' : '' }}" style="background-color: #eff6ff;">
                        <i class="fa-solid fa-user-shield me-2 text-primary"></i>Başhekim Paneli
                    </a>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <!-- 4. KLİNİK OPERASYONLAR (Doktor, Hemşire, Admin) -->
        @if(!$user || $user->hasRole(['admin', 'physician', 'chief_physician', 'nurse']))
        <div class="accordion-item border-0 bg-transparent mb-1">
            <button class="sidebar-category-btn {{ request()->routeIs(['inpatient.*', 'nursing.*', 'surgery.*', 'diagnostics.*', 'pathology.*', 'obstetrics.*', 'nutrition.*']) ? '' : 'collapsed' }}" 
                    type="button" data-bs-toggle="collapse" data-bs-target="#collapseClinical" 
                    aria-expanded="{{ request()->routeIs(['inpatient.*', 'nursing.*', 'surgery.*', 'diagnostics.*', 'pathology.*', 'obstetrics.*', 'nutrition.*']) ? 'true' : 'false' }}">
                <span><i class="fa-solid fa-hospital-user me-2 text-secondary"></i>Klinik Servisler</span>
                <i class="fa-solid fa-chevron-right arrow-icon"></i>
            </button>

            <div id="collapseClinical" class="accordion-collapse collapse {{ request()->routeIs(['inpatient.*', 'nursing.*', 'surgery.*', 'diagnostics.*', 'pathology.*', 'obstetrics.*', 'nutrition.*']) ? 'show' : '' }}" data-bs-parent="#sidebarAccordion">
                <div class="list-group list-group-flush ms-2 ps-2 border-start border-2 border-light mt-1">
                    @if(isset($routes['inpatient.admission.index']))
                    <a href="{{ route('inpatient.admission.index') }}" class="list-group-item list-group-item-action border-0 rounded {{ request()->routeIs('inpatient.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-bed me-2"></i>Yatan Hasta & Yatak
                    </a>
                    @endif

                    @if(isset($routes['nursing.index']))
                    <a href="{{ route('nursing.index') }}" class="list-group-item list-group-item-action border-0 rounded {{ request()->routeIs('nursing.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-user-nurse me-2"></i>Hemşirelik Bakım
                    </a>
                    @endif

                    @if(isset($routes['surgery.index']))
                    <a href="{{ route('surgery.index') }}" class="list-group-item list-group-item-action border-0 rounded {{ request()->routeIs('surgery.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-syringe me-2"></i>Ameliyathane & Anestezi
                    </a>
                    @endif

                    @if(isset($routes['diagnostics.index']))
                    <a href="{{ route('diagnostics.index') }}" class="list-group-item list-group-item-action border-0 rounded {{ request()->routeIs('diagnostics.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-microscope me-2"></i>Laboratuvar & Radyoloji
                    </a>
                    @endif

                    @if(isset($routes['pathology.index']))
                    <a href="{{ route('pathology.index') }}" class="list-group-item list-group-item-action border-0 rounded {{ request()->routeIs('pathology.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-vial-virus me-2"></i>Patoloji Raporlama
                    </a>
                    @endif

                    @if(isset($routes['obstetrics.index']))
                    <a href="{{ route('obstetrics.index') }}" class="list-group-item list-group-item-action border-0 rounded {{ request()->routeIs('obstetrics.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-baby-carriage me-2"></i>Kadın Doğum & Yenidoğan
                    </a>
                    @endif

                    @if(isset($routes['nutrition.index']))
                    <a href="{{ route('nutrition.index') }}" class="list-group-item list-group-item-action border-0 rounded {{ request()->routeIs('nutrition.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-apple-whole me-2"></i>Beslenme & Diyet
                    </a>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <!-- 5. YÖNETİM & KADRO (Admin, Başhekim) -->
        @if(!$user || $user->hasRole(['admin', 'chief_physician', 'manager']))
        @if(isset($routes['organization.buildings.index']))
        <div class="accordion-item border-0 bg-transparent mb-1">
            <button class="sidebar-category-btn {{ request()->routeIs(['organization.*', 'personnel.*']) ? '' : 'collapsed' }}" 
                    type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdmin" 
                    aria-expanded="{{ request()->routeIs(['organization.*', 'personnel.*']) ? 'true' : 'false' }}">
                <span><i class="fa-solid fa-sliders me-2 text-secondary"></i>Yönetim & Kadro</span>
                <i class="fa-solid fa-chevron-right arrow-icon"></i>
            </button>

            <div id="collapseAdmin" class="accordion-collapse collapse {{ request()->routeIs(['organization.*', 'personnel.*']) ? 'show' : '' }}" data-bs-parent="#sidebarAccordion">
                <div class="list-group list-group-flush ms-2 ps-2 border-start border-2 border-light mt-1">
                    <a href="{{ route('organization.buildings.index') }}" class="list-group-item list-group-item-action border-0 rounded {{ request()->routeIs('organization.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-sitemap me-2"></i>Organizasyon Yapısı
                    </a>

                    <a href="{{ route('personnel.doctors.index') }}" class="list-group-item list-group-item-action border-0 rounded {{ request()->routeIs('personnel.doctors.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-user-md me-2 text-primary"></i>Doktor Kadrosu & Kartlar
                    </a>

                    <a href="{{ route('personnel.personnels.index') }}" class="list-group-item list-group-item-action border-0 rounded {{ request()->routeIs('personnel.personnels.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-users me-2 text-info"></i>Klinik Bakım & Personeller
                    </a>
                </div>
            </div>
        </div>
        @endif
        @endif

    </div>
</div>
