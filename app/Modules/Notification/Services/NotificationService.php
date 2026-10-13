<?php

namespace App\Modules\Notification\Services;

class NotificationService
{
    /**
     * Klinik Uyarı ve Bildirim Sistemi (5 Önem Seviyesi Sınıflandırması)
       /**
     * Klinik Uyarı ve Bildirim Sistemi (Sadece Giriş Yapan Doktora ve Kendi Hastasına Özel Filtreleme)
     */
    public function getActiveClinicalAlerts(int $patientId = 0, $user = null): array
    {
        $user = $user ?? auth()->user();
        $role = $user->role ?? 'admin';
        $userName = mb_strtolower($user->name ?? '', 'UTF-8');

        // 1. ECZACI ROLÜNE ÖZEL İLAÇ STOK, SON KULLANMA VE İTS BİLDİRİMLERİ
        if ($role === 'pharmacist') {
            $allAlerts = [
                [
                    'id' => 201,
                    'patient_id' => 0,
                    'patient_name' => 'Hastane Depo',
                    'alert_type' => 'critical_stock_warning',
                    'severity' => 'critical',
                    'severity_label' => 'Kritik Stok',
                    'title' => '🚨 KRİTİK İLAÇ STOK UYARISI',
                    'message' => 'Candesartan 16mg Tablet stok miktarı kritik sınırın altına düştü (Kalan: 8 Kutu). Ana depodan acil stok ikmali talep ediniz.',
                    'created_at' => '5 dakika önce'
                ],
                [
                    'id' => 202,
                    'patient_id' => 0,
                    'patient_name' => 'Eczane Raf B-04',
                    'alert_type' => 'expiry_date_warning',
                    'severity' => 'high_risk',
                    'severity_label' => 'SKT Uyarısı',
                    'title' => '⚠️ SON KULLANMA TARİHİ (SKT) YAKLAŞAN İLAÇ',
                    'message' => 'Ventolin Inhaler 100mcg (Parti No: L2024-99) için SKT dolmasına 15 gün kaldı. Çıkış önceliği veriniz.',
                    'created_at' => '30 dakika önce'
                ],
                [
                    'id' => 203,
                    'patient_id' => 1,
                    'patient_name' => 'Ahmet Yılmaz',
                    'alert_type' => 'its_notification',
                    'severity' => 'warning',
                    'severity_label' => 'İTS İletimi',
                    'title' => '📦 İTS KAREKOD DÜŞÜM BİLDİRİMİ',
                    'message' => 'EREP-2026-998811 nolu e-reçete ilaçları teslim edildi. İTS Sağlık Bakanlığı sisteminde karekod pasife çekildi.',
                    'created_at' => '1 saat önce'
                ],
                [
                    'id' => 204,
                    'patient_id' => 2,
                    'patient_name' => 'Ayşe Demir',
                    'alert_type' => 'inpatient_order_alert',
                    'severity' => 'reminder',
                    'severity_label' => 'Servis İstemi',
                    'title' => '🔔 YATAN HASTA SERVİS İLAÇ İSTEMİ',
                    'message' => 'Kadın Doğum Servisi (Oda 304) tarafından 8 aşamalı ilaç hazırlık hattına yeni istem düştü.',
                    'created_at' => '2 saat önce'
                ]
            ];
        }
        // 2. HEMŞİRE ROLÜNE ÖZEL HASTA BAKIM VE SERVİS UYARILARI
        elseif ($role === 'nurse') {
            $allAlerts = [
                [
                    'id' => 301,
                    'patient_id' => 2,
                    'patient_name' => 'Ayşe Demir (Oda 304)',
                    'alert_type' => 'vitals_warning',
                    'severity' => 'critical',
                    'severity_label' => 'Ateş Uyarısı',
                    'title' => '🩺 YATAN HASTA VİTALS UYARISI',
                    'message' => 'Yatak 304 Ayşe Demir için vücut sıcaklığı (38.5 °C) yükseldi. Sorumlu hekime haber verilip soğuk uygulama başlatılmalıdır.',
                    'created_at' => '12 dakika önce'
                ],
                [
                    'id' => 302,
                    'patient_id' => 1,
                    'patient_name' => 'Ahmet Yılmaz (Oda 101)',
                    'alert_type' => 'medication_time',
                    'severity' => 'high_risk',
                    'severity_label' => 'İlaç Zamanı',
                    'title' => '💉 İLAÇ UYGULAMA & SERUM ZAMANI',
                    'message' => 'Oda 101 - Ahmet Yılmaz IV Serum Tedavisi uygulama saati gelmiştir. Hastanın bileklik doğrulamasını yapınız.',
                    'created_at' => '25 dakika önce'
                ],
                [
                    'id' => 303,
                    'patient_id' => 3,
                    'patient_name' => 'Mehmet Kaya (Oda 202)',
                    'alert_type' => 'fall_risk_assessment',
                    'severity' => 'warning',
                    'severity_label' => 'Düşme Riski',
                    'title' => '⚠️ DÜŞME RİSKİ EVALÜASYONU',
                    'message' => 'Oda 202 - Mehmet Kaya (KOAH hastası) için yatak kenarlıkları kaldırılmalı ve düşme riski formu güncellenmelidir.',
                    'created_at' => '1 saat önce'
                ]
            ];
        }
        else {
            // 3. DOKTOR VE DİĞER ROLLER
            $allAlerts = [
                [
                    'id' => 101,
                    'physician_name' => 'Dr. Mehmet Öz',
                    'patient_id' => 1,
                    'patient_name' => 'Ahmet Yılmaz',
                    'alert_type' => 'critical_lab_result',
                    'severity' => 'critical',
                    'severity_label' => 'Kritik',
                    'title' => '🚨 KRİTİK LABORATUVAR SONUCU',
                    'message' => 'Hasta Ahmet Yılmaz LDL Kolesterol değeri (142 mg/dL) ve BNP Peptit değeri (450 pg/mL) kritik üst sınırın üzerindedir.',
                    'created_at' => '10 dakika önce'
                ],
                [
                    'id' => 102,
                    'physician_name' => 'Dr. Mehmet Öz',
                    'patient_id' => 1,
                    'patient_name' => 'Ahmet Yılmaz',
                    'alert_type' => 'allergy_drug_warning',
                    'severity' => 'high_risk',
                    'severity_label' => 'Yüksek Risk',
                    'title' => '⚠️ ALERJİK İLAÇ UYARISI',
                    'message' => 'Hasta Ahmet Yılmaz için Penasilin grubu aktif alerji uyarısı mevcut. İlaç reçete edilirken dikkat ediniz.',
                    'created_at' => '25 dakika önce'
                ],
                [
                    'id' => 103,
                    'physician_name' => 'Op. Dr. Elif Kaya',
                    'patient_id' => 2,
                    'patient_name' => 'Ayşe Demir',
                    'alert_type' => 'pregnancy_drug_contraindication',
                    'severity' => 'high_risk',
                    'severity_label' => 'Yüksek Risk',
                    'title' => '🤰 GEBELİKTE KONTRENDİKE İLAÇ UYARISI',
                    'message' => 'Hasta Ayşe Demir (Gebelik 24. Hafta): Reçete edilmek istenen NSAİİ grubu ilaç gebelikte kontrendikedir.',
                    'created_at' => '40 dakika önce'
                ],
                [
                    'id' => 104,
                    'physician_name' => 'Dr. Mehmet Öz',
                    'patient_id' => 1,
                    'patient_name' => 'Ahmet Yılmaz',
                    'alert_type' => 'drug_interaction',
                    'severity' => 'warning',
                    'severity_label' => 'Dikkat',
                    'title' => '⚡ İLAÇ-İLAÇ ETKİLEŞİM UYARISI',
                    'message' => 'Hastanın aktif kullandığı Candesartan 16mg ile yeni eklenmek istenen Potasyum tutucu ilaç etkileşim riski taşımaktadır.',
                    'created_at' => '1 saat önce'
                ],
                [
                    'id' => 106,
                    'physician_name' => 'Dr. Mehmet Öz',
                    'patient_id' => 1,
                    'patient_name' => 'Ahmet Yılmaz',
                    'alert_type' => 'expired_followup',
                    'severity' => 'reminder',
                    'severity_label' => 'Hatırlatma',
                    'title' => '🔔 KONTROL TARİHİ HATIRLATMASI',
                    'message' => 'Hastanın 15 gün önceki kardiyoloji rutin poliklinik kontrol randevu süresi dolmuştur.',
                    'created_at' => '3 saat önce'
                ]
            ];
        }

        // Dinamik Eklenen Bildirimleri Oturumdan Çek ve Listeye Ekle
        $dynamicNotifications = session('dynamic_notifications', []);
        $readIds = session('read_notification_ids', []);

        if (!empty($dynamicNotifications)) {
            $allAlerts = array_merge($dynamicNotifications, $allAlerts);
        }

        // Okundu durumlarını ekle
        foreach ($allAlerts as &$alert) {
            $alertId = $alert['id'] ?? 0;
            $alert['is_read'] = in_array($alertId, $readIds);
        }
        unset($alert);

        // Doktor rolü veya doktor kullanıcısı ise sadece o doktorun kendi hastalarının bildirimlerini filtrele
        if ($role === 'physician' || str_contains($userName, 'dr') || str_contains($userName, 'doktor')) {
            $filtered = array_values(array_filter($allAlerts, function ($alert) use ($patientId, $userName) {
                // Spesifik hasta ID aranıyorsa hastaya göre daralt
                if ($patientId > 0) {
                    return isset($alert['patient_id']) && $alert['patient_id'] == $patientId;
                }
                // Başka doktorların hastalarına ait bildirimleri kesin olarak gizle
                if (str_contains($userName, 'elif')) {
                    return isset($alert['physician_name']) && $alert['physician_name'] === 'Op. Dr. Elif Kaya';
                }
                // Varsayılan giriş yapan hekim (Dr. Sude Hekim / Dr. Mehmet Öz)
                return !isset($alert['physician_name']) || $alert['physician_name'] !== 'Op. Dr. Elif Kaya';
            }));
            return $filtered;
        }

        return $allAlerts;
    }

    /**
     * Okunmamış bildirim sayısını döner
     */
    public function getUnreadCount(int $patientId = 0, $user = null): int
    {
        $alerts = $this->getActiveClinicalAlerts($patientId, $user);
        return count(array_filter($alerts, fn($a) => empty($a['is_read'])));
    }

    /**
     * Bildirim istatistiklerini hesaplar
     */
    public function getNotificationStats(int $patientId = 0, $user = null): array
    {
        $alerts = $this->getActiveClinicalAlerts($patientId, $user);
        $unreadAlerts = array_filter($alerts, fn($a) => empty($a['is_read']));

        return [
            'total' => count($alerts),
            'unread' => count($unreadAlerts),
            'critical' => count(array_filter($alerts, fn($a) => ($a['severity'] ?? '') === 'critical')),
            'high_risk' => count(array_filter($alerts, fn($a) => ($a['severity'] ?? '') === 'high_risk')),
            'warning' => count(array_filter($alerts, fn($a) => ($a['severity'] ?? '') === 'warning')),
            'reminder' => count(array_filter($alerts, fn($a) => in_array($a['severity'] ?? '', ['reminder', 'info']))),
        ];
    }

    /**
     * Dinamik Yeni Bildirim Ekleme (Örn: Hastaya Teşhis Verildiğinde)
     */
    public function addNotification(array $notification): void
    {
        $dynamic = session('dynamic_notifications', []);
        if (!isset($notification['id'])) {
            $notification['id'] = time() . rand(100, 999);
        }
        if (!isset($notification['created_at'])) {
            $notification['created_at'] = 'Şimdi';
        }
        $notification['is_read'] = false;

        array_unshift($dynamic, $notification);
        session(['dynamic_notifications' => $dynamic]);
    }

    /**
     * Bildirimi Okundu İşaretle
     */
    public function markAsRead($alertId): void
    {
        $readIds = session('read_notification_ids', []);
        if (!in_array($alertId, $readIds)) {
            $readIds[] = $alertId;
            session(['read_notification_ids' => $readIds]);
        }
    }

    /**
     * Tüm Bildirimleri Okundu İşaretle
     */
    public function markAllAsRead($user = null): void
    {
        $alerts = $this->getActiveClinicalAlerts(0, $user);
        $readIds = session('read_notification_ids', []);
        foreach ($alerts as $a) {
            if (isset($a['id']) && !in_array($a['id'], $readIds)) {
                $readIds[] = $a['id'];
            }
        }
        session(['read_notification_ids' => $readIds]);
    }
}
