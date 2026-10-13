# 🚀 Pull Request: Klinik Bildirim Sayacı Optimizasyonu & Yapay Zekâ Lab Analiz Modülü

## 📝 Açıklama
Bu PR, HBYS sistemindeki iki kritik klinik alanı geliştirmektedir:
1. **Klinik Bildirim Okunmamış Sayacı Optimizasyonu:** Bildirimler okundukça sayfa yenilenmeden (reload gerekmeksizin) canlı olarak bildirim rozeti sayısının düşmesi ve arayüzle senkronize olması sağlandı.
2. **Yapay Zekâ Tıbbi Dosya & Lab Analiz Portalı:** Doktor Paneli (`chief_physician.blade.php`) içerisindeki **Lab (LIS)** sekmesine entegre edilen Yapay Zekâ motoru ile hastanın tıbbi lab sonuçları taranmakta; olası mevcut teşhisler, 1-5 yıllık gelecek risk projeksiyonları ve iyileştirme önerileri üretilmektedir.

---

## 🛠️ Yapılan Değişiklikler

### 1. Bildirim Okuma & Sayı Azaltma Sistemi
* **Anlık AJAX Güncellemesi:** Bildirime "Okundu Yap" veya "Tümünü Okundu İşaretle" dendiğinde sayfa yenilenmeden 100ms içerisinde navbar zili üzerindeki sayaç ve portal kartları güncellenmektedir.
* **Backend & Service:** `NotificationService` ve `NotificationController` metotları güncellenerek okundu yanıtlarında güncel `unread_count` ve detaylı istatistik verileri dönüldü.

### 2. Yapay Zekâ Tıbbi Dosya Lab Analizi & Risk Tahmini
* **Sıfır Etki (Zero-Impact) Mimarisi:** Mevcut hiçbir geliştirici koduna dokunulmadan `ArtificialIntelligence` modülü altında bağımsız servis (`LabAnalysisAiService`) ve denetleyici (`LabAnalysisAiController`) geliştirildi.
* **Doktor Paneli Entegrasyonu:** Yalnızca Doktor Paneli -> Hasta Tıbbi Dosyası -> **Lab (LIS)** sekmesine **"🧪 Yapay Zekâ Lab Analizi & Risk Tahmini Göster"** butonu eklendi.
* **3 Boyutlu Yapay Zekâ Analizi:**
  - 🔍 **Mevcut Olası Teşhisler:** ICD-10 kodları, Teşhis Olasılıkları (%88 vb.) ve gerekçeleri.
  - 🔮 **Gelecek Hastalık Riskleri:** Hedef Organ Etkileri, 1-5 Yıllık Risk Zamanlamaları ve Risk Skorları.
  - 🛠️ **Düzeltme & İyileştirme Önerileri:** Medikal İlaç Revizyonu, Beslenme & Yaşam Tarzı, Takip & İleri Tetkik Takvimi.
* **Rapora Aktarma:** Üretilen AI analizi **"📋 Rapor Metnine Aktar"** butonu ile doğrudan doktorun raporda yazdığı metin alanına kopyalanabilmektedir.

---

## 🧪 Doğrulama ve Test
- [x] Bildirim okunduğunda rozet sayacının anında azaldığı test edildi.
- [x] Doktor Paneli Lab sekmesindeki butonla AI analizinin sorunsuz çalıştığı teyit edildi.
- [x] Otomatik testler (`NotificationServiceTest` ve `LabAnalysisAiTest`) çalıştırıldı ve tüm senaryolar (%100) başarıyla geçti (`7 passed, 33 assertions`).
