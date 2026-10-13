<?php

namespace App\Modules\ArtificialIntelligence\Services;

class ClinicalProtocolService
{
    /**
     * Hastalık ve Klinik Protokol Motoru (Şartname Bölüm 27)
     * Tanı seçildiğinde rehber ve protokol önerilerini hekime karar desteği olarak sunar.
     */
    protected Icd10CatalogService $icd10CatalogService;

    public function __construct(Icd10CatalogService $icd10CatalogService)
    {
        $this->icd10CatalogService = $icd10CatalogService;
    }

    /**
     * Hastalık ve Klinik Protokol Motoru (Şartname Bölüm 27)
     * Tanı seçildiğinde rehber ve protokol önerilerini hekime karar desteği olarak sunar.
     */
    public function getProtocolForDiagnosis(string $icdCode): array
    {
        $officialEntry = $this->icd10CatalogService->getByCode($icdCode);

        $protocols = [
            'I10' => [
                'disease_name' => $officialEntry['description'] ?? 'Esansiyel (Primer) Hipertansiyon',
                'icd_code' => 'I10',
                'specialty' => 'Kardiyoloji / Dahiliye',
                'symptoms' => ['Baş ağrısı', 'Ense sertliği', 'Çarpıntı', 'Nefes darlığı'],
                'risk_factors' => ['Yüksek tuz tüketimi', 'Obezite', 'Sedanter yaşam', 'Aile öyküsü'],
                'evaluation_fields' => ['Kan Basıncı Ölçümü', 'EKG', 'Böbrek Fonksiyon Testleri', 'Lipid Paneli'],
                'recommended_tests' => ['Kreatinin', 'BUN', 'Sodyum', 'Potasyum', 'LDL Kolesterol', 'Ekokardiyografi'],
                'recommended_drug_groups' => ['ACE İnhibitörleri', 'ARB Grubu', 'Tiyazid Diüretikler', 'Kalsiyum Kanal Blokörleri'],
                'contraindications' => ['Bilateral böbrek arteri darlığında ACE inhibitörü kullanımı kontrendikedir.'],
                'follow_up_recommendation' => 'Tedavi başlangıcında 15 günde bir, regüle olduktan sonra 3 ayda bir kontrol.',
                'guideline_source' => 'T.C. Sağlık Bakanlığı Kardiyoloji Hipertansiyon Uzlaşı Kılavuzu 2026',
                'guideline_version' => 'v2.4',
                'disclaimer' => 'T.C. Sağlık Bakanlığı ICD-10 Kataloğu verilerine ve sisteme tanımlanmış klinik protokole göre aşağıdaki değerlendirme başlıkları gözden geçirilebilir. Nihai karar sorumlu hekime aittir.'
            ],
            'G47' => [
                'disease_name' => $officialEntry['description'] ?? 'İnsomnia (Uykuya Dalma Ve Sürdürme Bozukluğu)',
                'icd_code' => 'G47.0',
                'specialty' => 'Nöroloji / Psikiyatri',
                'symptoms' => ['Gece uyuyamama', 'Uykuya dalmakta zorlanma', 'Gece sık uyanma', 'Gündüz yorgunluk & konsantrasyon kaybı'],
                'risk_factors' => ['Psikososyal stres', 'Düzensiz uyku hijyeni', 'Anksiyete', 'Kafein & Alkol kullanımı'],
                'evaluation_fields' => ['Uyku Günlüğü Analizi', 'Uyku Hijyeni Değerlendirmesi', 'Anksiyete/Depresyon Ölçeği (GAD-7/PHQ-9)'],
                'recommended_tests' => ['TSH (Tiroid Fonksiyonu)', 'B12 & D Vitamını Seviyesi', 'Gerekirse Polisomnografi (Uyku Testi)'],
                'recommended_drug_groups' => ['Bitkisel Anksiyolitikler / Sedatifler', 'Sedatif Antihistaminikler', 'Kısa Etkili Hipnotikler (Gerekirse)'],
                'contraindications' => ['Ağır Obstrüktif Uyku Apnesi (OSAS) varlığında derin sedatifler kontrendikedir.'],
                'follow_up_recommendation' => 'Uyku hijyeni eğitimi sonrası 2-4 hafta içinde poliklinik kontrolü.',
                'guideline_source' => 'T.C. Sağlık Bakanlığı Klinik Nöroloji & Uyku Bozuklukları Rehberi 2026',
                'guideline_version' => 'v2.4',
                'disclaimer' => 'T.C. Sağlık Bakanlığı ICD-10 Kataloğu verilerine göre aşağıdaki değerlendirme başlıkları gözden geçirilebilir. Nihai karar sorumlu hekime aittir.'
            ],
            'E66' => [
                'disease_name' => $officialEntry['description'] ?? 'Obezite (Aşırı Kilo & Vücut Kitle İndeksi > 30 kg/m²)',
                'icd_code' => 'E66.9',
                'specialty' => 'Endokrinoloji / Dahiliye / Beslenme & Diyet',
                'symptoms' => ['Kilo verememe', 'Nefes darlığı (Efor dispnesi)', 'Eklemlerde ağrı', 'Horlama & Yorgunluk'],
                'risk_factors' => ['Yüksek kalori alımı', 'Sedanter yaşam', 'İnsülin direnci', 'Genetik yatkınlık'],
                'evaluation_fields' => ['Vücut Kitle İndeksi (VKİ) Hesaplaması', 'Bel Çevresi Ölçümü', 'Metabolik Sendrom Taraması'],
                'recommended_tests' => ['Açlık Kan Şekeri & HbA1c', 'Açlık İnsülin Seviyesi (HOMA-IR)', 'Lipid Paneli (Trigliserit, HDL, LDL)', 'Alt-Ast Tiroid Fonksiyonları'],
                'recommended_drug_groups' => ['Lipaz İnhibitörleri (Orlistat)', 'GLP-1 Reseptör Agonistleri (Liraglutid)', 'Metabolizma & İnsülin Düzenleyiciler'],
                'contraindications' => ['Kronik malabsorpsiyon sendromu ve kolestaz durumunda Orlistat kullanımı kontrendikedir.'],
                'follow_up_recommendation' => 'Diyetisyen ve Endokrinoloji takibi ile ayda 1 kilo & VKİ kontrolü.',
                'guideline_source' => 'T.C. Sağlık Bakanlığı Endokrinoloji Obezite Tedavi Kılavuzu 2026',
                'guideline_version' => 'v2.4',
                'disclaimer' => 'T.C. Sağlık Bakanlığı ICD-10 Kataloğu verilerine göre aşağıdaki değerlendirme başlıkları gözden geçirilebilir. Nihai karar sorumlu hekime aittir.'
            ],
            'F50' => [
                'disease_name' => $officialEntry['description'] ?? 'Anoreksiya Nervoza (Aşırı Zayıflık & Yeme Bozukluğu)',
                'icd_code' => 'F50.0',
                'specialty' => 'Psikiyatri / Beslenme & Diyet / Dahiliye',
                'symptoms' => ['Kilo almaktan aşırı korku', 'Şiddetli kilo kaybı', 'Yemek yemeyi reddetme', 'Beden algısında bozulma'],
                'risk_factors' => ['Mükemmeliyetçi kişilik', 'Ergenlik dönemi', 'Sosyo-kültürel baskılar', 'Ailevi yatkınlık'],
                'evaluation_fields' => ['Vücut Ağırlığı & VKİ Taraması', 'Kardiyovasküler & Vital Bulgu Takibi', 'Elektrolit Dengesi İncelemesi'],
                'recommended_tests' => ['Elektrolit Paneli (Potasyum, Sodyum, Magnezyum)', 'EKG (QTc Mesafesi Ölçümü)', 'Tam Kan Sayımı', 'Karaciğer & Böbrek Fonksiyonları'],
                'recommended_drug_groups' => ['SSRI Grubu Antidepresanlar (Anksiyete & Takıntı İçin)', 'İştah Uyarıcılar (Siproheptadin)', 'Tıbbi Beslenme & Protein Destekleri'],
                'contraindications' => ['Ağır bradikardi ve QTc uzamasında kardiyotoksik psikoaktif ilaçlar kontrendikedir.'],
                'follow_up_recommendation' => 'Multidisipliner Psikiyatri-Diyetisyen ekibi ile haftalık kilo takibi.',
                'guideline_source' => 'T.C. Sağlık Bakanlığı Psikiyatri Yeme Bozuklukları Klinik Protokolü 2026',
                'guideline_version' => 'v2.4',
                'disclaimer' => 'T.C. Sağlık Bakanlığı ICD-10 Kataloğu verilerine göre aşağıdaki değerlendirme başlıkları gözden geçirilebilir. Nihai karar sorumlu hekime aittir.'
            ],
            'J06' => [
                'disease_name' => $officialEntry['description'] ?? 'Akut Üst Solunum Yolu Enfeksiyonu (ÜSYE)',
                'icd_code' => 'J06',
                'specialty' => 'KBB / Enfeksiyon / Dahiliye',
                'symptoms' => ['Boğaz ağrısı', 'Ateş', 'Halsizlik', 'Burun akıntısı'],
                'risk_factors' => ['Mevsimsel salgınlar', 'Bağışıklık düşüklüğü'],
                'evaluation_fields' => ['Boğaz Muayenesi', 'Ateş Takibi', 'Servikal Lenf Nodu Muayenesi'],
                'recommended_tests' => ['Tam Kan Sayımı (Hemogram)', 'CRP'],
                'recommended_drug_groups' => ['Analjezik / Antipiretik', 'Deformatuar Sprey', 'Semptomatik Tedavi'],
                'contraindications' => ['Viral vakalarda gereksiz antibiyotik kullanımından kaçınılmalıdır.'],
                'follow_up_recommendation' => 'Şikayetlerin 5 günü aşması durumunda yeniden değerlendirme.',
                'guideline_source' => 'T.C. Sağlık Bakanlığı Akılcı İlaç ve Klinik Tanı Kılavuzu',
                'guideline_version' => 'v1.8',
                'disclaimer' => 'T.C. Sağlık Bakanlığı ICD-10 Kataloğu verilerine ve sisteme tanımlanmış klinik protokole göre aşağıdaki değerlendirme başlıkları gözden geçirilebilir. Nihai karar sorumlu hekime aittir.'
            ],
            'F84' => [
                'disease_name' => $officialEntry['description'] ?? 'Çocukluk Otizmi (Otizm Spektrum Bozukluğu)',
                'icd_code' => 'F84.0',
                'specialty' => 'Çocuk Ruh Sağlığı ve Hastalıkları (Çocuk Psikiyatrisi) / Pediatrik Nöroloji',
                'symptoms' => ['İnsanların gözünün içine bakamama / Göz teması eksikliği', 'Çok sessiz sakin olma veya adına tepki vermeme', 'Akran ilişkisi kuramama & Sosyal etkileşim eksikliği', 'Kendi etrafında dönme / Tekrarlayan hareketler', 'Dil ve konuşma gelişiminde gecikme veya gerileme'],
                'risk_factors' => ['Genetik yatkınlık & Aile öyküsü', 'Erkek cinsiyet', 'İleri ebeveyn yaşı'],
                'evaluation_fields' => ['M-CHAT-R/F (Erken Çocukluk Dönemi Otizm Tarama Ölçeri)', 'Gelişimsel Değerlendirme (CARS / Denver II)', 'Çocuk Psikiyatrisi Klinik Muayenesi'],
                'recommended_tests' => ['İşitme Testi (BAER / BERA - İşitme Kaybı Ekarte Edilmeli)', 'Genetik Paneli (Fragil X & Mikrodizilim)', 'Pediatrik Nöroloji Konsültasyonu'],
                'recommended_drug_groups' => ['Özel Eğitim ve Erken Müdahale Programı', 'Dil ve Konuşma Terapisi', 'Davranışsal Terapi'],
                'contraindications' => ['Tanı doğrulanmadan önce ilaç tedavisi verilmemelidir. Temel tedavi özel eğitimdir.'],
                'follow_up_recommendation' => 'Çocuk psikiyatristi ve özel eğitim uzmanı takibinde 3 ayda bir gelişimsel değerlendirme.',
                'guideline_source' => 'T.C. Sağlık Bakanlığı Otizm Spektrum Bozukluğu Erken Tanı ve Müdahale Kılavuzu 2026',
                'guideline_version' => 'v2026.1',
                'disclaimer' => 'T.C. Sağlık Bakanlığı ICD-10 Kataloğu verilerine ve sisteme tanımlanmış klinik protokole göre aşağıdaki değerlendirme başlıkları gözden geçirilebilir. Nihai karar sorumlu hekime aittir.'
            ],
            'J21' => [
                'disease_name' => $officialEntry['description'] ?? 'Akut Bronşiyolit (Bebeklerde Hırıltı, Nefes Darlığı & Siyanoz)',
                'icd_code' => 'J21.9',
                'specialty' => 'Çocuk Sağlığı ve Hastalıkları (Pediatri) / Çocuk Göğüs Hastalıkları',
                'symptoms' => ['Bebekte nefes darlığı ve zorlu solunum', 'Dudaklarda ve tırnaklarda morarma (Siyanoz)', 'Hırıltılı solunum (Wheezing) & Burun kanadı solunumu', 'Göğüs kafesinde interkostal çekilmeler', 'Beslenme reddi ve emememe'],
                'risk_factors' => ['RSV (Respiratuvar Sinsityal Virüs) enfeksiyonu', 'Prematüre doğum öyküsü', 'Ev içi sigara dumanı maruziyeti'],
                'evaluation_fields' => ['SpO2 (Pulse Oksimetre Takibi - Morarma Derecesi)', 'Solunum Sayısı (Takipne Kontrolü)', 'Akciğer Oskültasyonu (Raller ve Wheezing)'],
                'recommended_tests' => ['SpO2 Ölçümü', 'RSV / Hızlı Viral Solunum Paneli', 'Kan Gazı Değerlendirmesi'],
                'recommended_drug_groups' => ['Nemlendirilmiş Oksijen Desteği', 'Serum Fizyolojik Nazal Aspirasyon', 'Nebülizasyon (Serum Fizyolojik %3)', 'Sıvı Hidrasyon Desteği'],
                'contraindications' => ['Bebek morarması ve nefes zorluğunda yetişkin kalp krizi (Akut MI) ile karıştırılmamalıdır! Viral bronşiyolitte rutin antibiyotik verilmemelidir.'],
                'follow_up_recommendation' => 'SpO2 <%92 ise derhal yatarak oksijen tedavisi. Taburculuk sonrası 48 saat içinde çocuk hekimi kontrolü.',
                'guideline_source' => 'T.C. Sağlık Bakanlığı Pediatrik Akut Solunum Hastalıkları Tanı Kılavuzu 2026',
                'guideline_version' => 'v2026.1',
                'disclaimer' => 'T.C. Sağlık Bakanlığı ICD-10 Kataloğu verilerine ve sisteme tanımlanmış klinik protokole göre aşağıdaki değerlendirme başlıkları gözden geçirilebilir. Nihai karar sorumlu hekime aittir.'
            ],
            'F41' => [
                'disease_name' => $officialEntry['description'] ?? 'Panik Bozukluk [Epizodik Paroksizmal Anksiyete] (Panik Atak)',
                'icd_code' => 'F41.0',
                'specialty' => 'Psikiyatri / Nöroloji / Acil Tıp',
                'symptoms' => ['Aniden başlayan göğüste sıkışma ve şiddetli çarpıntı', 'Nefes alamama / Boğulma hissi', 'Ellerde titreme ve uyuşma/karıncalanma (Parestezi)', 'Kontrolü kaybetme, çıldırma veya ölüm korkusu', 'Derealizasyon / Depersonalizasyon (Gerçek dışılık hissi)'],
                'risk_factors' => ['Genetik yatkınlık / Aile anksiyete öyküsü', 'Yoğun psikososyal stres & Travma', 'Mitolojik/Bilişsel felaketleştirme eğilimi'],
                'evaluation_fields' => ['EKG & Kardiyolojik Ekarte (Acil troponin & EKG ile organik koroner iskemi ekarte edilmelidir)', 'Tiroit Fonksiyon Testleri (TSH - Hipertiroidi ekarte)', 'Kan Şekeri (Hipoglisemi ekarte)', 'Beck Anksiyete Ölçeği Değerlendirmesi'],
                'recommended_tests' => ['EKG (12 Derivasyonlu)', 'Troponin / CK-MB', 'Hemogram & TSH', 'Açlık Kan Şekeri'],
                'recommended_drug_groups' => ['SSRI (Sertralin / Sitalopram / Paroksetin)', 'SNRI (Venlafaksin)', 'Kısa Süreli Anksiyolitik / Sedatif (Alprazolam / Diazepam)', 'Bilişsel Davranışçı Terapi (BDT)'],
                'contraindications' => ['Organik organik koroner iskemi (Akut MI) EKG ve kardiyolojik muayene ile tamamen ekarte edilmeden acil taburculuğu yapılmamalıdır. Psikotrop ilaçlar kontrolsüz kesilmemelidir.'],
                'follow_up_recommendation' => 'Psikiyatri poliklinik kontrolü ve Bilişsel Davranışçı Terapi (BDT) randevusu (15 günde bir kontrol).',
                'guideline_source' => 'T.C. Sağlık Bakanlığı Ruh Sağlığı ve Panik Bozukluk Klinik Uygulama Kılavuzu 2026',
                'guideline_version' => 'v2026.1',
                'disclaimer' => 'T.C. Sağlık Bakanlığı ICD-10 Kataloğu verilerine ve sisteme tanımlanmış klinik protokole göre aşağıdaki değerlendirme başlıkları gözden geçirilebilir. Nihai karar sorumlu hekime aittir.'
            ],
            'K21' => [
                'disease_name' => $officialEntry['description'] ?? 'Gastroözofageal Reflü Hastalığı (GÖRH / Reflü)',
                'icd_code' => 'K21.9',
                'specialty' => 'Gastroenteroloji / İç Hastalıkları (Dahiliye)',
                'symptoms' => ['Göğüs arkasında (retrosternal) yukarı doğru yayılan yanma (Pyrosis)', 'Ağza acı/ekşi su gelmesi (Asit Regürjitasyonu)', 'Ağır ve yağlı yemeklerden sonra şikayetlerde artış', 'Gece düz yatarken artan kronik öksürük & Ses kısıklığı', 'Boğazda takılma / yumru hissi (Globus)'],
                'risk_factors' => ['Obezite & Karın içi basınç artışı', 'Geç saatte beslenme & Ağır/yağlı diyet', 'Sigara, alkol ve kafein tüketimi', 'Hiatal Herni (Mide Fıtığı)'],
                'evaluation_fields' => ['Endoskopi (Üst GİS Özofagogastroduodenoskopi - Özofajit Derecelendirmesi)', '24 Saatlik Özofagus pH-Empedans Monitörizasyonu', 'Helicobacter Pylori Tarama (Urease / Dışkı Antijeni)', 'Kardiyolojik Ekarte (Göğüs yanmasının koroner kaynaklı olmadığının teyidi)'],
                'recommended_tests' => ['Üst GİS Endoskopisi', '24 Saatlik pH Monitörizasyonu', 'H. Pylori Dışkı Antijen Testi', 'EKG (Ağrı Ayırımı İçin)'],
                'recommended_drug_groups' => ['Proton Pompası İnhibitörü (PPI: Esomeprazol / Lansoprazol 40mg)', 'Aljinat + Antasit (Gaviscon Double Action)', 'H2 Reseptör Antagonisti (Famotidin)', 'Yaşam Tarzı & Diyet Düzenlemesi (Yatak başını 15cm yükseltme, son yemekten 3 saat sonra yatma)'],
                'contraindications' => ['Reflüye bağlı kronik öksürük viral soğuk algınlığı (ÜSYE/Grip) sanılarak antibiyotik verilmemelidir. Göğüs yanmasında koroner kalp hastalığı ekarte edilmeden göz ardı edilmemelidir.'],
                'follow_up_recommendation' => '8 haftalık PPI tedavisi sonrası Gastroenteroloji poliklinik kontrolü.',
                'guideline_source' => 'T.C. Sağlık Bakanlığı Gastroenteroloji Klinik Uygulama Rehberi 2026',
                'guideline_version' => 'v2026.1',
                'disclaimer' => 'T.C. Sağlık Bakanlığı ICD-10 Kataloğu verilerine ve sisteme tanımlanmış klinik protokole göre aşağıdaki değerlendirme başlıkları gözden geçirilebilir. Nihai karar sorumlu hekime aittir.'
            ],
            'H81' => [
                'disease_name' => $officialEntry['description'] ?? 'Benign Paroksizmal Pozisyonel Vertigo (BPPV / Kristal Kayması)',
                'icd_code' => 'H81.1',
                'specialty' => 'Kulak Burun Boğaz Hastalıkları (KBB) / Nöroloji',
                'symptoms' => ['Yatakta dönerken veya başı yukarı kaldırırken aniden başlayan şiddetli baş dönmesi', 'Etrafın dönmesi hissi (İllüzyonel Rotasyonel Vertigo)', 'Baş dönmesi sırasında gözlerde ritmik sıçrama (Pozisyonel Nistagmus)', 'Hareketle tetiklenen şiddetli bulantı ve dengesizlik', 'İşitme kaybı veya çınlama bulunmaması (BPPV ayırıcı bulgusu)'],
                'risk_factors' => ['Kafa travması öyküsü', 'İç kulak otokonilerinin (kristallerin) semisirküler kanallara dökülmesi', 'İleri yaş & Uzun süreli yatak istirahati'],
                'evaluation_fields' => ['Dix-Hallpike Manevrası (Posterior semisirküler kanal BPPV tespiti)', 'Frenzel Gözlüğü ile Pozisyonel Nistagmus Muayenesi', 'Kranial MR / BT (Nörolojik santral vertigo & Serebellar inme ekarte edilmeli)', 'Otoskopik Kulak Muayenesi'],
                'recommended_tests' => ['Dix-Hallpike Testi', 'Kranial MR (Santral Vertigo Ekarte)', 'Vestibüler Otonomik Testler'],
                'recommended_drug_groups' => ['Epley Manevrası (Kanalit Repozisyon Manevrası - Temel Tedavi)', 'Vestibüler Süpresan / Betahistin (Betaserc 24mg)', 'Antiemetik / Dimenhidrinat (Dramamine 50mg)', 'Brandt-Daroff Ev Egzersizleri'],
                'contraindications' => ['BPPV\'de asıl tedavi Epley manevrasıdır; tek başına ilaç tedavisi yeterli değildir. Pelvik Enfeksiyon (PID - N73.9) veya basit baş ağrısı ile karıştırılmamalıdır.'],
                'follow_up_recommendation' => 'Epley manevrası sonrası 7. günde KBB kontrolü.',
                'guideline_source' => 'T.C. Sağlık Bakanlığı KBB ve Vestibüler Bozukluklar Klinik Kılavuzu 2026',
                'guideline_version' => 'v2026.1',
                'disclaimer' => 'T.C. Sağlık Bakanlığı ICD-10 Kataloğu verilerine ve sisteme tanımlanmış klinik protokole göre aşağıdaki değerlendirme başlıkları gözden geçirilebilir. Nihai karar sorumlu hekime aittir.'
            ],
            'A09' => [
                'disease_name' => $officialEntry['description'] ?? 'İnfeksiyöz Gastroenterit ve Kolit (Akut İnfeksiyöz İshal)',
                'icd_code' => 'A09.9',
                'specialty' => 'Enfeksiyon Hastalıkları ve Klinik Mikrobiyoloji / İç Hastalıkları',
                'symptoms' => ['Akut başlayan sulu ishal (Günde 5-10 kez)', 'Karın bölgesinde kramp tarzında ağrılar ve gaz', 'Bulantı, kusma ve iştahsızlık', 'Hafif veya yüksek ateş (Enfeksiyonel sistemik bulgu)', 'Sıvı ve elektrolit kaybına bağlı ağız kuruluğu & Halsizlik'],
                'risk_factors' => ['Kontamine gıda veya su tüketimi (Besin zehirlenmesi)', 'Hijyen eksikliği & Salgın öyküsü', 'Bağışıklık baskılanması'],
                'evaluation_fields' => ['Gaita Mikroskopisi (Parazit & Bakteri arama)', 'Gaita Kültürü (Salmonella, Shigella, Campylobacter tespiti)', 'Gaita Viral Paneli (Rotavirüs / Adenovirüs hızlı antijen)', 'Serum Elektrolitleri & Kreatinin (Dehidrasyon & Böbrek Fonksiyon Kontrolü)'],
                'recommended_tests' => ['Gaita Mikroskopisi & Kültürü', 'Serum Na, K, Cl & Üre/Kreatinin', 'Tam Kan Sayımı (WBC Kontrolü)'],
                'recommended_drug_groups' => ['Oral Rehidrasyon Sıvısı (ORS / Ge-Oral - Temel Tedavi)', 'Probiyotik (Reflor / Saccharomyces boulardii)', 'İntestinal Antiseptik (Ercefuryl 200mg)', 'Spazmolitik (Buscopan 10mg)', 'İntravenöz Sıvı Desteği (Dehidrasyon Şiddetliyse)'],
                'contraindications' => ['Akut infeksiyöz gastroenteritte rutin anti-motilite ilaçları (Loperamid vb.) patojeni içeride hapsedeceği için önerilmez. İronik olarak kronik İBS (K58.0) ile karıştırılmamalıdır.'],
                'follow_up_recommendation' => 'Sıvı takibi ve 48 saat içinde şikayetlerin gerilememesi durumunda Enfeksiyon Hastalıkları kontrolü.',
                'guideline_source' => 'T.C. Sağlık Bakanlığı Bulaşıcı Hastalıklar ve Akut Gastroenterit Rehberi 2026',
                'guideline_version' => 'v2026.1',
                'disclaimer' => 'T.C. Sağlık Bakanlığı ICD-10 Kataloğu verilerine ve sisteme tanımlanmış klinik protokole göre aşağıdaki değerlendirme başlıkları gözden geçirilebilir. Nihai karar sorumlu hekime aittir.'
            ],
            'M75' => [
                'disease_name' => $officialEntry['description'] ?? 'Rotatör Manşet Sendromu (Rotatör Manşet Tendiniti / Yırtığı & Donuk Omuz)',
                'icd_code' => 'M75.1',
                'specialty' => 'Fiziksel Tıp ve Rehabilitasyon (FTR) / Ortopedi ve Travmatoloji',
                'symptoms' => ['Omzu abduksiyona (yukarı) kaldırırken ve arkaya götürürken belirginleşen ağrı', 'Gece ağrıyan tarafın üzerine yatamama (Gece ağrısı)', 'Omuz eklem hareket açıklığında (ROM) belirgin kısıtlılık', 'Kolu kaldırmada kas güçsüzlüğü ve takılma hissi'],
                'risk_factors' => ['Tepeüstü (overhead) kol hareketleri yapma öyküsü', 'İleri yaş & Manşet tendon vaskülarite azalması', 'Diyabet (Donuk omuz için risk faktörü)'],
                'evaluation_fields' => ['Omuz Yumuşak Doku Ultrasonografisi (USG - Tendon Yırtığı & Subakromiyal Bursit Kontrolü)', 'Omuz MRG (Rotatör Manşet Yırtık Derecesi & Labrum Muayenesi)', 'Neer & Hawkins Sıkışma (Impingement) Testleri', 'Aktif & Pasif Eklem Hareket Açıklığı Değerlendirmesi'],
                'recommended_tests' => ['Omuz USG', 'Omuz MRG', 'Omuz Direkt Grafisi (AC X-Ray)'],
                'recommended_drug_groups' => ['NSAİİ (Naproksen Sodyum 550mg / Diklofenak)', 'Kas Gevşetici (Tiokolşikozit / Tizanidin)', 'Fizik Tedavi ve Rehabilitasyon Programı (TENS, Yüzeyel Isı, Egzersizler)', 'Subakromiyal Enjeksiyon (Şiddetli Ağrıda Steroid/PRP)'],
                'contraindications' => ['Omuz hareket kısıtlılığı ve kol ağrısı iç kulak Vertigosu (H81.1) ile kesinlikle karıştırılmamalıdır! Erken evrede hareketsizlik omuz sertliğini (Donuk Omuz) artıracağı için kontrolsüz immobilizasyondan kaçınılmalıdır.'],
                'follow_up_recommendation' => '4-6 haftalık FTR programı sonrası Fiziksel Tıp ve Rehabilitasyon poliklinik kontrolü.',
                'guideline_source' => 'T.C. Sağlık Bakanlığı Fiziksel Tıp ve Rehabilitasyon Klinik Uygulama Kılavuzu 2026',
                'guideline_version' => 'v2026.1',
                'disclaimer' => 'T.C. Sağlık Bakanlığı ICD-10 Kataloğu verilerine ve sisteme tanımlanmış klinik protokole göre aşağıdaki değerlendirme başlıkları gözden geçirilebilir. Nihai karar sorumlu hekime aittir.'
            ],
            'B08' => [
                'disease_name' => $officialEntry['description'] ?? 'Enteroviral Veziküler Stomatit (El-Ayak-Ağız Hastalığı / Coxsackievirus)',
                'icd_code' => 'B08.4',
                'specialty' => 'Çocuk Sağlığı ve Hastalıkları (Pediatri) / Çocuk Enfeksiyon Hastalıkları',
                'symptoms' => ['Ağız içinde (dil, yanak içi, damak) küçük ağrılı vesikül ve aft yaraları', 'El ayalarında ve ayak tabanlarında makülopapüler/vesiküler kırmızı döküntüler', 'Subfebril veya 38.5-39°C yüksek ateş', 'Yutma güçlüğüne (odinofaji) bağlı iştahsızlık ve salya akması', 'Halsizlik ve huzursuzluk'],
                'risk_factors' => ['Kreş / Anaokulu gibi toplu çocuk ortamları (Fokal salgınlar)', 'Feko-oral ve damlacık yoluyla bulaş', '5 yaş altı çocukluk çağı duyarlılığı'],
                'evaluation_fields' => ['Pediatrik Ağız İçi ve Cilt Muayenesi (Karakteristik vesiküler döküntü dağılımı)', 'Dehidrasyon Takibi (Turgor-tonus, ıslak bez sayısı, mukozalar)', 'Tam Kan Sayımı & CRP (Bakteriyel süperenfeksiyon ekarte etme)', 'Viral PCR (Atipik/ağır seyreden vakalarda Enterovirus 71 kontrolü)'],
                'recommended_tests' => ['Pediatrik Fizik Muayene', 'Dehidrasyon Değerlendirmesi', 'Serum Elektrolitleri (Şiddetli Dehidrasyonda)'],
                'recommended_drug_groups' => ['Pediatrik Analjezik / Antipiretik (Parasetamol 10-15mg/kg Şurup)', 'Oral Sprey & Aft Yarası Rahatlatıcı (Andorex / Klorheksidin Sprey)', 'Döküntü Rahatlatıcı Losyon (Stilex / Caladryl Jel)', 'Soğuk Yumuşak Diyet & Bol Sıvı (Yoğurt, dondurma, soğuk çorba)'],
                'contraindications' => ['El-Ayak-Ağız Hastalığı spesifik klinik bulgulara (aft + el/ayak döküntüsü) sahiptir; jenerik non-spesifik ateş (R50.9) denilip geçilmemelidir. Çocuklarda ASA (Aspirin) kullanımı Reye Sendromu riski nedeniyle kesinlikle kontrendikedir!'],
                'follow_up_recommendation' => '7-10 gün içinde kendiliğinden geriler; beslenememe ve dehidrasyon gelişirse Pediatri poliklinik kontrolü.',
                'guideline_source' => 'T.C. Sağlık Bakanlığı Pediatrik Enfeksiyon ve Döküntülü Hastalıklar Rehberi 2026',
                'guideline_version' => 'v2026.1',
                'disclaimer' => 'T.C. Sağlık Bakanlığı ICD-10 Kataloğu verilerine ve sisteme tanımlanmış klinik protokole göre aşağıdaki değerlendirme başlıkları gözden geçirilebilir. Nihai karar sorumlu hekime aittir.'
            ]
        ];

        $code = strtoupper(substr(trim($icdCode), 0, 3));
        if (isset($protocols[$code])) {
            return $protocols[$code];
        }

        return [
            'disease_name' => $officialEntry['description'] ?? "T.C. Sağlık Bakanlığı ICD-10 Tanı Protokolü ($icdCode)",
            'icd_code' => $officialEntry['code'] ?? $icdCode,
            'specialty' => 'Genel Tıp / Dahiliye',
            'symptoms' => ['Hastanın beyan ettiği klinik semptomlar ve fizik muayene bulguları'],
            'risk_factors' => ['Detaylı klinik anamnez ve özgeçmiş kontrolü yapılmalıdır.'],
            'evaluation_fields' => ['Vital bulgular (Tansiyon, Nabız, Ateş, SpO2)', 'Fizik muayene'],
            'recommended_tests' => ['Tam Kan Sayımı (Hemogram)', 'Biyokimya Paneli', 'Görüntüleme / EKG'],
            'recommended_drug_groups' => ['Tanıya ve klinik tabloya uygun semptomatik veya etken odaklı tedavi'],
            'contraindications' => ['İlaç alerjisi öyküsü, gebelik ve böbrek/karaciğer fonksiyonları kontrol edilmelidir.'],
            'follow_up_recommendation' => 'Hekim kanaatine göre kontrol randevusu planlanmalıdır.',
            'guideline_source' => 'T.C. Sağlık Bakanlığı Sağlık Bilgi Sistemleri ICD-10 Standart Tanı Kılavuzu',
            'guideline_version' => 'v2026.1',
            'disclaimer' => 'T.C. Sağlık Bakanlığı ICD-10 Kataloğu verilerine ve sisteme tanımlanmış klinik protokole göre aşağıdaki değerlendirme başlıkları gözden geçirilebilir. Nihai karar sorumlu hekime aittir.'
        ];
    }
}
