# HBYS Core - Hastane Yönetim Bilgi Sistemi

HBYS Core; bir hastanenin tıbbi, klinik, idari, mali ve operasyonel süreçlerini tek bir merkezden yönetmek üzere tasarlanmış **Modüler Monolit** mimariye sahip web uygulamasıdır.

---

## 🚀 Ekip İçin Kurulum Adımları

Projede geliştirme yapmaya başlamak için aşağıdaki adımları sırasıyla uygulayınız:

### 1. Repoyu Klonlayın
```bash
git clone https://github.com/bedirhand-dikmen/hbys-core.git
cd hbys-core
```

### 2. Ortam Dosyasını Hazırlayın
```bash
cp .env.example .env
```

### 3. Docker Servislerini Başlatın
```bash
docker compose up -d
```
> **Not:** `docker compose up -d` komutu çalıştırıldığında PHP, MySQL ve Redis konteynerleri ayağa kalkar ve Composer paket bağımlılıkları otomatik olarak yüklenir.

### 4. Uygulama Anahtarını Üretin ve Veritabanı Tablolarını Çalıştırın
```bash
    docker exec -it hbys-app php artisan key:generate
docker exec -it hbys-app php artisan migrate --seed
```

### 5. Tarayıcıdan Erişin
Sisteme erişim adresi: **[http://localhost:8000](http://localhost:8000)**

---

## 👥 Ekip Görev Dağılımı ve Modül Sorumlulukları

Proje ekibi 1 proje yöneticisi ve 3 yazılım geliştiriciden oluşmaktadır. Her geliştirici kendi modül alanından sorumludur:

### 👑 Proje Yöneticisi: Muhammed Aydın
- Proje kapsamı ve ana mimari kontrolü
- Veri tabanı ilişkileri ve modül sınırlarının belirlenmesi
- API sözleşmeleri ve güvenlik kurallarının denetimi
- Kod incelemeleri (Code Review) ve Pull Request (PR) onayları
- Entegrasyon koordinasyonu ve kullanıcı kabul testleri (UAT)

---

### 💻 Geliştirici 1 Bedirhan Dikmen: Çekirdek ve Hasta Dosyası
*Sorumlu Olunan Modüller (`app/Modules/`):*
- **`Identity`**: Kullanıcı, rol ve yetkilendirme yönetimi
- **`Organization`**: Hastane organizasyon yapısı (Bina, Kat, Klinik, Poliklinik, Muayene Odası)
- **`Personnel`**: Personel ve doktor yönetimi, klinik görevlendirmeleri
- **`Patient`**: Hasta ana kayıt sistemi (Demografik veriler, hasta kartı)
- **`ElectronicHealthRecord`**: Elektronik hasta dosyası ve özet ekranı
- **`Appointment`**: Randevu ve zaman çizelgesi yönetimi
- **`Outpatient`**: Poliklinik akışı ve doktor muayenesi
- **`Emergency`**: Acil servis ve triyaj yönetimi
- **`Referral`**: Hastaneler arası ve klinikler arası sevk işlemleri

---

### 💻 Geliştirici 2 Kürşat Kıran: Klinik Operasyonlar
*Sorumlu Olunan Modüller (`app/Modules/`):*
- **`Inpatient`**: Hasta yatış işlemleri
- **`Discharge`**: Taburculuk işlemleri
- **`Nursing`**: Hemşirelik ve hasta bakım takip işlemleri
- **`Surgery`**: Ameliyathane yönetimi
- **`Anesthesia`**: Anestezi takip süreçleri
- **`Laboratory`**: Laboratuvar istem, numune ve sonuç yönetimi
- **`Radiology`**: Radyoloji istem ve raporlama süreçleri
- **`Pathology`**: Patoloji sonuç ve takip süreçleri
- **`Obstetrics`**: Kadın doğum ve gebelik takip süreçleri
- **`Newborn`**: Doğum kaydı ve yenidoğan bağımsız hasta işlemleri
- **`Nutrition`**: Beslenme ve diyet yönetimi

---

### 💻 Geliştirici 3 Sude Hakyemez: İlaç, Rapor, Entegrasyon ve Yapay Zekâ
*Sorumlu Olunan Modüller (`app/Modules/`):*
- **`Pharmacy`**: Eczane ve ilaç deposu kontrolü
- **`Prescription`**: E-reçete ve ilaç yönetimi
- **`MedicalReport`**: Tıbbi raporlar ve başhekimlik onay mekanizması
- **`Billing`**: Faturalandırma ve muhasebe entegrasyonu
- **`Inventory`**: Stok ve malzeme yönetimi
- **`Approval`**: Onay mekanizmaları
- **`Integrations`**: Harici servis adaptörleri (MEDULA, SGK, e-Nabız, KPS, e-Rapor)
- **`ArtificialIntelligence`**: Yapay zekâ destekli doktor asistanı ve AI Gateway
- **`Notification`**: Bildirim ve klinik uyarı sistemi
- **`Reporting`**: Yönetim raporları ve istatistikler

---

## 🗄️ Veritabanı Yapısı ve Konfigürasyonu

Veritabanı Docker konteyneri üzerinde izole olarak çalışmaktadır:

- **Veritabanı Motoru:** MySQL 8.0 (InnoDB)
- **Konteyner Adı:** `hbys-mysql`
- **Erişim Portu:** `3306`
- **Veritabanı Adı (Database):** `hbys_db`
- **Kullanıcı Adı (User):** `root`
- **Şifre (Password):** `root`
- **Kalıcı Depolama (Volume):** Docker `dbdata` volume (Konteyner kapatılsa dahi verileriniz korunur).

---

## 🌿 Git Branching Strategy & Çalışma Akışı

Projede ana dal (`main`) her zaman çalışan ve kararlı sürümdür. Geliştirmelerinizi aşağıdaki standart adımları takip ederek gerçekleştiriniz:

### 1. Gün Başı Güncellemesi
Çalışmaya başlamadan önce ana dalınızı güncelleyin:
```bash
git checkout main
git pull origin main
```

### 2. Yeni Görev İçin Branch Açma
Geliştireceğiniz özellik veya modül için yeni bir branch oluşturun:
```bash
git checkout -b feature/modul-adi
# Örnek: git checkout -b feature/patient-registration
```

### 3. Kod Geliştirmesi ve Commit
Geliştirmelerinizi tamamladıktan sonra standart commit mesajlarıyla kaydedin:
```bash
git add .
git commit -m "feat: [Modül Adı] açıklama"
```

### 4. Push ve Pull Request (PR)
Branch'inizi sunucuya gönderin ve GitHub üzerinden `main` dalına Pull Request (PR) açın:
```bash
git push origin feature/modul-adi
```
> **Önemli:** Açılan PR'lar Proje Yöneticisi (**Muhammed Aydın**) incelemesi ve onayından sonra `main` dalına birleştirilecektir.

---

## 🏗️ Proje Mimarisi

```
app/
├── Modules/                     # Bağımsız İş Modülleri (29 Modül)
│   ├── Identity/
│   ├── Organization/
│   ├── Personnel/
│   ├── Patient/
│   ├── ElectronicHealthRecord/
│   ├── Appointment/
│   ├── Outpatient/
│   ├── Emergency/
│   ├── ...
├── Integrations/                # Harici API Adaptörleri (MEDULA, KPS, AI)
├── Services/                    # Ortak Servis Katmanı
├── Jobs/                        # Kuyruk Görevleri
├── Events/                      # Sistem Olayları
├── Listeners/                   # Dinleyiciler
├── Policies/                    # Erişim Politikaları
└── Support/                     # Yardımcı Sınıflar ve Araçlar
```

Her modül kendi içerisinde aşağıdaki katmanlı mimariyi barındırır:
```
ModuleName/
├── Controllers/                 # HTTP Kontrolcüleri
├── Models/                      # Eloquent Modelleri
├── Services/                    # İş Mantığı Servisleri
├── Repositories/                # Veri Erişim Katmanı
├── Requests/                    # Form Doğrulama (Validation)
├── Resources/                   # API / JSON Dönüştürücüler
├── Policies/                    # Yetkilendirme Kuralları
├── Events/                      # Modüle Özgü Olaylar
├── Listeners/                   # Olay Dinleyicileri
├── Routes/                      # Web ve API Rotaları (web.php)
├── Database/                    # Migration, Seeder ve Factoryler
└── Tests/                       # Birim ve Entegrasyon Testleri
``` 

docker compose exec app php artisan migrate:fresh --seed