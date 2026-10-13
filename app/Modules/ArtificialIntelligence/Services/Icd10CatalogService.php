<?php

namespace App\Modules\ArtificialIntelligence\Services;

class Icd10CatalogService
{
    /**
     * T.C. Sağlık Bakanlığı Sağlık Bilgi Sistemleri Genel Müdürlüğü
     * Resmi ICD-10 Tanı Kataloğu Veri Seti
     */
    protected array $catalog = [
        // Kardiyovasküler Hastalıklar (I Serisi)
        ['code' => 'I10', 'description' => 'Esansiyel (Primer) Hipertansiyon'],
        ['code' => 'I11.0', 'description' => 'Hipertansif Kalp Hastalığı, Kalp Yetmezliği (Konjestif) İle Birlikte'],
        ['code' => 'I11.9', 'description' => 'Hipertansif Kalp Hastalığı, Kalp Yetmezliği (Konjestif) Olmaksızın'],
        ['code' => 'I12.0', 'description' => 'Hipertansif Böbrek Hastalığı, Böbrek Yetmezliği İle Birlikte'],
        ['code' => 'I15.0', 'description' => 'Renovasküler Hipertansiyon'],
        ['code' => 'I20.0', 'description' => 'Unstable Angina Pectoris'],
        ['code' => 'I20.9', 'description' => 'Angina Pectoris, Tanımlanmamış'],
        ['code' => 'I21.0', 'description' => 'Ön Duvar Akut Transmural Miyokard Enfarktüsü'],
        ['code' => 'I21.1', 'description' => 'Alt Duvar Akut Transmural Miyokard Enfarktüsü'],
        ['code' => 'I21.2', 'description' => 'Akut Transmural Miyokard Enfarktüsü Diğer Yerlerin'],
        ['code' => 'I21.4', 'description' => 'Akut Subendokardiyal Miyokard Enfarktüsü'],
        ['code' => 'I21.9', 'description' => 'Akut Miyokardiyal Enfarktüs, Tanımlanmamış'],
        ['code' => 'I24.9', 'description' => 'Akut İskemik Kalp Hastalığı, Tanımlanmamış'],
        ['code' => 'I25.0', 'description' => 'Aterosklerotik Kardiyovasküler Hastalık'],
        ['code' => 'I25.1', 'description' => 'Aterosklerotik Kalp Hastalığı'],
        ['code' => 'I25.2', 'description' => 'Eski Miyokard Enfarktüsü'],
        ['code' => 'I25.5', 'description' => 'İskemik Kardiyopati'],
        ['code' => 'I25.9', 'description' => 'Kronik İskemik Kalp Hastalığı, Tanımlanmamış'],
        ['code' => 'I26.0', 'description' => 'Pulmoner Embolizm, Akut Kor Pulmonale İle Birlikte'],
        ['code' => 'I26.9', 'description' => 'Pulmoner Embolizm, Akut Kor Pulmonale Olmaksızın'],
        ['code' => 'I27.0', 'description' => 'Primer Pulmoner Hipertansiyon'],
        ['code' => 'I30.0', 'description' => 'Akut İdiopatik Perikardit, Nonspesifik'],
        ['code' => 'I34.0', 'description' => 'Mitral Kapak Yetmezliği'],
        ['code' => 'I35.0', 'description' => 'Aortik Kapak Stenozu'],
        ['code' => 'I35.1', 'description' => 'Aortik Kapak Yetmezliği'],
        ['code' => 'I42.0', 'description' => 'Dilate Kardiyomiyopati'],
        ['code' => 'I44.0', 'description' => 'Atriyoventriküler Blok, Birinci Derece'],
        ['code' => 'I44.2', 'description' => 'Atriyoventriküler Blok, Komplet'],
        ['code' => 'I47.1', 'description' => 'Supraventriküler Taşikardi'],
        ['code' => 'I47.2', 'description' => 'Ventriküler Taşikardi'],
        ['code' => 'I48', 'description' => 'Atrial Fibrilasyon Ve Flutter'],
        ['code' => 'I50.0', 'description' => 'Konjestif Kalp Yetmezliği'],
        ['code' => 'I50.1', 'description' => 'Sol Ventrikül Yetmezliği'],
        ['code' => 'I50.9', 'description' => 'Kalp Yetmezliği, Tanımlanmamış'],
        ['code' => 'I61.9', 'description' => 'İntraserebral Hemoraji, Tanımlanmamış'],
        ['code' => 'I63.0', 'description' => 'Serebral Enfarktüs, Preserebral Arter Trombozuna Bağlı'],
        ['code' => 'I63.9', 'description' => 'Serebral Enfarktüs, Tanımlanmamış'],
        ['code' => 'I64', 'description' => 'İnme, Hemoraji Veya Enfarktüs Olarak Tanımlanmamış'],
        ['code' => 'I70.0', 'description' => 'Aorta Aterosklerozu'],
        ['code' => 'I70.2', 'description' => 'Ekstremite Arterlerinin Aterosklerozu'],
        ['code' => 'I71.0', 'description' => 'Aorta Diseksiyonu'],
        ['code' => 'I73.0', 'description' => 'Raynaud Sendromu'],
        ['code' => 'I80.0', 'description' => 'Alt Ekstremite Yüzeyel Damarlarının Flebit Ve Tromboflebiti'],
        ['code' => 'I80.2', 'description' => 'Alt Ekstremite Diğer Derin Damarlarının Flebit Ve Tromboflebiti'],
        ['code' => 'I83.9', 'description' => 'Ülser Veya Enflamasyon Olmadan Alt Ekstremitenin Variköz Venleri'],
        ['code' => 'I84.9', 'description' => 'Hemoroidler, Tanımlanmamış Komplikasyonsuz'],

        // Endokrin, Metabolizma ve Beslenme (E Serisi)
        ['code' => 'E01.1', 'description' => 'İyot Eksikliğine Bağlı Multinodüler (Endemik) Guatr'],
        ['code' => 'E03.8', 'description' => 'Hipotiroidizm Tanımlanmış, Diğer'],
        ['code' => 'E03.9', 'description' => 'Hipotiroidizm, Tanımlanmamış'],
        ['code' => 'E04.2', 'description' => 'Toksik Olmayan Multinodüler Guatr'],
        ['code' => 'E05.0', 'description' => 'Tirotoksikoz, Diffüz Guatrlı'],
        ['code' => 'E05.9', 'description' => 'Tirotoksikoz, Tanımlanmamış'],
        ['code' => 'E06.3', 'description' => 'Otoimmün Tiroidit (Hashimoto)'],
        ['code' => 'E10', 'description' => 'İnsülin-Bağımlı Diyabetes Mellitüs (Tip 1)'],
        ['code' => 'E10.7', 'description' => 'İnsülin Bağımlı Diyabetes Mellitüs, Birden Fazla Komplikasyonla Birlikte'],
        ['code' => 'E10.9', 'description' => 'İnsülin Bağımlı Diyabetes Mellitüs, Komplikasyonları Olmayan'],
        ['code' => 'E11', 'description' => 'İnsülin-Bağımlı Olmayan Diyabetes Mellitüs (Tip 2)'],
        ['code' => 'E11.2', 'description' => 'İnsülin Bağımlı Olmayan Diyabetes Mellitüs, Böbrek Komplikasyonuyla Birlikte'],
        ['code' => 'E11.4', 'description' => 'İnsülin Bağımlı Olmayan Diyabetes Mellitüs, Nörolojik Komplikasyonla Birlikte'],
        ['code' => 'E11.5', 'description' => 'İnsülin Bağımlı Olmayan Diyabetes Mellitüs, Periferik Dolaşım Komplikasyonuyla Birlikte'],
        ['code' => 'E11.6', 'description' => 'İnsülin Bağımlı Olmayan Diyabetes Mellitüs, Tanımlanmış Diğer Komplikasyonlarla Birlikte'],
        ['code' => 'E11.9', 'description' => 'İnsülin Bağımlı Olmayan Diyabetes Mellitüs, Komplikasyonları Olmayan'],
        ['code' => 'E13.4', 'description' => 'Diyabetes Mellitüs, Diğer Tanımlanmış, Nörolojik Komplikasyonla Birlikte'],
        ['code' => 'E14.0', 'description' => 'Diyabetes Mellitüs, Tanımlanmamış, Komayla Birlikte'],
        ['code' => 'E16.2', 'description' => 'Hipoglisemi, Tanımlanmamış'],
        ['code' => 'E28.2', 'description' => 'Polikistik Over Sendromu (PKOS)'],
        ['code' => 'E50', 'description' => 'Vitamin A Eksikliği'],
        ['code' => 'E55', 'description' => 'Vitamin D Eksikliği'],
        ['code' => 'E55.9', 'description' => 'Vitamin D Eksikliği, Tanımlanmamış'],
        ['code' => 'E61.1', 'description' => 'Demir Eksikliği'],
        ['code' => 'E66', 'description' => 'Obezite'],
        ['code' => 'E66.9', 'description' => 'Obezite, Tanımlanmamış'],
        ['code' => 'E78.0', 'description' => 'Saf Hiperkolesterolemi'],
        ['code' => 'E78.5', 'description' => 'Hiperlipidemi, Tanımlanmamış'],
        ['code' => 'E83.5', 'description' => 'Kalsiyum Metabolizması Bozuklukları'],
        ['code' => 'E87.5', 'description' => 'Hiperkalemi'],
        ['code' => 'E87.6', 'description' => 'Hipokalemi'],
        ['code' => 'E89.0', 'description' => 'Hipotiroidizm, Girişim Sonrası Gelişen'],

        // Solunum Sistemi Hastalıkları (J Serisi)
        ['code' => 'J00', 'description' => 'Akut Nazofarenjit [Nezle & Soğuk Algınlığı]'],
        ['code' => 'J01.0', 'description' => 'Akut Maksiller Sinüzit'],
        ['code' => 'J01.9', 'description' => 'Akut Sinüzit, Tanımlanmamış'],
        ['code' => 'J02', 'description' => 'Akut Farenjit'],
        ['code' => 'J02.9', 'description' => 'Akut Farenjit, Tanımlanmamış'],
        ['code' => 'J03.9', 'description' => 'Akut Tonsillit, Tanımlanmamış'],
        ['code' => 'J04.0', 'description' => 'Akut Larenjit'],
        ['code' => 'J06.9', 'description' => 'Akut Üst Solunum Yolu Enfeksiyonu (ÜSYE & Soğuk Algınlığı)'],
        ['code' => 'J10.0', 'description' => 'İnfluenza, Pnömoni İle Birlikte, İnfluenza Virüsü Belirlenmiş'],
        ['code' => 'J10.1', 'description' => 'İnfluenza (Virüs Tanımlanmış Grip, Ateş, Kırgınlık & Eklem Ağrıları)'],
        ['code' => 'J11.1', 'description' => 'İnfluenza (Grip & Soğuk Algınlığı, Titreme, Vücut Kırgınlığı & Öksürük)'],
        ['code' => 'J10.8', 'description' => 'İnfluenza; Diğer Belirtiler, İnfluenza Virüsü Belirlenmiş'],
        ['code' => 'J12.9', 'description' => 'Viral Pnömoni, Tanımlanmamış'],
        ['code' => 'J13', 'description' => 'Pnömoni, Streptococcus Pneumoniae\'ye Bağlı'],
        ['code' => 'J15.9', 'description' => 'Bakteriyel Pnömoni, Tanımlanmamış'],
        ['code' => 'J18.0', 'description' => 'Bronkopnömoni, Tanımlanmamış'],
        ['code' => 'J18.9', 'description' => 'Pnömoni, Tanımlanmamış Organizmalar'],
        ['code' => 'J20.9', 'description' => 'Akut Bronşit, Tanımlanmamış'],
        ['code' => 'J21.9', 'description' => 'Akut Bronşiolit, Tanımlanmamış'],
        ['code' => 'J30.0', 'description' => 'Vazomotor Rinit (Geniz Akıntısı & Burun Tıkanıklığı)'],
        ['code' => 'J30.2', 'description' => 'Mevsimsel Allerjik Rinit (Bahar Nezlesi & Geniz Akıntısı)'],
        ['code' => 'J30.4', 'description' => 'Allerjik Rinit (Geniz Akıntısı & Burun Tıkanıklığı)'],
        ['code' => 'J31.0', 'description' => 'Kronik Rinit (Kronik Geniz Akıntısı & Burun Akıntısı)'],
        ['code' => 'J32.9', 'description' => 'Kronik Sinüzit, Tanımlanmamış'],
        ['code' => 'J33.0', 'description' => 'Burun Boşluğunda Nazal Polip'],
        ['code' => 'J35.0', 'description' => 'Kronik Tonsillit'],
        ['code' => 'J40', 'description' => 'Bronşit, Akut Veya Kronik Olarak Tanımlanmamış'],
        ['code' => 'J43.9', 'description' => 'Amfizem, Tanımlanmamış'],
        ['code' => 'J44.0', 'description' => 'Kronik Obstrüktif Akciğer Hastalığı (KOAH), Akut Alt Solunum Yolu Enfeksiyonu İle'],
        ['code' => 'J44.9', 'description' => 'Kronik Obstrüktif Akciğer Hastalığı (KOAH), Tanımlanmamış'],
        ['code' => 'J45', 'description' => 'Astım'],
        ['code' => 'J45.0', 'description' => 'Astım, Allerjik'],
        ['code' => 'J45.9', 'description' => 'Astım, Tanımlanmamış'],
        ['code' => 'J80', 'description' => 'Yetişkin Solunum Distres Sendromu (ARDS)'],
        ['code' => 'J90', 'description' => 'Plevra Efüzyonu, Başka Yerde Sınıflanmamış'],
        ['code' => 'J93', 'description' => 'Pnömotoraks'],
        ['code' => 'J96.0', 'description' => 'Akut Solunum Yetmezliği'],
        ['code' => 'J96.1', 'description' => 'Kronik Solunum Yetmezliği'],

        // Kas-İskelet Sistemi ve Bağ Dokusu (M Serisi)
        ['code' => 'M01.37', 'description' => 'Artrit, Başka Yerde Sınıflanmış Bakteriyel Hastalıklarda, Ayak Bileği Ve Ayak'],
        ['code' => 'M05', 'description' => 'Seropozitif Romatoid Artrit'],
        ['code' => 'M05.80', 'description' => 'Diğer Seropozitif Romatoid Artrit, Birden Fazla Yer'],
        ['code' => 'M06', 'description' => 'Romatoid Artrit, Diğer'],
        ['code' => 'M06.81', 'description' => 'Diğer Romatoid Artrit, Tanımlanmış, Omuz Bölgesi'],
        ['code' => 'M06.9', 'description' => 'Romatoid Artrit, Tanımlanmamış'],
        ['code' => 'M08.3', 'description' => 'Juvenil Poliartrit (Seronegatif)'],
        ['code' => 'M10', 'description' => 'Gut'],
        ['code' => 'M10.9', 'description' => 'Gut, Tanımlanmamış'],
        ['code' => 'M12.88', 'description' => 'Artropatiler Diğer Tanımlanmış, Başka Yerde Sınıflanmamış, Diğer'],
        ['code' => 'M14.2', 'description' => 'Diyabetik Artropati'],
        ['code' => 'M15.4', 'description' => 'Eroziv (Osteo) Artroz'],
        ['code' => 'M16', 'description' => 'Koksartroz [Kalça Artrozu]'],
        ['code' => 'M16.0', 'description' => 'Primer Koksartroz, Bilateral'],
        ['code' => 'M17', 'description' => 'Gonartroz [Diz Ekleminin Artrozu]'],
        ['code' => 'M17.0', 'description' => 'Primer Gonartroz, Bilateral'],
        ['code' => 'M19.9', 'description' => 'Artroz, Tanımlanmamış'],
        ['code' => 'M22.2', 'description' => 'Patellofemoral Bozukluklar'],
        ['code' => 'M23.35', 'description' => 'Lateral Menisküsün Posterior Boynuzunun Diğer Yerleşim Bozuklukları'],
        ['code' => 'M25.5', 'description' => 'Eklem Ağrısı'],
        ['code' => 'M32.0', 'description' => 'Sistemik Lupus Eritematozus, İlaca Bağlı'],
        ['code' => 'M32.9', 'description' => 'Sistemik Lupus Eritematozus, Tanımlanmamış'],
        ['code' => 'M35.0', 'description' => 'Sikka Sendromu [Sjögren]'],
        ['code' => 'M35.3', 'description' => 'Polimiyalji Romatika'],
        ['code' => 'M41.9', 'description' => 'Skolyoz, Tanımlanmamış'],
        ['code' => 'M43.0', 'description' => 'Spondiloliz'],
        ['code' => 'M45', 'description' => 'Ankilozan Spondilit'],
        ['code' => 'M47.8', 'description' => 'Spondiloz, Diğer'],
        ['code' => 'M48.06', 'description' => 'Spinal Stenoz, Lomber Bölge'],
        ['code' => 'M50.9', 'description' => 'Servikal Disk Bozukluğu, Tanımlanmamış'],
        ['code' => 'M51.1', 'description' => 'Lumbar Ve Diğer İntervertebral Disk Bozuklukları, Radikülopati İle'],
        ['code' => 'M53.29', 'description' => 'Spinal İnstabiliteler, Yer Tanımlanmamış'],
        ['code' => 'M54.16', 'description' => 'Radikülopati, Lomber Bölge'],
        ['code' => 'M54.4', 'description' => 'Lumbago, Siyatik İle'],
        ['code' => 'M54.5', 'description' => 'Bel Ağrısı'],
        ['code' => 'M65.9', 'description' => 'Sinovit Ve Tenosinovit, Tanımlanmamış'],
        ['code' => 'M75.0', 'description' => 'Omuzun Adezif Kapsüliti (Donuk Omuz)'],
        ['code' => 'M75.1', 'description' => 'Rotator Kuf Sendromu'],
        ['code' => 'M77.1', 'description' => 'Lateral Epikondilit (Tenisçi Dirseği)'],
        ['code' => 'M79.0', 'description' => 'Romatizma, Tanımlanmamış'],
        ['code' => 'M79.67', 'description' => 'Ekstremite Ağrısı, Ayak Bileği Ve Ayak'],
        ['code' => 'M79.7', 'description' => 'Fibromiyalji'],
        ['code' => 'M81.0', 'description' => 'Postmenapozal Osteoporoz'],
        ['code' => 'M83.9', 'description' => 'Erişkin Osteomalazisi, Tanımlanmamış'],
        ['code' => 'M86.9', 'description' => 'Osteomyelit, Tanımlanmamış'],
        ['code' => 'M90.0', 'description' => 'Kemik Tüberkülozu'],

        // Sindirim Sistemi Hastalıkları (K Serisi)
        ['code' => 'K02.0', 'description' => 'Mine Çürüğü'],
        ['code' => 'K02.9', 'description' => 'Diş Çürüğü, Tanımlanmamış'],
        ['code' => 'K12.0', 'description' => 'Tekrarlayan Oral Aftlar (Aftöz Stomatit)'],
        ['code' => 'K20', 'description' => 'Özofajit'],
        ['code' => 'K21.0', 'description' => 'Gastro-Özofajial Reflü Hastalığı, Özofajit İle'],
        ['code' => 'K21.9', 'description' => 'Gastro-Özofajial Reflü Hastalığı, Özofajitsiz'],
        ['code' => 'K25', 'description' => 'Mide Ülseri'],
        ['code' => 'K25.9', 'description' => 'Akut Veya Kronik Olarak Tanımlanmamış Mide Ülseri'],
        ['code' => 'K26', 'description' => 'Duodenum Ülseri'],
        ['code' => 'K27.2', 'description' => 'Akut Peptik Ülser, Yeri Tanımlanmamış, Hemoraji Ve Perferasyon Mevcut'],
        ['code' => 'K29.3', 'description' => 'Kronik Yüzeyel Gastrit'],
        ['code' => 'K29.7', 'description' => 'Gastrit, Tanımlanmamış'],
        ['code' => 'K30', 'description' => 'Dispepsi (Hazımsızlık)'],
        ['code' => 'K35.0', 'description' => 'Akut Apandisit, Yaygın Peritonit İle'],
        ['code' => 'K35.8', 'description' => 'Akut Apandisit, Diğer'],
        ['code' => 'K40.9', 'description' => 'Tek Taraflı Veya Tanımlanmamış İnguinal Herni, Gangrensiz Veya Obstrüksiyonsuz'],
        ['code' => 'K50.9', 'description' => 'Crohn Hastalığı, Tanımlanmamış'],
        ['code' => 'K51.9', 'description' => 'Ülseratif Kolit, Tanımlanmamış'],
        ['code' => 'K57.9', 'description' => 'Barsak Divertiküler Hastalığı, Tanımlanmamış Kısım'],
        ['code' => 'K58', 'description' => 'İrritabl Barsak Sendromu (İBS)'],
        ['code' => 'K58.0', 'description' => 'İrritabl Barsak Sendromu, Diareli'],
        ['code' => 'K63.5', 'description' => 'Kolon Polibi'],
        ['code' => 'K70.4', 'description' => 'Alkolik Karaciğer Yetmezliği'],
        ['code' => 'K71.5', 'description' => 'Toksik Karaciğer Hastalığı, Kronik Aktif Hepatit İle'],
        ['code' => 'K73.9', 'description' => 'Kronik Hepatit, Tanımlanmamış'],
        ['code' => 'K74.6', 'description' => 'Karaciğerin Diğer Ve Tanımlanmamış Sirozu'],
        ['code' => 'K75.4', 'description' => 'Otoimmun Hepatit'],
        ['code' => 'K80', 'description' => 'Safra Taşı (Kolelitiazis)'],
        ['code' => 'K80.0', 'description' => 'Safra Kesesi Taşı, Akut Kolesistit İle'],
        ['code' => 'K81.0', 'description' => 'Akut Kolesistit'],
        ['code' => 'K85.9', 'description' => 'Akut Pankreatit, Tanımlanmamış'],
        ['code' => 'K90.9', 'description' => 'Barsak Malabsorpsiyon, Tanımlanmamış'],

        // Üriner ve Genital Sistem Hastalıkları (N & O Serisi)
        ['code' => 'N00.9', 'description' => 'Akut Nefritik Sendrom, Tanımlanmamış'],
        ['code' => 'N04.9', 'description' => 'Nefrotik Sendrom, Tanımlanmamış'],
        ['code' => 'N06.9', 'description' => 'İzole Proteinüri, Tanımlanmamış'],
        ['code' => 'N10', 'description' => 'Akut Tübülo-İnterstisyel Nefrit'],
        ['code' => 'N11.0', 'description' => 'Kronik Pyelonefrit, Obstrüktif Olmayan Reflü İle Birlikte'],
        ['code' => 'N13.2', 'description' => 'Hidronefroz, Böbrek Veya Üreterde Taşa Bağlı Obtrüksiyonla Birlikte'],
        ['code' => 'N17.9', 'description' => 'Akut Böbrek Yetmezliği, Tanımlanmamış'],
        ['code' => 'N18.9', 'description' => 'Kronik Böbrek Yetmezliği, Tanımlanmamış'],
        ['code' => 'N20.0', 'description' => 'Böbrek Taşı'],
        ['code' => 'N20.1', 'description' => 'Üreter Taşı'],
        ['code' => 'N23', 'description' => 'Renal Kolik, Tanımlanmamış'],
        ['code' => 'N30.0', 'description' => 'Akut Sistit'],
        ['code' => 'N30.9', 'description' => 'Sistit, Tanımlanmamış'],
        ['code' => 'N39.0', 'description' => 'Üriner Sistem Enfeksiyonu, Yeri Tanımlanmamış'],
        ['code' => 'N40', 'description' => 'Benign Prostat Hiperplazisi (BPH)'],
        ['code' => 'N43', 'description' => 'Hidrosel Ve Spermatosel'],
        ['code' => 'N47', 'description' => 'Sünnet Derisinin Fazlalığı, Fimozis Ve Parafimozis'],
        ['code' => 'N73.9', 'description' => 'Kadında Pelvik Enflamatuvar Hastalık, Tanımlanmamış'],
        ['code' => 'N80', 'description' => 'Endometrioz'],
        ['code' => 'N83.2', 'description' => 'Ovarian Kistler, Diğer Ve Tanımlanmamış'],
        ['code' => 'N97.9', 'description' => 'Kadın İnfertilitesi, Tanımlanmamış (Gebe Kalma Zorluğu & Kısırlık / Çocuk İsteği)'],
        ['code' => 'O09.9', 'description' => 'Gebelik Takibi & Rutin Gebelik Muayenesi (Hamilelik Takibi & Kontrolü)'],
        ['code' => 'O21.0', 'description' => 'Gebeliğe Bağlı Bulantı Ve Kusma (Hyperemesis Gravidarum & Gebelik Bulantısı)'],
        ['code' => 'O26.8', 'description' => 'Gebeliğe Bağlı Diğer Tanımlanmış Durumlar (Gebelikte Kas Krampları & Aşerme)'],
        // Kadın Hastalıkları, Doğum, PKOS / PCOS, Regl & Vajinismus (E, N, O, D Serisi)
        ['code' => 'E28.2', 'description' => 'Polikistik Over Sendromu (PKOS / PCOS, Adet Düzensizliği, Aşırı Tüylenme, Sivilce & Kilo Alma)'],
        ['code' => 'N91.2', 'description' => 'Amenore, Tanımlanmamış (Adet Gecikmesi, Regl Olamama, Adet Rötarı & Regl Görememe)'],
        ['code' => 'N94.4', 'description' => 'Primer Dismenore (Sancılı Adet / Regl Ağrısı, Şiddetli Kasık Ağrısı & Kramp)'],
        ['code' => 'N92.0', 'description' => 'Menoraj & Aşırı Adet Kanaması (Şiddetli Regl Kanaması, Pıhtılı Kanama & Adetin Durmaması)'],
        ['code' => 'N76.0', 'description' => 'Akut Vajinit & Mantar Enfeksiyonu (Vajinal Kaşıntı, Peynirimsi/Kötü Kokulu Akıntı & Yanma)'],
        ['code' => 'N80.0', 'description' => 'Endometriozis / Çikolata Kisti (Kronik Pelvik Ağrı, Sancılı Regl & Cinsel İlişkide Ağrı)'],
        ['code' => 'D25.9', 'description' => 'Uterus Leiomiyomu / Rahim Miyomu (Miyom, Kasıkta Şişlik & Düzensiz Kanamalar)'],
        ['code' => 'N94.2', 'description' => 'Vajinismus (Cinsel İlişkiye Girememe & Kasılma / İlişkide Şiddetli Ağrı)'],
        ['code' => 'N93.9', 'description' => 'Anormal Uterus Ve Vajina Kanamaları, Tanımlanmamış (Düzensiz Lekelenme, Metroraji & Pelvik Kramp)'],
        // Üroloji, Nefroloji & Renal Kolik Hastalıkları (N20, N23, N39, R30 Serisi)
        ['code' => 'N20.1', 'description' => 'Üreter Taşı (Üreterolitiazis, Yan/Bel Bölgesinde Başlayıp Kasığa Vuran Kıvrandırıcı Dalgalı Kolik Ağrı & Bulantı)'],
        ['code' => 'N20.0', 'description' => 'Böbrek Taşı (Nefrolitiazis, Böbrek Kalsiyum Taşı, Şiddetli Flank Bölge Ağrısı & Kramp)'],
        ['code' => 'N20.9', 'description' => 'Ürolitiyazis / İdrar Yolu Taşı, Tanımlanmamış (Böbrek/Üreter Taşı, Şiddetli Kolik Ağrı)'],
        ['code' => 'N23', 'description' => 'Renal Kolik, Tanımlanmamış (Böbrek/Üreter Kolik Ağrısı, Sol/Sağ Yan Bölgede Kıvrandırıcı Ağrı, Kasığa Yayılım & Bulantı)'],
        // Gastroenteroloji, Mide, Reflü & Gastrit Hastalıkları (K21, K29, K25, K30 Serisi)
        ['code' => 'K21.9', 'description' => 'Gastroözofageal Reflü Hastalığı, Özofajitsiz (GÖRH / Reflü, Göğüs Arkasında Yukarı Yayılan Yanma, Ağza Acı/Ekşi Su Gelmesi & Gece Düz Yatarken Artan Öksürük)'],
        ['code' => 'K21.0', 'description' => 'Gastroözofageal Reflü Hastalığı, Özofajitli (Reflü Özofajit, Yemek Borusu İltihabı, Ağza Acı Su & Şiddetli Yanma)'],
        ['code' => 'K29.7', 'description' => 'Gastrit, Tanımlanmamış (Mide İltihabı, Mide Yanması, Ekşime, Yemek Sonrası Şişkinlik & Mide Kazınması)'],
        ['code' => 'K25.9', 'description' => 'Mide Ülseri (Peptik Ülser, Mide Yarası, Kemirici Mide Ağrısı & Yanma)'],
        ['code' => 'K30', 'description' => 'Fonksiyonel Dispepsi (Mide Ekşimesi, Hazımsızlık, Şişkinlik & Erken Doyma)'],
        // KBB, Otoloji, Nöroloji, Vertigo & Baş Dönmesi Hastalıkları (H81, H83, R42 Serisi)
        ['code' => 'H81.1', 'description' => 'Benign Paroksizmal Pozisyonel Vertigo (BPPV / Pozisyonel Vertigo, Yatakta Dönerken Veya Başı Yukarı Kaldırırken Aniden Başlayan Etrafın Dönmesi Şeklinde Şiddetli Baş Dönmesi, Dengesizlik & Bulantı)'],
        ['code' => 'H81.0', 'description' => 'Meniere Hastalığı (İç Kulak Tansiyonu, Kulakta Çınlama, Dolgunluk & Şiddetli Baş Dönmesi Atakları)'],
        ['code' => 'H81.9', 'description' => 'Vestibüler Fonksiyon Bozuklukları, Tanımlanmamış (Vertigo / Vertijinöz Sendrom, Kulak Kristal Kayması & Dengesizlik)'],
        ['code' => 'R42', 'description' => 'Baş Dönmesi Ve Sersemlik (Vertigo, Sersemlik Hissi & İllüzyonel Dengesizlik)'],
        ['code' => 'H83.0', 'description' => 'Labirentit (İç Kulak İltihabı, İşitme Kaybı & Şiddetli Baş Dönmesi)'],
        // Enfeksiyon Hastalıkları, İnfeksiyöz Gastroenterit & Akut İshal (A09, A08, K52 Serisi)
        ['code' => 'A09.9', 'description' => 'İnfeksiyöz Gastroenterit Ve Kolit, Tanımlanmamış (Akut İnfeksiyöz İshal, Sulu İshal, Karın Bölgesinde Kramp, Bulantı, Kusma & Hafif Ateş)'],
        ['code' => 'A09.0', 'description' => 'Bakteriyel Gastroenterit Ve Kolit (Bakteriyel İshal, Şiddetli Karın Krampı, Yüksek Ateş & İshal)'],
        ['code' => 'A08.4', 'description' => 'Tanımlanmamış Viral İntestinal Enfeksiyon (Viral Gastroenterit / Mide-Bağırsak Gribi, Sulu İshal & Kusma)'],
        ['code' => 'K52.9', 'description' => 'Noninfeksiyöz Gastroenterit Ve Kolit, Tanımlanmamış (Gıda Zehirlenmesi / Besin Zehirlenmesi & Akut İshal)'],
        // Fiziksel Tıp, Rehabilitasyon & Ortopedi Omuz Hastalıkları (M75 Serisi)
        ['code' => 'M75.1', 'description' => 'Rotatör Manşet Sendromu (Rotatör Manşet Tendiniti / Yırtığı, Omzu Yukarı Kaldırırken Veya Arkaya Götürürken Ağrı, Gece Ağrıyan Tarafın Üzerine Yatamama & Omuz Hareket Kısıtlılığı)'],
        ['code' => 'M75.0', 'description' => 'Adhezif Kapsülit (Donuk Omuz / Frozen Shoulder, Omuz Eklem Kapsülü Sertleşmesi, Ağrı & Hareket Kısıtlılığı)'],
        ['code' => 'M75.4', 'description' => 'Omuz İmpingement Sendromu (Subakromiyal Sıkışma Sendromu, Kolu Kaldırırken Sıkışma & Şiddetli Omuz Ağrısı)'],
        ['code' => 'M75.5', 'description' => 'Omuz Bursiti (Subakromiyal Bursit, Omuz Eklem Torbası İltihabı & Gece Ağrısı)'],
        ['code' => 'M75.9', 'description' => 'Omuz Lezyonu, Tanımlanmamış (Omuz Ağrısı & Eklem Hareket Kısıtlılığı)'],
        ['code' => 'O00.9', 'description' => 'Ektopik Gebelik, Tanımlanmamış (Dış Gebelik, Düzensiz Lekelenme & Alt Karın Kramp Ağrısı)'],
        ['code' => 'H10.9', 'description' => 'Konjonktivit, Tanımlanmamış (Gözde Kanlanma, Batma, Sulanma & Yoğun Çapaklanma)'],
        ['code' => 'H10.5', 'description' => 'Blefarokonjonktivit (Kirpik Dibi İltihabı, Kirpiklerde Yapışıklık & Gözde Kanlanma)'],
        ['code' => 'O44.1', 'description' => 'Plasenta Previa, Hemorajili'],

        // Deri, Mantar, Tahriş, Yaralanma ve Dış Etkenler (B, L, W, S, R, E, D Serisi)
        ['code' => 'L24.9', 'description' => 'İritan Kontakt Dermatit (Cilt Tahrişi, Kızarıklık & Kimyasal/Fiziksel İritasyon)'],
        ['code' => 'L25.9', 'description' => 'Tanımlanmamış Kontakt Dermatit (Cilt Tahrişi, Kaşıntı & İritasyon)'],
        ['code' => 'L30.9', 'description' => 'Dermatit, Tanımlanmamış (Egzama & Cilt Tahrişi)'],
        ['code' => 'L22', 'description' => 'Diyaper Dermatiti (Pişik & Cilt Tahrişi)'],
        ['code' => 'J31.2', 'description' => 'Kronik Farenjit (Kronik Boğaz Tahrişi, Yanma & Kuruluk)'],
        ['code' => 'B35.3', 'description' => 'Tinea Pedis (Ayak Mantarı & Parmak Arası Kaşıntısı)'],
        ['code' => 'B35.1', 'description' => 'Tinea Unguium (Tırnak Mantarı / Onikomikoz)'],
        ['code' => 'B35.9', 'description' => 'Dermatofitoz (Cilt Mantar Enfeksiyonu & Kaşıntı)'],
        ['code' => 'W45', 'description' => 'Deride Yabancı Cisim Batması (Kıymık, Çivi, Diken, Cam Batması)'],
        ['code' => 'S91.3', 'description' => 'Ayak Ve Ayak Parmaklarının Açık Yarası (Batan Cisim & İltihaplı Yara)'],
        ['code' => 'R53', 'description' => 'Malaise Ve Yorgunluk (Kronik Halsizlik, Enerjisizlik & Sürekli Yorgunluk)'],
        ['code' => 'D50.9', 'description' => 'Demir Eksikliği Anemisi (Kansızlık, Üşüme & Çabuk Yorulma)'],
        ['code' => 'I73.9', 'description' => 'Periferik Vasküler Hastalık (Ellerde & Ayaklarda Üşüme & Soğukluk)'],


        // Kırık, Çıkık, Kesik ve Travma (S & T Serisi)
        ['code' => 'S52.9', 'description' => 'Ön Kol Kırığı, Tanımlanmamış (Kol Kırılması & Şişlik)'],
        ['code' => 'S82.9', 'description' => 'Alt Bacak Kırığı, Tanımlanmamış (Bacak Kırığı & Şiddetli Ağrı)'],
        ['code' => 'S62.8', 'description' => 'El Ve Bilek Kemik Kırığı (El / Parmak Kırılması)'],
        ['code' => 'S43.0', 'description' => 'Omuz Eklemi Çıkığı (Omuz Çıkması & Şiddetli Ağrı)'],
        ['code' => 'S63.1', 'description' => 'Parmak Eklemi Çıkığı (Parmak Çıkması & Şişlik)'],
        ['code' => 'S93.4', 'description' => 'Ayak Bileği Burkulması Ve İncinmesi (Burkulma & Şişlik)'],
        ['code' => 'S61.9', 'description' => 'El Ve Parmak Açık Kesisi (Cam / Bıçak Kesilmesi & Kanama)'],
        ['code' => 'S51.9', 'description' => 'Ön Kol Açık Kesisi / Yarası (Derin Kesik & Kanama)'],
        ['code' => 'T14.1', 'description' => 'Vücut Bölgesinin Açık Kesik Yarası (Doku Kesisi & Kanama)'],

        // Onkoloji Ve Kanser Hastalıkları (C Serisi)
        ['code' => 'C50.9', 'description' => 'Meme Malign Neoplazmı (Meme Kanseri, Kitle & Sertlik)'],
        ['code' => 'C34.9', 'description' => 'Akciğer Malign Neoplazmı (Akciğer Kanseri & Öksürük)'],
        ['code' => 'C18.9', 'description' => 'Kolon Malign Neoplazmı (Kolon / Bağırsak Kanseri)'],
        ['code' => 'C16.9', 'description' => 'Mide Malign Neoplazmı (Mide Kanseri & Kilo Kaybı)'],
        ['code' => 'C61', 'description' => 'Prostat Malign Neoplazmı (Prostat Kanseri)'],
        ['code' => 'C91.0', 'description' => 'Akut Lenfoblastik Lösemi (Lösemi / Kan Kanseri)'],
        ['code' => 'C85.9', 'description' => 'Non-Hodgkin Lenfoma (Lenfoma / Lenf Bezi Kanseri)'],
        // Çocuk Sağlığı, Pediatri & Nörogelişimsel Hastalıklar (F, R, A, J, B Serisi)
        ['code' => 'F84.0', 'description' => 'Çocukluk Otizmi (Otizm Spektrum Bozukluğu, Göz Teması Kuramama & İletişim Güçlüğü)'],
        ['code' => 'F84.5', 'description' => 'Asperger Sendromu (Sosyal Etkileşim Bozukluğu & Otizm Spektrumu)'],
        ['code' => 'F90.0', 'description' => 'Dikkat Eksikliği Ve Hiperaktivite Bozukluğu (DEHB, Aşırı Hareketlilik & Odaklanma Sorunu)'],
        ['code' => 'R56.0', 'description' => 'Febril Konvülsiyon (Çocukta Ateşli Havale, Nöbet & Kasılma)'],
        ['code' => 'A08.0', 'description' => 'Rotavirüs Enteriti (Çocuklarda Şiddetli İshal, Kusma & Sıvı Kaybı)'],
        ['code' => 'J21.9', 'description' => 'Akut Bronşiyolit (Bebek Ve Çocukta Hırıltılı Solunum & Nefes Darlığı)'],
        ['code' => 'B05.9', 'description' => 'Kızamık (Morbilli, Çocukta Kırmızı Döküntü & Yüksek Ateş)'],
        ['code' => 'B01.9', 'description' => 'Su Çiçeği (Varisella, İçi Sıvı Dolu Kaşıntılı Döküntü)'],
        ['code' => 'B08.4', 'description' => 'Enteroviral Veziküler Stomatit (El-Ayak-Ağız Hastalığı / Coxsackievirus, Ağız İçinde Aft Yaraları, El Ve Ayak Tabanlarında Kırmızı Döküntü & Yüksek Ateş)'],
        ['code' => 'B08.5', 'description' => 'Herpanjina (Enteroviral Ağız İçi Aftöz Yaralar, Yutma Güçlüğü & Yüksek Ateş)'],
        ['code' => 'B06.9', 'description' => 'Kızamıkçık (Rubella, Çocukta Cilt Döküntüsü & Hafif Ateş)'],
        // T.C. Sağlık Bakanlığı Teleradyoloji / Genel Müdürlük ICD-10 Kataloğundan Eklenenler
        ['code' => 'G00.9', 'description' => 'Bakteriyel Menenjit, Tanımlanmamış (Ense Sertliği, Yüksek Ateş & Şiddetli Baş Ağrısı)'],
        ['code' => 'B18.1', 'description' => 'Kronik Viral Hepatit B (Karaciğer İltihabı, Ciltte/Gözde Sararma & Sarılık)'],
        ['code' => 'B18.2', 'description' => 'Kronik Viral Hepatit C (Viral Karaciğer Hastalığı & Sarılık)'],
        ['code' => 'H40.1', 'description' => 'Primer Açık Açılı Glokom (Göz Tansiyonu Yüksekliği, Göz İçi Basınç & Görme Daralması)'],
        ['code' => 'L50.1', 'description' => 'İdiopatik Ürtiker (Kurdeşen, Vücutta Kaşıntılı Kabarıklık & Kızarıklık)'],
        ['code' => 'F20.9', 'description' => 'Şizofreni, Tanımlanmamış (Gaipten Sesler Duyma, Halüsinasyon & Sanrılar)'],
        ['code' => 'F32.9', 'description' => 'Depresif Nöbet, Tanımlanmamış (Majör Depresyon, İsteksizlik & Ağlama Krizleri)'],
        ['code' => 'F41.0', 'description' => 'Panik Bozukluk [Epizodik Paroksizmal Anksiyete] (Panik Atak, Aniden Başlayan Göğüste Sıkışma, Çarpıntı, Nefes Alamama Hissi, Ellerde Titreme/Karıncalanma & Kontrolü Kaybetme Korkusu)'],
        ['code' => 'F41.1', 'description' => 'Yaygın Anksiyete Bozukluğu (Anksiyete, Sürekli Endişe, Evham, İç Sıkıntısı & Huzursuzluk)'],
        ['code' => 'F41.9', 'description' => 'Anksiyete Bozukluğu, Tanımlanmamış (Kaygı Bozukluğu & Anksiyete Krizleri)'],
        ['code' => 'G40.9', 'description' => 'Epilepsi, Tanımlanmamış (Sara Nöbeti, Bilinç Kaybı & Vücutta Kasılma)'],
        ['code' => 'I21.9', 'description' => 'Akut Miyokard Enfarktüsü (Kalp Krizi, Sıkışma, Sol Kola Vuran Ağrı & Soğuk Ter)'],
        ['code' => 'A23.9', 'description' => 'Bruselloz, Tanımlanmamış (Peynir Hastalığı, Dalgalı Ateş, Gece Terlemesi & Eklem Ağrısı)'],
        ['code' => 'G50.0', 'description' => 'Trigeminal Nevralji (Yüzde Şimşek Çakar Gibi Elektrik Çarpması Ağrısı & Çene Ağrısı)'],
        ['code' => 'U07.1', 'description' => 'COVID-19 / Koronavirüs Enfeksiyonu (Tat Ve Koku Kaybı, Yüksek Ateş & Solunum Sıkıntısı)'],
        ['code' => 'K58.0', 'description' => 'İrritabl Bağırsak Sendromu (İBS / Hassas Bağırsak, Stresle Artan Şişkinlik & Kramp)'],
        ['code' => 'Q79.6', 'description' => 'Ehlers-Danlos Sendromu (Aşırı Eklem Esnekliği & Bağ Dokusu Gevşekliği)'],
        // Acil İç Kanama & Gastrointestinal (Mide / Bağırsak) Kanamaları (K92, K25, R58, I85, I71 Serisi)
        ['code' => 'K92.2', 'description' => 'Gastrointestinal Kanama, Tanımlanmamış (Mide/Bağırsak Kanaması, İç Kanama & Hipovolemi)'],
        ['code' => 'K25.0', 'description' => 'Akut Mide Ülseri, Kanamalı (Kanamalı Mide Ülseri & Mide Kanaması)'],
        ['code' => 'K92.1', 'description' => 'Melena (Sindirim Kanalı İç Kanaması, Siyah Katran Gibi Cıvık Dışkılama)'],
        ['code' => 'K92.0', 'description' => 'Hematemez (Mide Kanaması, Ağızdan Kahve Telvesi Veya Taze Kan Kusma)'],
        ['code' => 'R58', 'description' => 'Kanama, Başka Yerde Sınıflanmamış (Acil İç Kanama, Akut Dahili Hemoraji & Şok Riski)'],
        ['code' => 'I85.0', 'description' => 'Özofagus Varis Kanaması, Kanamalı (Yemek Borusu Varis Kanaması & Şiddetli Kan Kusma)'],
        // Gastroenteroloji & Genel Cerrahi Hastalıkları (K35, K80, K81, K21, K51, K40, K60, K56, K85 Serisi)
        ['code' => 'K35.8', 'description' => 'Akut Apandisit, Diğer Ve Tanımlanmamış (Göbek Çevresinde Başlayıp Sağ Alt Kadrana Yerleşen Ağrı & İştahsızlık)'],
        ['code' => 'K80.2', 'description' => 'Safra Kesesi Taşı, Kolesistit Olmadan (Kolelitiazis, Yağlı Yemek Sonrası Sağ Üst Kadran Ağrısı & Sırta Vuran Kramp)'],
        ['code' => 'K81.0', 'description' => 'Akut Kolesistit (Akut Safra Kesesi İltihabı, Sağ Üst Kadran Ağrısı & Bulantı)'],
        ['code' => 'K21.0', 'description' => 'Gastro-Özofajial Reflü Hastalığı, Özofajit İle (GÖRH, Göğüste Yanma & Ağza Acı Su Gelmesi)'],
        ['code' => 'K51.9', 'description' => 'Ülseratif Kolit, Tanımlanmamış (Kanlı-Mukuslu İshal, Kramp Karın Ağrısı & İltihabi Bağırsak)'],
        ['code' => 'K74.6', 'description' => 'Karaciğer Sirozu Ve Kolestaz (Tıkanma Sarılığı, Gözlerde/Ciltte Sararma, Koyu İdrar & Açık Renk Dışkı)'],
        ['code' => 'K40.9', 'description' => 'İnguinal Herni (Kasık Fıtığı, Ikınmakla/Ayakta Durmakla Belirginleşen Ağrılı Şişlik)'],
        ['code' => 'K60.1', 'description' => 'Kronik Anal Fissür (Makat Çatlağı, Dışkılamada Şiddetli Cam Kesiği Tarzı Ağrı & Taze Kan)'],
        ['code' => 'K56.6', 'description' => 'İleus & Bağırsak Tıkanıklığı (Gaz-Gaita Çıkaramama, Şiddetli Şişkinlik & Fışkırır Kusma)'],
        ['code' => 'K85.9', 'description' => 'Akut Pankreatit, Tanımlanmamış (Epigastrik Bölgeden Sırta Kuşak Tarzında Yayılan Şiddetli Ağrı & Kusma)'],
        ['code' => 'C80', 'description' => 'Malign Neoplazm, Tanımlanmamış Yerin (Kanser / Tümör)'],

        // Diş, Ağız Ve Çene Hastalıkları (K00 - K14 Serisi)
        ['code' => 'K08.8', 'description' => 'Diş Ve Destek Dokuların Ağrısı (Şiddetli Diş Ağrısı & Zonklama)'],
        ['code' => 'K02.9', 'description' => 'Diş Çürüğü, Tanımlanmamış (Çürük Diş Ağrısı & Hassasiyet)'],
        ['code' => 'K04.7', 'description' => 'Periapikal Abses, Sinüssüz (Diş Apsei, Yüz Şişliği & Zonklama)'],
        ['code' => 'K05.1', 'description' => 'Kronik Gingivit (Diş Eti İltihabı & Diş Eti Kanaması)'],
        ['code' => 'K12.0', 'description' => 'Tekrarlayan Oral Aftlar (Ağız İçi Aft, Ağız Yarası)'],
        ['code' => 'K07.6', 'description' => 'Temporomandibüler Eklem Bozukluğu (Çene Ağrısı & Kitlenme)'],

        // Sinir Sistemi ve Ruh Sağlığı (G & F Serisi)


        ['code' => 'F03', 'description' => 'Bunama (Demans), Tanımlanmamış'],

        ['code' => 'F10.2', 'description' => 'Alkol Kullanımına Bağlı Bağımlılık Sendromu'],
        ['code' => 'F20.9', 'description' => 'Şizofreni, Tanımlanmamış'],
        ['code' => 'F25.9', 'description' => 'Şizoafektif Bozukluk, Tanımlanmamış'],
        ['code' => 'F31.9', 'description' => 'Bipolar Duygulanım Bozukluğu, Tanımlanmamış'],
        ['code' => 'F32', 'description' => 'Depresif Nöbet'],
        ['code' => 'F32.9', 'description' => 'Depresif Nöbet, Tanımlanmamış'],
        ['code' => 'F33.1', 'description' => 'Yineleyen Depresif Bozukluk, Şimdiki Nöbet Orta Şiddetli'],
        ['code' => 'F41.0', 'description' => 'Panik Bozukluk [Epizodik Paroksismal Anksiyete]'],
        ['code' => 'F41.1', 'description' => 'Yaygın Anksiyete Bozukluğu'],
        ['code' => 'F41.2', 'description' => 'Karışık Anksiyete Ve Depresif Bozukluk'],
        ['code' => 'F41.9', 'description' => 'Anksiyete Bozukluğu, Tanımlanmamış'],
        ['code' => 'F43.0', 'description' => 'Akut Stres Tepkisi'],
        ['code' => 'F43.2', 'description' => 'Uyum Bozuklukları'],
        ['code' => 'E66.9', 'description' => 'Obezite, Tanımlanmamış (Aşırı Kilo & VKİ > 30 kg/m²)'],
        ['code' => 'E66.0', 'description' => 'Aşırı Kaloriye Bağlı Obezite'],
        ['code' => 'F50.0', 'description' => 'Anoreksiya Nervoza (Kilo Almaktan Korkma & Şiddetli Yeme Bozukluğu)'],
        ['code' => 'F50.9', 'description' => 'Yeme Bozukluğu, Tanımlanmamış'],
        ['code' => 'F51.0', 'description' => 'Organik Olmayan İnsomnia'],
        ['code' => 'F90.0', 'description' => 'Aktivite Ve Dikkat Bozukluğu (DEHB)'],
        ['code' => 'G00', 'description' => 'Bakteriyel Menenjit, Başka Yerde Sınıflanmamış'],
        ['code' => 'G20', 'description' => 'Parkinson Hastalığı'],
        ['code' => 'G25.0', 'description' => 'Esansiyel Tremor'],
        ['code' => 'G30.9', 'description' => 'Alzheimer Hastalığında Bunama, Tanımlanmamış'],
        ['code' => 'G35', 'description' => 'Multipl Skleroz (MS)'],
        ['code' => 'G40.9', 'description' => 'Epilepsi, Tanımlanmamış'],
        ['code' => 'G43.9', 'description' => 'Migren, Tanımlanmamış'],
        ['code' => 'G44.0', 'description' => 'Küme Baş Ağrısı Sendromu'],
        ['code' => 'G44.2', 'description' => 'Gerilim Baş Ağrısı'],
        ['code' => 'G45.9', 'description' => 'Geçici Serebral İskemik Atak, Tanımlanmamış'],
        ['code' => 'G47.0', 'description' => 'İnsomnia (Uykuya Dalma Ve Sürdürme Bozukluğu)'],
        ['code' => 'G47.3', 'description' => 'Uyku Apnesi (Obstrüktif Uyku Apne Sendromu)'],
        ['code' => 'G47.9', 'description' => 'Uyku Bozuklukları, Tanımlanmamış'],
        ['code' => 'G50.0', 'description' => 'Trigeminal Nevralji'],
        ['code' => 'G51.0', 'description' => 'Bell Palsisi (Fasiyal Felç)'],
        ['code' => 'G54.1', 'description' => 'Lumbosakral Pleksus Bozuklukları'],
        ['code' => 'G56.0', 'description' => 'Karpal Tünel Sendromu'],
        ['code' => 'G61.0', 'description' => 'Guillain-Barre Sendromu'],
        ['code' => 'G80.9', 'description' => 'Serebral Palsi, Tanımlanmamış'],
        ['code' => 'G81.9', 'description' => 'Hemipleji, Tanımlanmamış'],
        ['code' => 'G93.4', 'description' => 'Ensefalopati, Tanımlanmamış'],

        // Enfeksiyon Hastalıkları (A & B Serisi)
        ['code' => 'A02.0', 'description' => 'Salmonella Enteriti'],
        ['code' => 'A04.9', 'description' => 'Bakteriyel Barsak Enfeksiyonu, Tanımlanmamış'],
        ['code' => 'A09', 'description' => 'Diyare Ve Gastroenterit, Enfeksiyöz Kaynaklı Olduğu Tahmin Edilen'],
        ['code' => 'A15.0', 'description' => 'Akciğer Tüberkülozu, Mikroskopisi İle Kanıtlanmış'],
        ['code' => 'A23.9', 'description' => 'Bruselloz, Tanımlanmamış'],
        ['code' => 'A41.9', 'description' => 'Septisemi, Tanımlanmamış'],
        ['code' => 'A51.0', 'description' => 'Primer Genital Sifiliz'],
        ['code' => 'A54.9', 'description' => 'Gonokok Enfeksiyonu, Tanımlanmamış'],
        ['code' => 'A60.9', 'description' => 'Anogenital Herpes Virüs Enfeksiyonu, Tanımlanmamış'],
        ['code' => 'A82', 'description' => 'Kuduz'],
        ['code' => 'B00.9', 'description' => 'Herpes Virüs Enfeksiyonu, Tanımlanmamış'],
        ['code' => 'B01', 'description' => 'Varisella [Su Çiçeği]'],
        ['code' => 'B02.9', 'description' => 'Zoster [Zona], Komplikasyonsuz'],
        ['code' => 'B15.9', 'description' => 'Hepatit A, Hepatik Komasız'],
        ['code' => 'B16.9', 'description' => 'Akut Hepatit B, Delta Ajansız, Hepatik Komasız'],
        ['code' => 'B18.1', 'description' => 'Kronik Viral Hepatit B, Delta Ajansız'],
        ['code' => 'B18.2', 'description' => 'Kronik Viral Hepatit C'],
        ['code' => 'B20', 'description' => 'İnsan İmmünyetmezlik Virüsü [HIV] Hastalığı'],
        ['code' => 'B34.9', 'description' => 'Virüs Enfeksiyonu, Tanımlanmamış'],
        ['code' => 'B35.0', 'description' => 'Tinea Barba Ve Tinea Capitis'],
        ['code' => 'B37.0', 'description' => 'Kandida Stomatiti'],
        ['code' => 'B67.9', 'description' => 'Ekinokokoz, Diğer Ve Tanımlanmamış'],
        ['code' => 'B96.5', 'description' => 'Pseudomonas (Aeruginosa) Enfeksiyonu'],

        // Deri ve Alerji (L Serisi)
        ['code' => 'L02.9', 'description' => 'Deri Apse, Furonkül Ve Karbonkülü, Tanımlanmamış'],
        ['code' => 'L03.9', 'description' => 'Selülit, Tanımlanmamış'],
        ['code' => 'L10.0', 'description' => 'Pemfigus Vulgaris'],
        ['code' => 'L20.9', 'description' => 'Atopik Dermatit, Tanımlanmamış'],
        ['code' => 'L21.0', 'description' => 'Sebore Kapit'],
        ['code' => 'L23.9', 'description' => 'Allerjik Kontakt Dermatit, Tanımlanmamış Nedenler'],
        ['code' => 'L24.9', 'description' => 'İrritan Kontakt Dermatit, Tanımlanmamış Neden'],
        ['code' => 'L25.9', 'description' => 'Kontakt Dermatit, Tanımlanmamış Neden'],
        ['code' => 'L27.0', 'description' => 'Yaygın Deri Döküntüsü, İlaç Ve Tıbbi Maddelere Bağlı'],
        ['code' => 'L30.9', 'description' => 'Dermatit, Tanımlanmamış'],
        ['code' => 'L40', 'description' => 'Psoriazis [Sedef Hastalığı]'],
        ['code' => 'L50.0', 'description' => 'Allerjik Ürtiker'],
        ['code' => 'L50.9', 'description' => 'Ürtiker, Tanımlanmamış'],
        ['code' => 'L63.0', 'description' => 'Alopesia (Kapitis) Totalis'],
        ['code' => 'L70.0', 'description' => 'Akne Vulgaris'],
        ['code' => 'L80', 'description' => 'Vitiligo'],
        ['code' => 'L90', 'description' => 'Derinin Atrofik Bozuklukları'],
        ['code' => 'L93.0', 'description' => 'Diskoid Lupus Eritematoz'],
        ['code' => 'L98.8', 'description' => 'Derinin Ve Subkütan Dokunun Diğer Tanımlanmış Bozuklukları'],

        // Göz, Kulak ve KBB (H Serisi)
        ['code' => 'H01.0', 'description' => 'Blefarit'],
        ['code' => 'H10.0', 'description' => 'Mukopürülan Konjonktivit'],
        ['code' => 'H10.9', 'description' => 'Konjonktivit, Tanımlanmamış'],
        ['code' => 'H16.0', 'description' => 'Kornea Ülseri'],
        ['code' => 'H25.9', 'description' => 'Senil Katarakt, Tanımlanmamış'],
        ['code' => 'H26.9', 'description' => 'Katarakt, Tanımlanmamış'],
        ['code' => 'H35.0', 'description' => 'Background Retinopati Ve Retina Damar Değişiklikleri'],
        ['code' => 'H40', 'description' => 'Glokom [Göz Tansiyonu]'],
        ['code' => 'H40.1', 'description' => 'Primer Açık Açılı Glokom'],
        ['code' => 'H40.9', 'description' => 'Glokom, Tanımlanmamış'],
        ['code' => 'H52.0', 'description' => 'Hipermetropi'],
        ['code' => 'H52.2', 'description' => 'Astigmatizma'],
        ['code' => 'H60.9', 'description' => 'Otitis Eksterna, Tanımlanmamış'],
        ['code' => 'H65.9', 'description' => 'Nonsüpüratif Otitis Media, Tanımlanmamış'],
        ['code' => 'H66.4', 'description' => 'Süpüratif Otitis Media, Tanımlanmamış'],
        ['code' => 'H69.9', 'description' => 'Östaki Tüpü Bozuklukları, Tanımlanmamış'],
        ['code' => 'H80', 'description' => 'Otoskleroz'],
        ['code' => 'H81.1', 'description' => 'Benign Paroksismal Vertigo (Baş Dönmesi & Çınlama)'],
        ['code' => 'H90.5', 'description' => 'Sensorinöral İşitme Kaybı, Tanımlanmamış'],
        ['code' => 'H91.9', 'description' => 'İşitme Kaybı, Tanımlanmamış'],
        ['code' => 'H93.1', 'description' => 'Tinnitus (Kulak Çınlaması)'],

        // Genel Belirtiler ve Bulgular (R & D Serisi)
        ['code' => 'R41.3', 'description' => 'Amnesi Veya Hafıza Kaybı (Aşırı Unutkanlık)'],
        ['code' => 'F06.7', 'description' => 'Hafif Bilişsel Bozukluk (Unutkanlık & Odaklanma Sorunu)'],
        ['code' => 'R20.2', 'description' => 'Parestazi (Uyuşma Ve Karıncalanma Hissi)'],
        ['code' => 'G62.9', 'description' => 'Polinöropati, Tanımlanmamış (Nöropatik Karıncalanma & Ağrı)'],
        ['code' => 'R53', 'description' => 'Halsizlik Ve Yorgunluk (Kronik Yorgunluk Sendromu)'],
        ['code' => 'D50.9', 'description' => 'Demir Eksikliği Anemisi (Yorgunluk & Halsizlik)'],
        ['code' => 'R55', 'description' => 'Senkop Ve Presenkop (Bayılma Ve Baygınlık Hissi)'],
        ['code' => 'R42', 'description' => 'Vertigo Ve Baş Dönmesi (Baygınlık Hissi & Sersemlik)'],
        ['code' => 'R14', 'description' => 'Meteorizm Ve Gaz Ağrısı (Şişkinlik Ve Gaz)'],
        ['code' => 'R10.4', 'description' => 'Karın Ağrısı, Diğer Ve Tanımlanmamış'],
        ['code' => 'K59.0', 'description' => 'Konstipasyon (Kabızlık)'],
        ['code' => 'R13', 'description' => 'Disfaji (Yutma Güçlüğü)'],
        ['code' => 'R63.0', 'description' => 'Anoreksi (İştahsızlık)'],
        ['code' => 'R19.6', 'description' => 'Halitozis (Ağız Kokusu)'],
        ['code' => 'R00.2', 'description' => 'Çarpıntı (Palpitasyon)'],
        ['code' => 'I49.9', 'description' => 'Kardiyak Aritmi, Tanımlanmamış'],
        ['code' => 'I73.9', 'description' => 'Periferik Vasküler Hastalık (El Ve Ayaklarda Üşüme)'],
        ['code' => 'R23.0', 'description' => 'Siyanoz (Morarma)'],
        ['code' => 'I50.0', 'description' => 'Konjestif Kalp Yetmezliği (Boyun Damarlarında Şişme & Çabuk Yorulma)'],
        ['code' => 'R61.9', 'description' => 'Hiperhidroz (Soğuk Terleme)'],
        ['code' => 'R60.0', 'description' => 'Lokalize Ödem (Bacaklarda Ödem)'],
        ['code' => 'M54.2', 'description' => 'Servikalji (Boyun Ağrısı Ve Boyun Tutulması)'],
        ['code' => 'R25.2', 'description' => 'Kas Krampları Ve Spazmları'],
        ['code' => 'M54.9', 'description' => 'Dorsalji (Sırt Ağrısı)'],
        ['code' => 'M25.6', 'description' => 'Eklem Sertliği Ve Hareket Kısıtlılığı'],
        ['code' => 'M62.8', 'description' => 'Kas Güçsüzlüğü (Miyopati)'],
        ['code' => 'M25.4', 'description' => 'Eklem Efüzyonu (Eklem Şişliği)'],
        ['code' => 'M89.8', 'description' => 'Kemik Ağrısı Ve Bozuklukları'],
        ['code' => 'R26.2', 'description' => 'Yürüme Güçlüğü Ve Topallama'],
        ['code' => 'L29.9', 'description' => 'Kaşıntı (Prurit), Tanımlanmamış'],
        ['code' => 'L85.3', 'description' => 'Kserozis Kutis (Aşırı Cilt Kurutluğu & Çatlama)'],
        ['code' => 'L65.9', 'description' => 'Alopesi (Saç Dökülmesi), Tanımlanmamış'],
        ['code' => 'L60.3', 'description' => 'Tırnak Distrofisi (Tırnak Kırılması Ve Bozukluğu)'],
        ['code' => 'R23.1', 'description' => 'Solukluk (Ciltte Solgunluk)'],
        ['code' => 'L74.9', 'description' => 'Ekrin Ter Bozukluğu (Terleme Bozukluğu)'],
        ['code' => 'R50.9', 'description' => 'Ateş, Tanımlanmamış (Ateş Yükselmesi)'],
        ['code' => 'R63.4', 'description' => 'Anormal Kilo Kaybı'],
        ['code' => 'E66.9', 'description' => 'Obezite, Tanımlanmamış (Aşırı Kilo Alma)'],
        ['code' => 'N39.0', 'description' => 'İdrar Yolu Enfeksiyonu (İdrarda Yanma Ve Sık İdrara Çıkma)'],
        ['code' => 'R30.0', 'description' => 'Dizüri Ve Polakizüri (İdrarda Yanma & Sık İdrar)'],
        ['code' => 'H53.8', 'description' => 'Görme Bozukluğu (Göz Bulanıklığı)'],
        ['code' => 'H04.2', 'description' => 'Epifora (Göz Sulanması)'],
        ['code' => 'R68.2', 'description' => 'Ağız Kuruluğu, Tanımlanmamış (Kserostomi)'],
        ['code' => 'F41.1', 'description' => 'Yaygın Anksiyete Bozukluğu (Anksiyete Hissi)'],

        // Yaralanma, Dış Nedenler ve Muayeneler (S, T, Z Serisi)
        ['code' => 'S02.9', 'description' => 'Kafa Ve Yüz Kemiklerinin Kırığı, Tanımlanmamış Kısım'],
        ['code' => 'S12.0', 'description' => 'Birinci Servikal Vertebra Kırığı'],
        ['code' => 'S32.0', 'description' => 'Lomber Vertebra Kırığı, Kapalı'],
        ['code' => 'S42.0', 'description' => 'Klavikula Kırığı'],
        ['code' => 'S52.0', 'description' => 'Ulna Üst Uç Kırığı'],
        ['code' => 'S62.0', 'description' => 'El Naviküler [Skafoid] Kemik Kırığı'],
        ['code' => 'S72.0', 'description' => 'Femur Boyun Kırığı'],
        ['code' => 'S82.0', 'description' => 'Patella Kırığı'],
        ['code' => 'S92.0', 'description' => 'Kalkaneus Kırığı'],
        ['code' => 'T14.2', 'description' => 'Vücut Bölgesi Tanımlanmamış Kırığı'],
        ['code' => 'T20.0', 'description' => 'Baş Ve Boynun Derecesi Tanımlanmamış Yanığı'],
        ['code' => 'T30.0', 'description' => 'Vücut Bölgesi Tanımlanmamış Yanığı'],
        ['code' => 'T79.4', 'description' => 'Travmatik Şok'],
        ['code' => 'Z00.0', 'description' => 'Genel Tıbbi Muayene'],
        ['code' => 'Z01.0', 'description' => 'Göz Ve Görme Muayenesi'],
        ['code' => 'Z02.0', 'description' => 'Eğitim Kurumlarına Kabul İçin Muayene'],
        ['code' => 'Z09.4', 'description' => 'Kırık Tedavisi Sonrası Takip Muayenesi'],
        ['code' => 'Z30', 'description' => 'Doğum Kontrolu Yöntemi'],
        ['code' => 'Z34.0', 'description' => 'Normal İlk Gebeliğin Gözlemi'],
        ['code' => 'Z51.0', 'description' => 'Radyoterapi Dönemi'],
        ['code' => 'Z95.0', 'description' => 'Kalp Pili Bulunuşu'],
        ['code' => 'Z98.8', 'description' => 'Cerrahi Sonrası Diğer Tanımlanmış Durum'],
    ];

    protected array $catalogIndexed = [];

    /**
     * İndekslenmiş O(1) ICD-10 kod haritasını getirir.
     */
    protected function getCatalogMap(): array
    {
        if (empty($this->catalogIndexed)) {
            foreach ($this->catalog as $item) {
                $this->catalogIndexed[strtoupper($item['code'])] = $item;
            }
        }
        return $this->catalogIndexed;
    }

    /**
     * Tüm ICD-10 tanı kataloğunu döner.
     */
    public function getAll(): array
    {
        return $this->catalog;
    }


    /**
     * Kod veya açıklama bazlı ICD-10 araması yapar.
     */
    public function search(string $query, int $limit = 20): array
    {
        $query = mb_strtolower(trim($query), 'UTF-8');
        if (empty($query)) {
            return array_slice($this->catalog, 0, $limit);
        }

        $results = array_filter($this->catalog, function ($item) use ($query) {
            $codeMatch = str_contains(mb_strtolower($item['code'], 'UTF-8'), $query);
            $descMatch = str_contains(mb_strtolower($item['description'], 'UTF-8'), $query);
            return $codeMatch || $descMatch;
        });

        return array_slice(array_values($results), 0, $limit);
    }

    /**
     * ICD-10 koduna göre resmi tanıyı O(1) karmaşıklıkla getirir.
     */
    public function getByCode(string $code): ?array
    {
        $code = strtoupper(trim($code));
        $map = $this->getCatalogMap();
        return $map[$code] ?? null;
    }

    /**
     * Semptom veya bulgulara göre en olası T.C. Sağlık Bakanlığı ICD-10 tanı önerilerini eşleştirir.
     */
    public function suggestDiagnosisForSymptoms(array $findings): array
    {
        $rawStr = implode(' ', array_map(fn($f) => is_array($f) ? json_encode($f, JSON_UNESCAPED_UNICODE) : (string)$f, $findings));
        $findingsStr = mb_strtolower(str_replace(['İ', 'I', 'Ğ', 'Ü', 'Ş', 'Ö', 'Ç'], ['i', 'ı', 'ğ', 'ü', 'ş', 'ö', 'ç'], $rawStr), 'UTF-8');
        $suggestions = [];
        $matchedCodes = [];

        // 1. Doğrudan ICD-10 Kodu Kontrolü
        foreach ($this->catalog as $item) {
            $codeLower = mb_strtolower($item['code'], 'UTF-8');
            if (str_contains($findingsStr, $codeLower)) {
                $matchedCodes[] = $item['code'];
                $suggestions[] = array_merge($item, [
                    'confidence' => 0.98,
                    'match_reason' => 'Doğrudan ICD-10 Kodu Eşleşmesi',
                    'recommended_drugs' => $this->getRecommendedDrugsForDiagnosis($item['code'])
                ]);
            }
        }

        // 2. Anahtar Kelimelere Göre Dinamik Eşleştirme
        $keywordMap = [
            // Pediatri, Çocuk Sağlığı & Nörogelişimsel (Otizm, Bronşiyolit, Morarma, DEHB) Haritası
            'gözünün içine bakamıyor' => ['F84.0', 'F84.5'],
            'göz temas' => ['F84.0', 'F84.5'],
            'gözün içine bakamıyor' => ['F84.0', 'F84.5'],
            'gözüne bakmıyor' => ['F84.0', 'F84.5'],
            'göz temas kuramıyor' => ['F84.0', 'F84.5'],
            'insanların gözüne' => ['F84.0', 'F84.5'],
            'çok sessiz sakin' => ['F84.0', 'F84.5', 'F32.9'],
            'sessiz sakin' => ['F84.0', 'F84.5'],
            'otizm' => ['F84.0', 'F84.5'],
            'otistik' => ['F84.0'],
            'kendi etrafında dönüyor' => ['F84.0'],
            'adına tepki vermiyor' => ['F84.0'],
            'tepki vermiyor' => ['F84.0', 'F84.5'],
            'konuşması gecikti' => ['F84.0', 'F84.5'],
            'bebeğimin nefes alması zorlaştı' => ['J21.9', 'J05.0', 'P28.5'],
            'nefes alması zorlaştı morarıyor' => ['J21.9', 'J05.0', 'P28.5'],
            'morarıyor' => ['J21.9', 'P28.5', 'R23.0'],
            'bebek morarıyor' => ['J21.9', 'P28.5'],
            'bebeğimin morarması' => ['J21.9', 'P28.5'],
            'bebekte nefes darlığı' => ['J21.9', 'J05.0'],
            'hırıltılı solunum' => ['J21.9', 'J45.9'],
            'hırıltılı nefes' => ['J21.9', 'J45.9'],
            'bronşiyolit' => ['J21.9'],
            'krup' => ['J05.0'],
            'ateşli havale' => ['R56.0'],
            'febril konvülsiyon' => ['R56.0'],
            'aşırı hareketlilik' => ['F90.0'],
            'odaklanma sorunu' => ['F90.0'],
            'dehb' => ['F90.0'],

            // İnsomnia, Uykusuzluk & Uyku Bozuklukları (G47.0 / F51.0)
            'uyuyamıyorum' => ['G47.0', 'F51.0'],
            'gece uyuyamıyorum' => ['G47.0', 'F51.0'],
            'uyku tutmuyor' => ['G47.0', 'F51.0'],
            'uykuya dalamıyorum' => ['G47.0', 'F51.0'],
            'uykusuzluk' => ['G47.0', 'G47.9'],
            'gece uyanıyorum' => ['G47.0'],
            'insomnia' => ['G47.0', 'F51.0'],
            'uyku bozukluğu' => ['G47.9', 'G47.0'],

            // Obezite, Aşırı Kilo & Kilo Verememe (E66.9)
            'obezite' => ['E66.9', 'E66.0'],
            'obez' => ['E66.9'],
            'aşırı kilo' => ['E66.9', 'E66.0'],
            'kilo veremiyorum' => ['E66.9'],
            'şişmanlık' => ['E66.9'],
            'vücut kitle indeksi yüksek' => ['E66.9'],
            'vki yüksek' => ['E66.9'],
            'morbid obezite' => ['E66.2', 'E66.9'],

            // Anoreksiya Nervoza & Yeme Bozukluğu (F50.0)
            'anoreksiya' => ['F50.0', 'F50.9'],
            'anoreksik' => ['F50.0'],
            'anoreksiya nervoza' => ['F50.0'],
            'kilo almaktan korkuyorum' => ['F50.0'],
            'kilo almaktan çok korkuyorum' => ['F50.0'],
            'yemek yiyemiyorum kilo kaybediyorum' => ['F50.0'],
            'yeme bozukluğu' => ['F50.9', 'F50.0'],
            'şiddetli kilo kaybı' => ['F50.0', 'R63.4'],
            'rotavirüs' => ['A08.0'],

            // Gastroenteroloji & Genel Cerrahi 11 Klinik Senaryo Haritası
            'göbek çevresinde başlayıp sağ alt kadrana' => ['K35.8', 'K35.9'],
            'sağ alt kadrana yerleşen' => ['K35.8', 'K35.9'],
            'sağ alt kadran' => ['K35.8', 'K35.9'],
            'apandisit' => ['K35.8', 'K35.9'],
            'yağlı yemek sonrası' => ['K80.2', 'K81.0'],
            'sağ üst kadranda' => ['K80.2', 'K81.0'],
            'sırta vuran şiddetli kramp' => ['K80.2', 'K81.0', 'M54.9'],
            'sağ üst kadran' => ['K80.2', 'K81.0'],
            'safra kesesi' => ['K80.2', 'K81.0'],
            'kolesistit' => ['K81.0'],
            'siyah renkli, cıvık, kötü kokulu dışkılama' => ['K92.1', 'K92.2'],
            'siyah renkli cıvık dışkılama' => ['K92.1'],
            'göz kararması ve belirgin halsizlik' => ['K92.1', 'K92.2', 'R58'],
            'kahve telvesi görünümünde kusma' => ['K92.0', 'K25.0'],
            'epigastrik bölgede yanma' => ['K92.0', 'K25.0', 'K21.0'],
            'göğüs arkasında yanma' => ['K21.0', 'K21.9'],
            'ağza acı su gelmesi' => ['K21.0', 'K21.9'],
            'geğirme/şişkinlik' => ['K21.0', 'K21.9', 'R14'],
            'ağza acı su' => ['K21.0'],
            'reflü' => ['K21.0', 'K21.9'],
            'kanlı-mukuslu ishal' => ['K51.9', 'K50.9', 'A09'],
            'kanlı mukuslu ishal' => ['K51.9', 'K50.9'],
            'günde 6-7 kez' => ['K51.9', 'K50.9'],
            'ülseratif kolit' => ['K51.9'],
            'crohn' => ['K50.9'],
            'idrar renginde koyulaşma' => ['K74.6', 'B18.1', 'R17'],
            'açık renkli dışkılama' => ['K74.6', 'B18.1', 'R17'],
            'gözlerde ve ciltte sararma' => ['K74.6', 'B18.1', 'R17'],
            'tıkanma sarılığı' => ['K74.6', 'K83.1'],
            'kasık bölgesinde' => ['K40.9', 'K40.0', 'K41.9'],
            'ıkınmakla ve ayakta durmakla' => ['K40.9', 'K40.0'],
            'yatınca kaybolan' => ['K40.9', 'K40.0'],
            'kasık fıtığı' => ['K40.9', 'K40.0'],
            'makat bölgesinde' => ['K60.1', 'K60.0', 'I84.9'],
            'cam kesiği tarzında ağrı' => ['K60.1', 'K60.0'],
            'tuvalet kağıdına bulaşan taze kan' => ['K60.1', 'I84.9'],
            'anal fissür' => ['K60.1'],
            'makat çatlağı' => ['K60.1'],
            'gaz-gaita çıkaramama' => ['K56.6', 'K56.7'],
            'gaz gaita çıkaramama' => ['K56.6', 'K56.7'],
            'fışkırır tarzda kusma' => ['K56.6', 'K56.7'],
            'bağırsak tıkanıklığı' => ['K56.6'],
            'ileus' => ['K56.6'],
            'sırta kuşak tarzında yayılan' => ['K85.9', 'K85.0'],
            'kuşak tarzında yayılan' => ['K85.9', 'K85.0'],
            'durdurulamayan bulantı ve kusma' => ['K85.9', 'K85.0'],
            'pankreatit' => ['K85.9', 'K85.0'],

            // Hipoglisemi & Kan Şekeri Düşüklüğü & İnsülin Yan Etkisi Haritası
            'hipoglisemi' => ['E16.2', 'E11.0'],
            'öğün atlanmasına' => ['E16.2'],
            'öğün atlama' => ['E16.2'],
            'insülin sonrası' => ['E16.2'],
            'kan şekeri: 52' => ['E16.2'],
            'kan şekeri 52' => ['E16.2'],
            'kan şekeri düştü' => ['E16.2'],
            'şeker düşüklüğü' => ['E16.2'],
            'ellerde titreme' => ['E16.2', 'R25.1'],
            'kafa karışıklığı' => ['E16.2', 'F05.8', 'R41.0'],

            // PKOS / PCOS, Adet Düzensizliği, Sancılı Regl & Vajinal Mantar Haritası
            'pcos' => ['E28.2'],
            'pkos' => ['E28.2'],
            'polikistik over' => ['E28.2'],
            'polikistik over sendromu' => ['E28.2'],
            'yumurtalık kisti' => ['E28.2', 'N83.2'],
            'çikolata kisti' => ['N80.0'],
            'tüylenme ve adet düzensizliği' => ['E28.2'],
            'aşırı tüylenme' => ['E28.2', 'L68.0'],
            'sivilcelenme ve adet gecikmesi' => ['E28.2'],
            'regl olamıyorum' => ['N91.2'],
            'adet göremiyorum' => ['N91.2'],
            'adet gecikmesi' => ['N91.2', 'E28.2'],
            'regl gecikmesi' => ['N91.2', 'E28.2'],
            'adet rötarı' => ['N91.2'],
            '3 aydır regl olmadım' => ['N91.2', 'E28.2'],
            'sancılı adet' => ['N94.4'],
            'sancılı regl' => ['N94.4'],
            'regl ağrısı' => ['N94.4'],
            'adet sancısı' => ['N94.4'],
            'adet krampı' => ['N94.4'],
            'regl olurken kıvranıyorum' => ['N94.4'],
            'kasık ağrısı ve adet sancısı' => ['N94.4', 'N73.9'],
            'aşırı adet kanaması' => ['N92.0'],
            'pıhtılı aşırı adet kanamam var' => ['N92.0'],
            'aşırı adet kanamam var' => ['N92.0'],
            'reglim 10 gündür durmuyor' => ['N92.0'],
            'reglim durmuyor' => ['N92.0'],
            'pıhtılı kanama' => ['N92.0', 'N93.9'],
            'pıhtılı adet' => ['N92.0'],
            'menoraj' => ['N92.0'],
            'adetim durmuyor' => ['N92.0', 'N93.9'],
            'reglim çok şiddetli' => ['N92.0'],
            'sürekli kanamam var' => ['N92.0', 'N93.9'],
            'aşırı regl' => ['N92.0'],
            'vajinal kaşıntı' => ['N76.0', 'N77.1'],
            'vajinal akıntı' => ['N76.0'],
            'peynirimsi akıntı' => ['N76.0'],
            'kötü kokulu akıntı' => ['N76.0'],
            'vajinada yanma' => ['N76.0'],
            'vajinal mantar' => ['N76.0', 'B37.3'],
            'vajinit' => ['N76.0'],
            'endometriozis' => ['N80.0'],
            'ilişkide ağrı' => ['N80.0', 'N94.2'],
            'cinsel ilişkide şiddetli ağrı' => ['N80.0', 'N94.2'],
            'disparoni' => ['N94.1'],
            'rahimde miyom' => ['D25.9'],
            'miyom' => ['D25.9'],
            'myom' => ['D25.9'],
            'rahimde kitle' => ['D25.9'],
            'vajinismus' => ['N94.2'],

            // Anormal Vajinal Kanama & Pelvik Kramp Ağrısı Haritası
            'alt karın' => ['N94.8', 'N73.9', 'O00.9', 'R10.3'],
            'alt karın bölgesinde' => ['N94.8', 'N73.9', 'O00.9', 'R10.3'],
            'kramp tarzında' => ['N94.8', 'R10.4', 'K58'],
            'lekelenme' => ['N93.9', 'O00.9', 'O20.0'],
            'lekelenme tarzında' => ['N93.9', 'O00.9', 'O20.0'],
            'düzensiz lekelenme' => ['N93.9', 'O00.9'],
            'sat' => ['N93.9', 'O09.9', 'O00.9'],
            'son adet tarihi' => ['N93.9', 'O09.9', 'O00.9'],
            'anormal vajinal kanama' => ['N93.9', 'N93.8'],
            'vajinal kanama' => ['N93.9', 'N93.8'],
            'düzensiz kanama' => ['N93.9', 'N92.6'],

            // Göz Enfeksiyonları, Konjonktivit & Çapaklanma Haritası
            'kanlanma' => ['H10.9', 'H10.0', 'H10.5'],
            'gözde kanlanma' => ['H10.9', 'H10.0', 'H10.5'],
            'batma' => ['H10.9', 'H10.0', 'H04.1'],
            'gözde batma' => ['H10.9', 'H10.0'],
            'sulanma' => ['H10.9', 'H04.2'],
            'gözde sulanma' => ['H10.9', 'H04.2'],
            'çapaklanma' => ['H10.9', 'H10.0', 'H10.5'],
            'yoğun çapaklanma' => ['H10.9', 'H10.0'],
            'kirpiklerde yapışıklık' => ['H10.5', 'H10.9', 'H01.0'],
            'yapışıklık' => ['H10.5', 'H10.9'],
            'konjonktivit' => ['H10.9', 'H10.0'],

            // Acil İç Kanama & Mide Kanaması & Melena & Varis Kanaması Haritası
            'iç kanama' => ['R58', 'K92.2', 'I71.3'],
            'iç kanamam' => ['R58', 'K92.2'],
            'iç kanamam var' => ['R58', 'K92.2'],
            'iç kanama şüphesi' => ['R58', 'K92.2'],
            'mide kanaması' => ['K25.0', 'K92.2', 'K92.0'],
            'mide kanamam' => ['K25.0', 'K92.2', 'K92.0'],
            'mide kanamam var' => ['K25.0', 'K92.2', 'K92.0'],
            'midesi kanıyor' => ['K25.0', 'K92.2'],
            'mideden kan gelmesi' => ['K92.0', 'K25.0'],
            'kan kustum' => ['K92.0', 'K25.0', 'I85.0'],
            'kan kusma' => ['K92.0', 'K25.0', 'I85.0'],
            'ağzımdan kan geldi' => ['K92.0', 'R04.2'],
            'kahve telvesi' => ['K92.0', 'K25.0'],
            'kahve telvesi gibi kusma' => ['K92.0', 'K25.0'],
            'siyah dışkı' => ['K92.1', 'K92.2'],
            'siyah cıvık dışkı' => ['K92.1'],
            'katran gibi dışkı' => ['K92.1'],
            'katran gibi dışkılama' => ['K92.1'],
            'melena' => ['K92.1'],
            'gastrointestinal kanama' => ['K92.2'],
            'gi kanama' => ['K92.2'],
            'varis kanaması' => ['I85.0'],
            'bağırsak kanaması' => ['K92.2', 'K57.8'],

            // Sağlık Bakanlığı Listesi Ek Hastalık Haritası (Menenjit, Hepatit, Glokom, Ürtiker, Şizofreni, Epilepsi, Kalp Krizi, Brusella, COVID, MS)
            'menenjit' => ['G00.9', 'G03.9'],
            'ense sertliği' => ['G00.9'],
            'boynumu eğemiyorum' => ['G00.9'],
            'ışığa bakamıyorum' => ['G00.9', 'H53.8'],
            'hepatit' => ['B18.1', 'B18.2', 'B15.9'],
            'hepatit b' => ['B18.1'],
            'hepatit c' => ['B18.2'],
            'sarılık' => ['B18.1', 'B18.2', 'R17'],
            'gözlerimde sararma' => ['B18.1', 'R17'],
            'cildim sarardı' => ['B18.1', 'R17'],
            'glokom' => ['H40.1', 'H40.9'],
            'göz tansiyonu' => ['H40.1', 'H40.9'],
            'gözümde basınç' => ['H40.1'],
            'ürtiker' => ['L50.1', 'L50.0'],
            'kurdeşen' => ['L50.1', 'L50.0'],
            'kaşıntılı kabarcıklar' => ['L50.1'],
            'şizofreni' => ['F20.9', 'F20.0'],
            'gaipten sesler' => ['F20.9', 'R44.0'],
            'sesler duyuyorum' => ['F20.9', 'R44.0'],
            'depresyon' => ['F32.9', 'F33.9'],
            'depresyondayım' => ['F32.9', 'F33.9'],
            'zevk alamıyorum' => ['F32.9'],
            'epilepsi' => ['G40.9', 'G40.4'],
            'sara nöbeti' => ['G40.9'],
            'sara' => ['G40.9'],
            'bilincim kapandı kasıldım' => ['G40.9', 'R56.0'],
            'kalp krizi' => ['I21.9', 'I20.0'],
            'enfarktüs' => ['I21.9'],
            'brusella' => ['A23.9', 'A23.0'],
            'bruselloz' => ['A23.9', 'A23.0'],
            'dalgalı ateş' => ['A23.9'],
            'çiğ peynir' => ['A23.9'],
            'taze peynir' => ['A23.9'],
            'gece sırılsıklam terleme' => ['A23.9', 'R61.9'],
            'trigeminal nevralji' => ['G50.0'],
            'şimşek çakar gibi' => ['G50.0'],
            'elektrik çarpması ağrısı' => ['G50.0'],
            'yüzümde bıçak saplanıyor' => ['G50.0'],
            'covid' => ['U07.1'],
            'covid-19' => ['U07.1'],
            'koronavirüs' => ['U07.1'],
            'tat ve koku alamıyorum' => ['U07.1', 'R43.8'],
            'koku kaybı' => ['U07.1', 'R43.8'],
            'tat kaybı' => ['U07.1', 'R43.8'],
            'multipl skleroz' => ['G35'],
            'ms hastalığı' => ['G35'],
            'ms hastasıyım' => ['G35'],
            'bacaklarımda uyuşma ve denge kaybı' => ['G35', 'G62.9'],

            // Pediatri & Çocuk Sağlığı & Otizm & DEHB & Havale Haritası
            'otizm' => ['F84.0', 'F84.5'],
            'otizmli' => ['F84.0', 'F84.5'],
            'otistik' => ['F84.0'],
            'otizm spektrumu' => ['F84.0', 'F84.5'],
            'göz teması kurmuyor' => ['F84.0'],
            'göz teması yok' => ['F84.0'],
            'göz teması kuramıyor' => ['F84.0'],
            'konuşamıyor' => ['F84.0', 'F80.9'],
            'konuşma gecikmesi' => ['F80.9', 'F84.0'],
            'sosyal iletişim kuramıyor' => ['F84.0', 'F84.5'],
            'kendi etrafında dönüyor' => ['F84.0'],
            'tekrarlayıcı hareketler' => ['F84.0'],
            'asperger' => ['F84.5'],
            'hiperaktif' => ['F90.0'],
            'hiperaktivite' => ['F90.0'],
            'dikkat eksikliği' => ['F90.0'],
            'dehb' => ['F90.0'],
            'odaklanamıyor' => ['F90.0'],
            'yerinde duramıyor' => ['F90.0'],
            'ders çalışırken dikkati dağılıyor' => ['F90.0'],
            'çocukta aşırı hareketlilik' => ['F90.0'],
            'havale' => ['R56.0'],
            'ateşli havale' => ['R56.0'],
            'ateşlenip kasıldı' => ['R56.0'],
            'gözleri kaydı kasıldı' => ['R56.0'],
            'ateşli nöbet' => ['R56.0'],
            'rotavirüs' => ['A08.0'],
            'çocukta ishal' => ['A08.0', 'A09'],
            'bebekte ishal' => ['A08.0', 'A09'],
            'çocuk kusma' => ['A08.0', 'R11'],
            'bronşiyolit' => ['J21.9'],
            'bebekte hırıltı' => ['J21.9', 'J45.9'],
            'hırıltılı solunum' => ['J21.9', 'J45.9'],
            'kızamık' => ['B05.9'],
            'su çiçeği' => ['B01.9'],
            'el ayak ağız' => ['B08.4'],
            'el ayak ağız hastalığı' => ['B08.4'],

            // Kadın Doğum & Gebelik & Gebe Kalma / İnfertilite Haritası
            'hamilelik' => ['O09.9', 'O21.0', 'O26.8'],
            'hamileyim' => ['O09.9', 'O21.0', 'O26.8'],
            'hamile kalma' => ['N97.9', 'O09.9'],
            'hamile kalamıyorum' => ['N97.9'],
            'gebelik' => ['O09.9', 'O21.0', 'O26.8'],
            'gebeyim' => ['O09.9', 'O21.0'],
            'gebe kalmak' => ['N97.9', 'O09.9'],
            'gebe kalamıyorum' => ['N97.9'],
            'çocuk istiyoruz' => ['N97.9'],
            'çocuk olmuyor' => ['N97.9'],
            'çocuğum olmuyor' => ['N97.9'],
            'bebek istiyoruz' => ['N97.9'],
            'gebe kalamama' => ['N97.9'],
            'infertilit' => ['N97.9'],
            'kısırlık' => ['N97.9'],
            'yumurtlama' => ['N97.9'],
            'yumurtlama sorunu' => ['N97.9', 'E28.2'],
            'gebelik bulantısı' => ['O21.0'],
            'hamilelikte mide bulantısı' => ['O21.0'],
            'gebelik kusması' => ['O21.0'],
            'sabah bulantısı' => ['O21.0'],
            'hamilelik bulantısı' => ['O21.0'],
            'gebelik takibi' => ['O09.9'],
            'hamilelik takibi' => ['O09.9'],
            'hafta hamileyim' => ['O09.9'],
            'haftalık gebeyim' => ['O09.9'],
            'folik asit' => ['O09.9', 'N97.9'],
            'aşerme' => ['O26.8'],
            'gebelik şekeri' => ['O24.4'],
            'gebelik tansiyonu' => ['O14.9'],

            // Grip & Soğuk Algınlığı & Nezle Haritası
            'grip' => ['J11.1', 'J10.1', 'J06.9'],
            'gribim' => ['J11.1', 'J10.1', 'J06.9'],
            'grip oldum' => ['J11.1', 'J10.1', 'J06.9'],
            'grip var' => ['J11.1', 'J10.1'],
            'influenza' => ['J11.1', 'J10.1'],
            'soğuk algınlığı' => ['J00', 'J11.1', 'J06.9'],
            'soğuk algınlığım' => ['J00', 'J11.1', 'J06.9'],
            'soğuk aldım' => ['J00', 'J11.1', 'J06.9'],
            'soğuk almışım' => ['J00', 'J11.1', 'J06.9'],
            'üşüttüm' => ['J00', 'J11.1', 'J06.9'],
            'üşütmüşüm' => ['J00', 'J11.1', 'J06.9'],
            'nezle' => ['J00', 'J06.9'],
            'nezleyim' => ['J00', 'J06.9'],
            'nezle oldum' => ['J00', 'J06.9'],
            'burun akıntısı' => ['J00', 'J30.4'],
            'burun tıkanıklığı' => ['J00', 'J30.4', 'J01.9'],
            'burnum tıkalı' => ['J00', 'J30.4', 'J01.9'],
            'burnum akıyor' => ['J00', 'J30.4'],
            'burnum' => ['J00', 'J30.4'],
            'hapşırık' => ['J00', 'J30.4'],
            'hapşırıyorum' => ['J00', 'J30.4'],
            'hapşırık var' => ['J00', 'J30.4'],
            'vücut kırgınlığı' => ['J11.1', 'R53'],
            'kırgınlık' => ['J11.1', 'R53'],
            'kırgınım' => ['J11.1', 'R53'],
            'vücudum kırgın' => ['J11.1', 'R53'],
            'her yerim ağrıyor' => ['J11.1', 'M79.67'],
            'kemiklerim sızlıyor' => ['J11.1', 'M89.8'],
            'kemiklerim ağrıyor' => ['J11.1', 'M89.8'],
            'eklemlerim sızlıyor' => ['J11.1', 'M25.5'],
            'üşüme titreme' => ['J11.1', 'R50.9'],
            'titreme' => ['J11.1', 'R50.9'],
            'titriyorum' => ['J11.1', 'R50.9'],
            'geniz' => ['J30.4', 'J31.0', 'J01.9', 'J06.9'],
            'akıntı' => ['J30.4', 'J31.0', 'J01.9'],
            'geniz akıntısı' => ['J30.4', 'J31.0', 'J01.9'],
            'burun' => ['J30.4', 'J01.9', 'J00'],
            'sinüzit' => ['J01.9', 'J32.9'],
            'rinit' => ['J30.4', 'J31.0'],
            'boğaz' => ['J02.9', 'J03.9', 'J06.9'],
            'ateş' => ['J11.1', 'J06.9', 'A09', 'R50.9'],
            'öksürük' => ['J11.1', 'J44.9', 'J45.9', 'J20.9', 'J06.9'],
            'astım' => ['J45.9', 'J45.0'],
            'balgam' => ['J44.9', 'J20.9'],
            'nefes' => ['J96.0', 'J45.9', 'J44.9'],
            'tansiyon' => ['I10', 'I11.0', 'I15.0'],
            'hipertansiyon' => ['I10', 'I11.0', 'I15.0'],
            'şeker' => ['E11.9', 'E11.2', 'E10.9'],
            'diyabet' => ['E11.9', 'E11.2'],
            'göğüs' => ['I20.9', 'R07.3', 'J45.9'],
            'kalp' => ['I50.9', 'I25.1'],
            'mide' => ['K25.9', 'K21.0', 'K29.7'],
            'reflü' => ['K21.0'],
            'bel' => ['M54.5', 'M51.1'],
            'diz' => ['M17.0'],
            'baş' => ['G44.2', 'G43.9'],
            'migren' => ['G43.9'],
            'alerji' => ['L50.0', 'J30.4'],
            'kaşıntı' => ['L50.0'],
            'uyku' => ['G47.9', 'G47.0', 'G47.3', 'F51.0'],
            'uyku bozukluğu' => ['G47.9', 'G47.0', 'G47.3'],
            'uykusuzluk' => ['G47.0', 'F51.0'],
            'insomnia' => ['G47.0', 'F51.0'],
            'apne' => ['G47.3'],
            'unutkanlık' => ['R41.3', 'G30.9', 'F06.7'],
            'aşırı unutkanlık' => ['R41.3', 'G30.9', 'F06.7'],
            'hafıza' => ['R41.3', 'G30.9'],
            'odaklanma' => ['F90.0', 'F06.7', 'F41.1'],
            'odaklanma sorunu' => ['F90.0', 'F06.7'],
            'dikkat' => ['F90.0', 'F06.7'],
            'çınlama' => ['H93.1', 'H81.1', 'H91.9'],
            'kulak çınlaması' => ['H93.1', 'H81.1'],
            'tinnitus' => ['H93.1'],
            'karıncalanma' => ['R20.2', 'G62.9', 'G56.0'],
            'karıncalanma hissi' => ['R20.2', 'G62.9'],
            'uyuşma' => ['R20.2', 'G62.9', 'G56.0'],
            'yorgunluk' => ['R53', 'D50.9', 'E03.9'],
            'yorgunum' => ['R53', 'D50.9', 'E03.9'],
            'yorgun' => ['R53', 'D50.9', 'E03.9'],
            'kronik yorgunluk' => ['R53', 'D50.9'],
            'halsizlik' => ['R53', 'D50.9'],
            'halsizim' => ['R53', 'D50.9', 'E03.9'],
            'halsiz' => ['R53', 'D50.9'],
            'üşüme' => ['E03.9', 'I73.9', 'D50.9'],
            'üşüyorum' => ['E03.9', 'D50.9', 'I73.9'],
            'sürekli üşüyorum' => ['E03.9', 'D50.9', 'I73.9'],
            'sürekli yorgunum' => ['R53', 'D50.9', 'E03.9'],
            'sürekli halsizim' => ['R53', 'D50.9', 'E03.9'],
            'kıymık' => ['W45', 'S91.3'],
            'kıymak' => ['W45', 'S91.3'],
            'kıymık battı' => ['W45', 'S91.3'],
            'kıymak battı' => ['W45', 'S91.3'],
            'battı' => ['W45', 'S91.3'],
            'cam battı' => ['W45', 'S91.3'],
            'çivi battı' => ['W45', 'S91.3'],
            'diken battı' => ['W45', 'S91.3'],
            'iğne battı' => ['W45', 'S91.3'],
            'yabancı cisim' => ['W45', 'S91.3'],

            // Genel Vücut Bölgeleri & "... Ağrıyor" Şikayet Haritası
            'kolum ağrıyor' => ['M79.67', 'S52.9'],
            'kolum' => ['M79.67', 'S52.9'],
            'bacağım ağrıyor' => ['M17.0', 'S82.9', 'M79.67'],
            'bacağım' => ['M17.0', 'S82.9'],
            'karnım ağrıyor' => ['R10.4', 'K29.7'],
            'karnım' => ['R10.4', 'K29.7'],
            'midem ağrıyor' => ['K25.9', 'K29.7', 'K21.0'],
            'midem' => ['K25.9', 'K29.7', 'K21.0'],
            'başım ağrıyor' => ['G44.2', 'G43.9', 'I10'],
            'başım' => ['G44.2', 'G43.9'],
            'kafam ağrıyor' => ['G44.2', 'G43.9'],
            'belim ağrıyor' => ['M54.5', 'M51.1'],
            'belim' => ['M54.5', 'M51.1'],
            'boynum ağrıyor' => ['M54.2', 'M50.9'],
            'boynum' => ['M54.2', 'M50.9'],
            'sırtım ağrıyor' => ['M54.9', 'M54.5'],
            'sırtım' => ['M54.9'],
            'dizim ağrıyor' => ['M17.0', 'M25.5'],
            'dizim' => ['M17.0', 'M25.5'],
            'omzum ağrıyor' => ['S43.0', 'M25.5'],
            'omzum' => ['S43.0', 'M25.5'],
            'bileğim ağrıyor' => ['S93.4', 'M25.5'],
            'bileğim' => ['S93.4', 'M25.5'],
            'eklemim ağrıyor' => ['M25.5', 'M19.9'],
            'eklemim' => ['M25.5'],
            'parmağım ağrıyor' => ['S62.8', 'M25.5'],
            'parmağım' => ['S62.8', 'M25.5'],
            'ayağım ağrıyor' => ['S93.4', 'M17.0'],
            'ayağım' => ['S93.4', 'M17.0'],
            'topuğum ağrıyor' => ['M17.0'],
            'topuğum' => ['M17.0'],
            'boğazım ağrıyor' => ['J02.9', 'J03.9', 'J06.9'],
            'boğazım' => ['J02.9', 'J03.9'],
            'kulağım ağrıyor' => ['H66.9', 'H93.1'],
            'kulağım' => ['H66.9'],
            'gözüm ağrıyor' => ['H10.9', 'H53.8'],
            'gözüm' => ['H10.9'],
            'dişim ağrıyor' => ['K08.8', 'K02.9'],
            'dişim' => ['K08.8', 'K02.9'],
            'göğsüm ağrıyor' => ['I20.9', 'R07.3', 'I20.0'],
            'göğsüm' => ['I20.9', 'R07.3'],
            'kalbim ağrıyor' => ['I20.9', 'I25.1'],
            'kalbim' => ['I20.9'],
            'ağrıyor' => ['M54.9'],
            'ağrım var' => ['M54.9'],
            'sancım var' => ['R10.4', 'K29.7'],
            'sancıyor' => ['R10.4', 'K29.7'],
            'sızlıyor' => ['M79.67', 'M54.9'],

            // Tahriş & İritasyon & Pişik

            'tahriş' => ['L24.9', 'L25.9', 'L30.9'],
            'tahriş oldu' => ['L24.9', 'L25.9', 'L30.9'],
            'tahriş var' => ['L24.9', 'L25.9', 'L30.9'],
            'cilt tahrişi' => ['L24.9', 'L30.9'],
            'cilt tahriş' => ['L24.9', 'L30.9'],
            'cildim tahriş' => ['L24.9', 'L30.9'],
            'deri tahrişi' => ['L24.9', 'L30.9'],
            'iritasyon' => ['L24.9', 'L25.9'],
            'pişik' => ['L22', 'L24.9'],
            'boğaz tahrişi' => ['J31.2', 'J02.9'],
            'boğazım tahriş' => ['J31.2', 'J02.9'],
            'boğaz tahriş' => ['J31.2', 'J02.9'],
            'göz tahrişi' => ['H10.9', 'H04.1'],
            'gözüm tahriş' => ['H10.9', 'H04.1'],
            'göz tahriş' => ['H10.9', 'H04.1'],


            'mantar' => ['B35.3', 'B35.1', 'B35.9'],
            'mantar çıktı' => ['B35.3', 'B35.1', 'B35.9'],
            'ayak mantarı' => ['B35.3'],
            'ayağımda mantar' => ['B35.3'],
            'tırnak mantarı' => ['B35.1'],
            'tırnağımda mantar' => ['B35.1'],
            'parmak arası mantar' => ['B35.3'],


            // Kırık & Çıkık & Burkulma
            'kırık' => ['S52.9', 'S82.9', 'S62.8'],
            'kırıldı' => ['S52.9', 'S82.9', 'S62.8'],
            'kolum kırıldı' => ['S52.9'],
            'bacağım kırıldı' => ['S82.9'],
            'bileğim kırıldı' => ['S62.8'],
            'parmağım kırıldı' => ['S62.8'],
            'çıkık' => ['S43.0', 'S63.1', 'S93.4'],
            'eklem çıktı' => ['S43.0', 'S63.1'],
            'omzum çıktı' => ['S43.0'],
            'parmağım çıktı' => ['S63.1'],
            'bileğim çıktı' => ['S93.4'],
            'burkulma' => ['S93.4'],
            'burkuldu' => ['S93.4'],
            'bileğim burkuldu' => ['S93.4'],
            'düşme' => ['S52.9', 'S82.9', 'S93.4'],
            'incinme' => ['S93.4', 'M79.67'],


            // Kesilme & Açık Yara & Kanama
            'kesildi' => ['S61.9', 'S51.9', 'T14.1'],
            'kesik' => ['S61.9', 'S51.9', 'T14.1'],
            'kesilme' => ['S61.9', 'T14.1'],
            'elim kesildi' => ['S61.9'],
            'parmağım kesildi' => ['S61.9'],
            'kolum kesildi' => ['S51.9'],
            'bıçak kesti' => ['S61.9', 'T14.1'],
            'cam kesti' => ['S61.9', 'T14.1'],
            'jilet kesti' => ['S61.9', 'T14.1'],
            'derin kesik' => ['S61.9', 'T14.1'],
            'kanama' => ['S61.9', 'T14.1'],
            'dikiş' => ['S61.9', 'T14.1'],

            // Onkoloji & Kanser & Tümör
            'kanser' => ['C80', 'C50.9', 'C34.9', 'C18.9', 'C16.9'],
            'tümör' => ['C80', 'C50.9', 'C34.9'],
            'kitle' => ['C80', 'C50.9', 'C85.9'],
            'meme kanseri' => ['C50.9'],
            'memede kitle' => ['C50.9'],
            'akciğer kanseri' => ['C34.9'],
            'kanlı balgam' => ['C34.9', 'J44.9'],
            'kolon kanseri' => ['C18.9'],
            'bağırsak kanseri' => ['C18.9'],
            'mide kanseri' => ['C16.9'],
            'prostat kanseri' => ['C61'],
            'lösemi' => ['C91.0'],
            'kan kanseri' => ['C91.0'],
            'lenfoma' => ['C85.9'],
            'lenf bezi şişmesi' => ['C85.9'],
            'boyunda kitle' => ['C85.9'],

            // Diş, Ağız & Çene
            'diş' => ['K08.8', 'K02.9'],
            'diş ağrısı' => ['K08.8', 'K02.9'],
            'dişim ağrıyor' => ['K08.8', 'K02.9'],
            'diş zonklaması' => ['K08.8', 'K04.7'],
            'diş çürüğü' => ['K02.9'],
            'çürük diş' => ['K02.9'],
            'diş apsei' => ['K04.7'],
            'diş iltihabı' => ['K04.7', 'K05.1'],
            'dişim şişti' => ['K04.7'],
            'yüzüm şişti' => ['K04.7'],
            'diş eti kanaması' => ['K05.1'],
            'diş eti iltihabı' => ['K05.1'],
            'diş eti' => ['K05.1'],
            'ağız yarası' => ['K12.0'],
            'aft' => ['K12.0'],
            'ağızda aft' => ['K12.0'],
            'çene ağrısı' => ['K07.6'],
            'çenem ağrıyor' => ['K07.6'],


            'baygınlık' => ['R55', 'R42', 'I95.9'],
            'baygınlık hissi' => ['R55', 'R42'],
            'bayılma' => ['R55', 'R42'],
            'şişkinlik' => ['R14', 'K58'],
            'gaz' => ['R14', 'K58'],
            'şişkinlik ve gaz' => ['R14', 'K58'],
            'karın ağrısı' => ['R10.4', 'K29.7'],
            'ishal' => ['A09', 'K58'],
            'kabız' => ['K59.0', 'K58'],
            'kabızlık' => ['K59.0', 'K58'],
            'yutma' => ['R13', 'K20', 'K21.0'],
            'yutma güçlüğü' => ['R13', 'K20'],
            'iştahsızlık' => ['R63.0', 'R53'],
            'ağız kokusu' => ['R19.6', 'K12.0'],
            'ekşi geğirme' => ['K21.0', 'K30'],
            'geğirme' => ['K21.0', 'K30'],
            'çarpıntı' => ['R00.2', 'I49.9', 'I20.9'],
            'göğüs ağrısı' => ['I20.9', 'R07.3'],
            'tansiyon dalgalanması' => ['I10', 'I95.9'],
            'el ve ayaklarda üşüme' => ['I73.9'],
            'morarma' => ['R23.0', 'D69.6'],
            'çabuk yorulma' => ['I50.0', 'I50.9', 'D50.9'],
            'boyun damarlarında şişme' => ['I50.0', 'I50.9'],
            'soğuk terleme' => ['R61.9', 'I21.9', 'I20.9'],
            'ödem' => ['R60.0', 'I50.9'],
            'bacaklarda ödem' => ['R60.0', 'I50.9'],
            'eklem ağrısı' => ['M25.5', 'M19.9', 'M17.0'],
            'eklem' => ['M25.5', 'M19.9'],
            'bel ağrısı' => ['M54.5', 'M51.1'],
            'boyun tutulması' => ['M54.2', 'M50.9'],
            'boyun ağrısı' => ['M54.2', 'M50.9'],
            'kas krampları' => ['R25.2', 'M65.9'],
            'kramp' => ['R25.2'],
            'sırt ağrısı' => ['M54.9', 'M54.5'],
            'sırt' => ['M54.9'],
            'hareket kısıtlılığı' => ['M25.6', 'M25.5'],
            'kas güçsüzlüğü' => ['M62.8', 'M79.7'],
            'eklem şişliği' => ['M25.4', 'M25.5'],
            'kemik ağrısı' => ['M89.8', 'M81.0'],
            'kemik' => ['M89.8'],
            'topallama' => ['R26.2', 'M17.0'],
            'kaşıntı' => ['B35.3', 'L29.9', 'L50.0'],
            'döküntü' => ['L27.0', 'L30.9', 'L50.0'],
            'cilt döküntüsü' => ['L27.0', 'L30.9'],
            'kızarıklık' => ['R23.0', 'L50.9', 'L30.9'],
            'kuruluk' => ['L85.3', 'L30.9'],
            'aşırı kuruluk' => ['L85.3'],
            'saç dökülmesi' => ['L65.9', 'L63.0'],
            'tırnak kırılması' => ['L60.3'],
            'ciltte solukluk' => ['R23.1', 'D50.9'],
            'solukluk' => ['R23.1', 'D50.9'],
            'terleme bozukluğu' => ['L74.9', 'R61.9'],
            'sivilce artışı' => ['L70.0'],
            'sivilce' => ['L70.0'],
            'morluklar' => ['R23.0', 'D69.6'],
            'morluk' => ['R23.0', 'D69.6'],
            'ateş yükselmesi' => ['R50.9', 'J06.9'],
            'ateş' => ['R50.9', 'J06.9'],
            'kilo kaybı' => ['R63.4', 'E05.9', 'E11.9'],
            'aşırı kilo alma' => ['E66.9', 'E03.9'],
            'kilo alma' => ['E66.9'],
            'idrarda yanma' => ['N39.0', 'R30.0'],
            'idrar yanması' => ['N39.0', 'R30.0'],
            'sık idrara çıkma' => ['R30.0', 'N39.0', 'E11.9'],
            'göz bulanıklığı' => ['H53.8', 'H52.2'],
            'bulanık görme' => ['H53.8'],
            'göz sulanması' => ['H04.2', 'H10.9'],
            'ağız kuruluğu' => ['R68.2', 'E11.9'],
            // Kardiyovasküler & Angina Pectoris & MI (Göğüs Ağrısı, Baskı, Sol Kol, Çene, Soğuk Ter)
            'göğs' => ['I20.0', 'I20.9', 'I21.9', 'R07.3'],
            'göğüs' => ['I20.0', 'I20.9', 'I21.9', 'R07.3'],
            'baskı' => ['I20.0', 'I20.9', 'I21.9'],
            'fil otur' => ['I20.0', 'I21.9', 'I20.9'],
            'sıkışma' => ['I20.0', 'I20.9', 'I21.9'],
            'sol kol' => ['I20.0', 'I21.9', 'I20.9'],
            'koluma' => ['I20.0', 'I21.9', 'M79.67'],
            'çeneme' => ['I20.0', 'I21.9', 'K07.6'],
            'soğuk ter' => ['R61.9', 'I21.9', 'I20.0', 'I20.9'],
            'ter bas' => ['R61.9', 'I21.9', 'I20.0'],
            'ter dök' => ['R61.9', 'I21.9'],
            'sızı' => ['I20.0', 'I20.9', 'M54.9'],
            'merdiven' => ['I20.0', 'I20.9', 'I50.9'],
            'yokuş' => ['I20.0', 'I20.9', 'I50.9'],
            // Üroloji, Renal Kolik, Üreter & Böbrek Taşı Haritası
            'kasık bölgesine doğru vuran' => ['N20.1', 'N23', 'N20.0'],
            'kasığa doğru vuran' => ['N20.1', 'N23', 'N20.0'],
            'kasığa vuran' => ['N20.1', 'N23', 'N20.0'],
            'dalgalı (kolik) tarzda' => ['N20.1', 'N23', 'N20.0'],
            'kolik tarzda' => ['N20.1', 'N23', 'N20.0'],
            'dalgalı (kolik)' => ['N20.1', 'N23', 'N20.0'],
            'kıvrandırıcı' => ['N20.1', 'N23', 'N20.0'],
            'kıvrandırıcı ağrı' => ['N20.1', 'N23', 'N20.0'],
            'sol bel/yan' => ['N20.1', 'N23', 'N20.0'],
            'sağ bel/yan' => ['N20.1', 'N23', 'N20.0'],
            'bel/yan bölgesinde' => ['N20.1', 'N23', 'N20.0'],
            'yan bölgesinde aniden başlayan' => ['N20.1', 'N23', 'N20.0'],
            'flank ağrısı' => ['N20.1', 'N23', 'N20.0'],
            'renal kolik' => ['N23', 'N20.1', 'N20.0'],
            'üreter taşı' => ['N20.1', 'N23'],
            'böbrek taşı' => ['N20.0', 'N20.1', 'N23'],

            // Gastroenteroloji, Mide, Reflü & Gastrit Haritası
            'ağza acı/ekşi su gelmesi' => ['K21.9', 'K21.0', 'K29.7'],
            'ağza acı su gelmesi' => ['K21.9', 'K21.0', 'K29.7'],
            'ağza ekşi su gelmesi' => ['K21.9', 'K21.0', 'K29.7'],
            'ağza acı su' => ['K21.9', 'K21.0'],
            'ağza ekşi su' => ['K21.9', 'K21.0'],
            'göğüs arkasında yukarı doğru yayılan yanma' => ['K21.9', 'K21.0'],
            'göğüs arkasında yanma' => ['K21.9', 'K21.0', 'K29.7'],
            'yukarı doğru yayılan yanma' => ['K21.9', 'K21.0'],
            'ağır yemeklerden sonra' => ['K21.9', 'K29.7', 'K30'],
            'gece düz yatarken artan öksürük' => ['K21.9', 'K21.0'],
            'yatarken artan öksürük' => ['K21.9', 'K21.0'],
            'reflü öksürüğü' => ['K21.9', 'K21.0'],
            'reflü' => ['K21.9', 'K21.0'],
            'gastrit' => ['K29.7'],
            'mide yanması' => ['K21.9', 'K29.7', 'K30'],
            'mide ekşimesi' => ['K21.9', 'K29.7', 'K30'],

            // Enfeksiyon Hastalıkları, İnfeksiyöz Gastroenterit & Akut İshal Haritası
            '24 saattir devam eden sulu ishal' => ['A09.9', 'A08.4'],
            'sulu ishal' => ['A09.9', 'A08.4', 'A09.0'],
            'günde 6-7 kez' => ['A09.9', 'A08.4'],
            'günde 5' => ['A09.9', 'A08.4'],
            'günde 6' => ['A09.9', 'A08.4'],
            'günde 7' => ['A09.9', 'A08.4'],
            'infeksiyöz gastroenterit' => ['A09.9', 'A09.0'],
            'gastroenterit' => ['A09.9', 'A08.4', 'K52.9'],
            'akut ishal' => ['A09.9', 'A08.4'],
            'bakteriyel ishal' => ['A09.0'],
            'viral gastroenterit' => ['A08.4'],
            'ishal ve ateş' => ['A09.9', 'A09.0'],
            'ishal ve kusma' => ['A09.9', 'A08.4'],

            // Fiziksel Tıp, Rehabilitasyon & Ortopedi Omuz Hastalıkları Haritası
            'omzunu yukarı kaldırırken' => ['M75.1', 'M75.4', 'M75.0'],
            'omzu yukarı kaldırırken' => ['M75.1', 'M75.4', 'M75.0'],
            'omzunu arkaya götürürken' => ['M75.1', 'M75.0', 'M75.4'],
            'omzu arkaya götürürken' => ['M75.1', 'M75.0', 'M75.4'],
            'gece ağrıyan tarafın üzerine yatamama' => ['M75.1', 'M75.0', 'M75.5'],
            'ağrıyan tarafın üzerine yatamama' => ['M75.1', 'M75.0', 'M75.5'],
            'tarafın üzerine yatamama' => ['M75.1', 'M75.0'],
            'omuz hareketlerinde kısıtlılık' => ['M75.1', 'M75.0', 'M75.9'],
            'omuz kısıtlılığı' => ['M75.0', 'M75.1'],
            'rotatör manşet' => ['M75.1'],
            'donuk omuz' => ['M75.0'],
            'omuz sıkışması' => ['M75.4'],
            'omuz bursiti' => ['M75.5'],
            'omuz ağrısı' => ['M75.1', 'M75.0', 'M75.9'],

            // Pediatrik Döküntülü Hastalıklar & El-Ayak-Ağız Hastalığı Haritası
            'el/ayak tabanlarında kırmızı döküntüler' => ['B08.4'],
            'el/ayak tabanlarında döküntü' => ['B08.4'],
            'el ve ayak tabanlarında' => ['B08.4'],
            'el/ayak tabanlarında' => ['B08.4'],
            'ağız içinde küçük yaralar (aft)' => ['B08.4', 'B08.5'],
            'ağız içinde küçük yaralar' => ['B08.4', 'B08.5'],
            'ağız içinde yaralar' => ['B08.4', 'B08.5'],
            'ağız içi aft' => ['B08.4', 'B08.5'],
            'el-ayak-ağız' => ['B08.4'],
            'el ayak ağız' => ['B08.4'],
            'el ayak döküntüsü' => ['B08.4'],
            'coxsackie' => ['B08.4'],

            // KBB, Otoloji, Nöroloji, Vertigo & BPPV Haritası
            'yatakta dönerken veya başını yukarı kaldırırken' => ['H81.1', 'H81.9'],
            'yatakta dönerken' => ['H81.1', 'H81.9'],
            'başını yukarı kaldırırken' => ['H81.1', 'H81.9'],
            'etrafın dönmesi şeklinde' => ['H81.1', 'H81.9', 'R42'],
            'etrafın dönmesi' => ['H81.1', 'H81.9', 'R42'],
            'etraf dönmesi' => ['H81.1', 'H81.9', 'R42'],
            'şiddetli baş dönmesi' => ['H81.1', 'H81.9', 'R42'],
            'baş dönmesi' => ['H81.1', 'H81.9', 'R42'],
            'bppv' => ['H81.1'],
            'vertigo' => ['H81.1', 'H81.9', 'R42'],
            'kristal oynaması' => ['H81.1'],
            'kristal kayması' => ['H81.1'],

            // Psikiyatri, Panik Atak, Panik Bozukluk & Anksiyete Haritası
            'kontrolü kaybetme korkusu' => ['F41.0'],
            'kontrolü kaybetme' => ['F41.0', 'F41.1'],
            'ölüm korkusu' => ['F41.0'],
            'çıldırma korkusu' => ['F41.0'],
            'panik' => ['F41.0'],
            'panik atak' => ['F41.0'],
            'panik bozukluk' => ['F41.0'],
            'ellerde titreme/karıncalanma' => ['F41.0', 'R20.2'],
            'titreme/karıncalanma' => ['F41.0', 'R20.2'],
            'ellerde titreme' => ['F41.0', 'E16.2', 'R25.1'],
            'ellerde karıncalanma' => ['F41.0', 'R20.2'],
            'nefes alamama hissi' => ['F41.0', 'J96.0', 'J45.9'],
            'aniden başlayan göğüste sıkışma' => ['F41.0', 'I20.9'],
            'kalp çarpıntısı' => ['F41.0', 'R00.2', 'I49.9'],
            'iç sıkıntısı' => ['F41.1', 'F41.9'],
            'evham' => ['F41.1'],
            'anksiyete hissi' => ['F41.1', 'F41.9'],
            'anksiyete' => ['F41.0', 'F41.1', 'F41.9'],
            'depresyon' => ['F32.9']
        ];

        // 2. Çoklu Anahtar Kelime Ağırlıklı Puanlama (Multi-Keyword Weighted Scoring)
        $codeScores = [];
        $codeReasons = [];

        foreach ($keywordMap as $kw => $codes) {
            if (str_contains($findingsStr, $kw)) {
                foreach ($codes as $code) {
                    if (!isset($codeScores[$code])) {
                        $codeScores[$code] = 0;
                        $codeReasons[$code] = [];
                    }
                    $codeScores[$code] += 1;
                    if (count($codeReasons[$code]) < 3) {
                        $codeReasons[$code][] = $kw;
                    }
                }
            }
        }

        // Puanlara göre yüksekten düşüğe sırala
        arsort($codeScores);

        foreach ($codeScores as $code => $score) {
            if (!in_array($code, $matchedCodes)) {
                $item = $this->getByCode($code);
                if ($item) {
                    $matchedCodes[] = $code;
                    $confidence = min(0.98, round(0.82 + ($score * 0.05), 2));
                    $reasonStr = implode(', ', $codeReasons[$code]);
                    $suggestions[] = array_merge($item, [
                        'confidence' => $confidence,
                        'match_reason' => "'{$reasonStr}' semptom bulguları ile eşleşti ({$score} kriter)",
                        'recommended_drugs' => $this->getRecommendedDrugsForDiagnosis($code)
                    ]);
                }
            }
        }

        // 3. Genel metin araması (eğer hala az eşleşme varsa)
        if (count($suggestions) < 3) {
            $searchResults = $this->search($findingsStr, 5);
            foreach ($searchResults as $item) {
                if (!in_array($item['code'], $matchedCodes)) {
                    $matchedCodes[] = $item['code'];
                    $suggestions[] = array_merge($item, [
                        'confidence' => 0.88,
                        'match_reason' => 'Klinik Metin Benzerliği',
                        'recommended_drugs' => $this->getRecommendedDrugsForDiagnosis($item['code'])
                    ]);
                }
            }
        }

        // 🟢 PEDİATRİK YAŞ & KLİNİK BAĞLAM SÜZGECİ (Çocuk/Bebek şikayetlerinde Yetişkin Kalp Krizi engelleme)
        $isPediatricContext = str_contains($findingsStr, 'bebek') || str_contains($findingsStr, 'bebeğimin') ||
                              str_contains($findingsStr, 'bebeğim') || str_contains($findingsStr, 'çocuk') ||
                              str_contains($findingsStr, 'çocuğum') || str_contains($findingsStr, 'evladım');

        $hasAdultCardiacSymptoms = str_contains($findingsStr, 'sol kol') || str_contains($findingsStr, 'göğüs ağrısı') ||
                                   str_contains($findingsStr, 'efor') || str_contains($findingsStr, 'sıkışma');

        if ($isPediatricContext && !$hasAdultCardiacSymptoms) {
            // Bebek/çocuk şikayetlerinde yetişkin kalp krizi (I21, I20 vb.) tanılarını temizle
            $suggestions = array_values(array_filter($suggestions, function($s) {
                $codePrefix = substr($s['code'], 0, 3);
                return !in_array($codePrefix, ['I21', 'I20', 'I25']);
            }));
        }

        // 🧠 PANİK ATAK & ANKSİYETE VS KALP KRİZİ AYRICI TANI SÜZGECİ
        $isPanicAttackContext = str_contains($findingsStr, 'kontrolü kaybetme') || str_contains($findingsStr, 'ölüm korkusu') ||
                                str_contains($findingsStr, 'çıldırma korkusu') || str_contains($findingsStr, 'panik') ||
                                (str_contains($findingsStr, 'titreme') && str_contains($findingsStr, 'karıncalanma'));

        $hasCoronaryIschemia = str_contains($findingsStr, 'sol kol') || str_contains($findingsStr, 'çene') ||
                              str_contains($findingsStr, 'soğuk ter') || str_contains($findingsStr, 'efor');

        if ($isPanicAttackContext && !$hasCoronaryIschemia) {
            // F41.0 (Panik Bozukluk) önerisini en başa al ve organik kalp krizi tanı puanlarını düşür
            $hasF41 = false;
            foreach ($suggestions as &$s) {
                if ($s['code'] === 'F41.0' || str_starts_with($s['code'], 'F41')) {
                    $s['confidence'] = 0.98;
                    $s['match_reason'] = 'Anksiyete & Panik Atak Bulguları (Kontrolü kaybetme korkusu, parestezi, psikosomatik göğüs sıkışması & çarpıntı)';
                    $hasF41 = true;
                } elseif (in_array(substr($s['code'], 0, 3), ['I20', 'I21', 'I25'])) {
                    $s['confidence'] = round($s['confidence'] * 0.45, 2);
                    $s['match_reason'] .= ' (Kardiyolojik ekarte edilmeli; panik atak şüphesi önceliklidir)';
                }
            }
            unset($s);

            if (!$hasF41) {
                $f41Item = $this->getByCode('F41.0');
                if ($f41Item) {
                    array_unshift($suggestions, array_merge($f41Item, [
                        'confidence' => 0.98,
                        'match_reason' => 'Anksiyete & Panik Atak Bulguları (Kontrolü kaybetme korkusu, parestezi, psikosomatik göğüs sıkışması & çarpıntı)',
                        'recommended_drugs' => $this->getRecommendedDrugsForDiagnosis('F41.0')
                    ]));
                }
            }

            usort($suggestions, fn($a, $b) => $b['confidence'] <=> $a['confidence']);
        }

        // 💧 RENAL KOLİK / ÜRETER TAŞI VS KAS-İSKELET BEL AĞRISI AYRICI TANI SÜZGECİ
        $isRenalColicContext = str_contains($findingsStr, 'kasık bölgesine') || str_contains($findingsStr, 'kasığa doğru') ||
                               str_contains($findingsStr, 'kasığa vuran') || str_contains($findingsStr, 'kolik') ||
                               str_contains($findingsStr, 'kıvrandırıcı') || str_contains($findingsStr, 'renal kolik') ||
                               str_contains($findingsStr, 'üreter taşı') || str_contains($findingsStr, 'böbrek taşı');

        if ($isRenalColicContext) {
            // N20.1 (Üreter Taşı) ve N23 (Renal Kolik) önerisini en başa al, kas-iskelet (M54.5 Bel Ağrısı) puanını düşür
            $hasN20 = false;
            foreach ($suggestions as &$s) {
                if ($s['code'] === 'N20.1' || $s['code'] === 'N23' || str_starts_with($s['code'], 'N20')) {
                    $s['confidence'] = 0.98;
                    $s['match_reason'] = 'Renal Kolik & Üreter Taşı Bulguları (Bel-yan bölgesinden kasığa vuran kıvrandırıcı kolik ağrı & bulantı)';
                    $hasN20 = true;
                } elseif (in_array(substr($s['code'], 0, 3), ['M54', 'M45', 'M51'])) {
                    $s['confidence'] = round($s['confidence'] * 0.35, 2);
                    $s['match_reason'] .= ' (Basit kas-iskelet bel ağrısı değildir; üreter/renal kolik önceliklidir)';
                }
            }
            unset($s);

            if (!$hasN20) {
                $n20Item = $this->getByCode('N20.1');
                if ($n20Item) {
                    array_unshift($suggestions, array_merge($n20Item, [
                        'confidence' => 0.98,
                        'match_reason' => 'Renal Kolik & Üreter Taşı Bulguları (Bel-yan bölgesinden kasığa vuran kıvrandırıcı kolik ağrı & bulantı)',
                        'recommended_drugs' => $this->getRecommendedDrugsForDiagnosis('N20.1')
                    ]));
                }
            }

            usort($suggestions, fn($a, $b) => $b['confidence'] <=> $a['confidence']);
        }

        // 🔥 GASTROÖZOFAGEAL REFLÜ (GÖRH) & GASTRİT VS SOĞUK ALGINLIĞI (ÜSYE) AYRICI TANI SÜZGECİ
        $isGerdContext = str_contains($findingsStr, 'ağza acı') || str_contains($findingsStr, 'ağza ekşi') ||
                         str_contains($findingsStr, 'yayılan yanma') || str_contains($findingsStr, 'göğüs arkasında yanma') ||
                         str_contains($findingsStr, 'ağır yemeklerden') || str_contains($findingsStr, 'yatarken artan öksürük') ||
                         str_contains($findingsStr, 'reflü');

        $hasInfectiousSigns = str_contains($findingsStr, 'ateş') || str_contains($findingsStr, 'boğaz ağrısı') ||
                              str_contains($findingsStr, 'burun akıntısı') || str_contains($findingsStr, 'geniz akıntısı');

        if ($isGerdContext && !$hasInfectiousSigns) {
            // K21.9 (Reflü) önerisini en başa al, viral solunum (J11.1 / J06.9 Soğuk Algınlığı) puanını düşür
            $hasK21 = false;
            foreach ($suggestions as &$s) {
                if ($s['code'] === 'K21.9' || $s['code'] === 'K21.0' || str_starts_with($s['code'], 'K21') || str_starts_with($s['code'], 'K29')) {
                    $s['confidence'] = 0.98;
                    $s['match_reason'] = 'Gastroözofageal Reflü (GÖRH) & Gastrit Bulguları (Ağza acı/ekşi su gelmesi, yemek sonrası substernal yanma & yatarken artan öksürük)';
                    $hasK21 = true;
                } elseif (in_array(substr($s['code'], 0, 3), ['J11', 'J06', 'J00', 'J02'])) {
                    $s['confidence'] = round($s['confidence'] * 0.35, 2);
                    $s['match_reason'] .= ' (Viral solunum yolu/soğuk algınlığı değildir; reflü/gastrit kaynaklı öksürük önceliklidir)';
                }
            }
            unset($s);

            if (!$hasK21) {
                $k21Item = $this->getByCode('K21.9');
                if ($k21Item) {
                    array_unshift($suggestions, array_merge($k21Item, [
                        'confidence' => 0.98,
                        'match_reason' => 'Gastroözofageal Reflü (GÖRH) & Gastrit Bulguları (Ağza acı/ekşi su gelmesi, yemek sonrası substernal yanma & yatarken artan öksürük)',
                        'recommended_drugs' => $this->getRecommendedDrugsForDiagnosis('K21.9')
                    ]));
                }
            }

            usort($suggestions, fn($a, $b) => $b['confidence'] <=> $a['confidence']);
        }

        // 🌀 BENİGN PAROKSİZMAL POZİSYONEL VERTİGO (BPPV / VERTİGO) VS PELVİK ENFLAMATUVAR HASTALIK (PID) / BAŞ AĞRISI SÜZGECİ
        $isBppvVertigoContext = str_contains($findingsStr, 'yatakta dönerken') || str_contains($findingsStr, 'kaldırırken') ||
                                str_contains($findingsStr, 'etrafın dönmesi') || str_contains($findingsStr, 'baş dönmesi') ||
                                str_contains($findingsStr, 'vertigo') || str_contains($findingsStr, 'bppv') ||
                                str_contains($findingsStr, 'kristal kayması') || str_contains($findingsStr, 'kristal oynaması');

        if ($isBppvVertigoContext) {
            // H81.1 (BPPV) veya H81.9 (Vertigo) önerisini en başa al, PID (N73.9) ve Baş Ağrısı (G44.2) puanını düşür
            $hasH81 = false;
            foreach ($suggestions as &$s) {
                if ($s['code'] === 'H81.1' || str_starts_with($s['code'], 'H81') || $s['code'] === 'R42') {
                    $s['confidence'] = 0.98;
                    $s['match_reason'] = 'BPPV & Pozisyonel Vertigo Bulguları (Yatakta dönerken veya başı yukarı kaldırırken hareketle tetiklenen rotasyonel baş dönmesi, dengesizlik & bulantı)';
                    $hasH81 = true;
                } elseif (in_array(substr($s['code'], 0, 3), ['N73', 'G44', 'R51'])) {
                    $s['confidence'] = round($s['confidence'] * 0.2, 2);
                    $s['match_reason'] .= ' (Jinekolojik PID veya basit baş ağrısı değildir; vestibüler pozisyonel vertigo önceliklidir)';
                }
            }
            unset($s);

            if (!$hasH81) {
                $h81Item = $this->getByCode('H81.1');
                if ($h81Item) {
                    array_unshift($suggestions, array_merge($h81Item, [
                        'confidence' => 0.98,
                        'match_reason' => 'BPPV & Pozisyonel Vertigo Bulguları (Yatakta dönerken veya başı yukarı kaldırırken hareketle tetiklenen rotasyonel baş dönmesi, dengesizlik & bulantı)',
                        'recommended_drugs' => $this->getRecommendedDrugsForDiagnosis('H81.1')
                    ]));
                }
            }

            usort($suggestions, fn($a, $b) => $b['confidence'] <=> $a['confidence']);
        }

        // 🦠 AKUT İNFEKSİYÖZ GASTROENTERİT (A09.9) VS KRONİK İRRİTABL BAĞIRSAK SENDROMU (K58.0 İBS) SÜZGECİ
        $isAcuteInfectiousDiarrheaContext = str_contains($findingsStr, 'sulu ishal') || str_contains($findingsStr, '24 saattir') ||
                                            str_contains($findingsStr, 'günde 6') || str_contains($findingsStr, 'günde 5') ||
                                            str_contains($findingsStr, 'günde 7') || str_contains($findingsStr, 'gastroenterit') ||
                                            (str_contains($findingsStr, 'ishal') && (str_contains($findingsStr, 'ateş') || str_contains($findingsStr, 'kusma')));

        if ($isAcuteInfectiousDiarrheaContext) {
            // A09.9 (İnfeksiyöz Gastroenterit) ve A08.4 (Viral Gastroenterit) önerisini en başa al, kronik İBS (K58.0) puanını düşür
            $hasA09 = false;
            foreach ($suggestions as &$s) {
                if ($s['code'] === 'A09.9' || str_starts_with($s['code'], 'A09') || str_starts_with($s['code'], 'A08')) {
                    $s['confidence'] = 0.98;
                    $s['match_reason'] = 'Akut İnfeksiyöz Gastroenterit Bulguları (Akut başlayan sulu ishal, karın krampı, bulantı/kusma & ateş)';
                    $hasA09 = true;
                } elseif (in_array(substr($s['code'], 0, 3), ['K58', 'K59'])) {
                    $s['confidence'] = round($s['confidence'] * 0.25, 2);
                    $s['match_reason'] .= ' (Fonksiyonel kronik İBS değildir; akut infeksiyöz gastroenterit önceliklidir)';
                }
            }
            unset($s);

            if (!$hasA09) {
                $a09Item = $this->getByCode('A09.9');
                if ($a09Item) {
                    array_unshift($suggestions, array_merge($a09Item, [
                        'confidence' => 0.98,
                        'match_reason' => 'Akut İnfeksiyöz Gastroenterit Bulguları (Akut başlayan sulu ishal, karın krampı, bulantı/kusma & ateş)',
                        'recommended_drugs' => $this->getRecommendedDrugsForDiagnosis('A09.9')
                    ]));
                }
            }

            usort($suggestions, fn($a, $b) => $b['confidence'] <=> $a['confidence']);
        }

        // 🦴 ROTATÖR MANŞET SENDROMU & OMUZ HASTALIKLARI (M75.1) VS VERTİGO (H81.1) SÜZGECİ
        $isShoulderContext = str_contains($findingsStr, 'omzunu') || str_contains($findingsStr, 'omzu') ||
                             str_contains($findingsStr, 'omuz') || str_contains($findingsStr, 'rotatör') ||
                             str_contains($findingsStr, 'donuk omuz') || str_contains($findingsStr, 'tarafın üzerine yatamama');

        if ($isShoulderContext) {
            // M75.1 (Rotatör Manşet Sendromu) veya M75.0 (Donuk Omuz) önerisini en başa al, Vertigo (H81.1 / R42) puanını düşür
            $hasM75 = false;
            foreach ($suggestions as &$s) {
                if ($s['code'] === 'M75.1' || str_starts_with($s['code'], 'M75')) {
                    $s['confidence'] = 0.98;
                    $s['match_reason'] = 'Rotatör Manşet & Omuz Lezyonu Bulguları (Omzu yukarı kaldırırken/arkaya götürürken ağrı, gece tarafın üzerine yatamama & hareket kısıtlılığı)';
                    $hasM75 = true;
                } elseif (in_array(substr($s['code'], 0, 3), ['H81', 'H83', 'R42'])) {
                    $s['confidence'] = round($s['confidence'] * 0.15, 2);
                    $s['match_reason'] .= ' (İç kulak vertigo değildir; omuz eklem-tendon lezyonu önceliklidir)';
                }
            }
            unset($s);

            if (!$hasM75) {
                $m75Item = $this->getByCode('M75.1');
                if ($m75Item) {
                    array_unshift($suggestions, array_merge($m75Item, [
                        'confidence' => 0.98,
                        'match_reason' => 'Rotatör Manşet & Omuz Lezyonu Bulguları (Omzu yukarı kaldırırken/arkaya götürürken ağrı, gece tarafın üzerine yatamama & hareket kısıtlılığı)',
                        'recommended_drugs' => $this->getRecommendedDrugsForDiagnosis('M75.1')
                    ]));
                }
            }

            usort($suggestions, fn($a, $b) => $b['confidence'] <=> $a['confidence']);
        }

        // 👶 EL-AYAK-AĞIZ HASTALIĞI (B08.4) VS JENERİK ATEŞLİ HASTALIK (R50.9 / R56.0) SÜZGECİ
        $isHfmdContext = str_contains($findingsStr, 'el/ayak') || str_contains($findingsStr, 'el ve ayak') ||
                         str_contains($findingsStr, 'ağız içinde yaralar') || str_contains($findingsStr, 'küçük yaralar') ||
                         str_contains($findingsStr, 'aftöz') || str_contains($findingsStr, 'aft yaraları') || str_contains($findingsStr, 'ağızda aft') ||
                         str_contains($findingsStr, 'el-ayak-ağız') || str_contains($findingsStr, 'el ayak döküntüsü');

        if ($isHfmdContext) {
            // B08.4 (El-Ayak-Ağız Hastalığı) önerisini en başa al, jenerik ateş (R50.9) ve havale (R56.0) puanını düşür
            $hasB08 = false;
            foreach ($suggestions as &$s) {
                if ($s['code'] === 'B08.4' || str_starts_with($s['code'], 'B08')) {
                    $s['confidence'] = 0.98;
                    $s['match_reason'] = 'El-Ayak-Ağız Hastalığı Bulguları (Ağız içi aftöz yaralar, el/ayak tabanında kırmızı vesiküler döküntü & ateş)';
                    $hasB08 = true;
                } elseif (in_array(substr($s['code'], 0, 3), ['R50', 'R56'])) {
                    $s['confidence'] = round($s['confidence'] * 0.25, 2);
                    $s['match_reason'] .= ' (Jenerik non-spesifik ateş değildir; spesifik enteroviral El-Ayak-Ağız hastalığı önceliklidir)';
                }
            }
            unset($s);

            if (!$hasB08) {
                $b08Item = $this->getByCode('B08.4');
                if ($b08Item) {
                    array_unshift($suggestions, array_merge($b08Item, [
                        'confidence' => 0.98,
                        'match_reason' => 'El-Ayak-Ağız Hastalığı Bulguları (Ağız içi aftöz yaralar, el/ayak tabanında kırmızı vesiküler döküntü & ateş)',
                        'recommended_drugs' => $this->getRecommendedDrugsForDiagnosis('B08.4')
                    ]));
                }
            }

            usort($suggestions, fn($a, $b) => $b['confidence'] <=> $a['confidence']);
        }

        // 😴 UYUYAMAMA / İNSOMNİA & UYKU BOZUKLUKLARI (G47.0 / F51.0) SÜZGECİ
        $isInsomniaContext = str_contains($findingsStr, 'uyuyamıyorum') || str_contains($findingsStr, 'uyuyamiyorum') ||
                             str_contains($findingsStr, 'uyku tutmuyor') || str_contains($findingsStr, 'uykuya dalamıyorum') ||
                             str_contains($findingsStr, 'uykuya dalamiyorum') || str_contains($findingsStr, 'uykusuzluk') ||
                             str_contains($findingsStr, 'insomnia') || str_contains($findingsStr, 'gece uyanıyorum') ||
                             str_contains($findingsStr, 'gece uyaniyorum');

        if ($isInsomniaContext) {
            $hasG47 = false;
            foreach ($suggestions as &$s) {
                if ($s['code'] === 'G47.0' || str_starts_with($s['code'], 'G47') || $s['code'] === 'F51.0') {
                    $s['confidence'] = 0.98;
                    $s['match_reason'] = 'İnsomnia & Uyku Dalma/Sürdürme Bozukluğu Bulguları (Gece uyuyamama, uykusuzluk & uyku bozukluğu)';
                    $hasG47 = true;
                }
            }
            unset($s);

            if (!$hasG47) {
                $g47Item = $this->getByCode('G47.0');
                if ($g47Item) {
                    array_unshift($suggestions, array_merge($g47Item, [
                        'confidence' => 0.98,
                        'match_reason' => 'İnsomnia & Uyku Dalma/Sürdürme Bozukluğu Bulguları (Gece uyuyamama, uykusuzluk & uyku bozukluğu)',
                        'recommended_drugs' => $this->getRecommendedDrugsForDiagnosis('G47.0')
                    ]));
                }
            }
            usort($suggestions, fn($a, $b) => $b['confidence'] <=> $a['confidence']);
        }

        // ⚖️ OBEZİTE & AŞIRI KİLO (E66.9) SÜZGECİ
        $isObesityContext = str_contains($findingsStr, 'obezite') || str_contains($findingsStr, 'obez') ||
                            str_contains($findingsStr, 'aşırı kilo') || str_contains($findingsStr, 'kilo veremiyorum') ||
                            str_contains($findingsStr, 'morbid obezite') || str_contains($findingsStr, 'şişmanlık');

        if ($isObesityContext) {
            $hasE66 = false;
            foreach ($suggestions as &$s) {
                if ($s['code'] === 'E66.9' || str_starts_with($s['code'], 'E66')) {
                    $s['confidence'] = 0.98;
                    $s['match_reason'] = 'Obezite & Metabolik Aşırı Kilo Bulguları (VKİ > 30 kg/m² & Kilo Verememe)';
                    $hasE66 = true;
                }
            }
            unset($s);

            if (!$hasE66) {
                $e66Item = $this->getByCode('E66.9');
                if ($e66Item) {
                    array_unshift($suggestions, array_merge($e66Item, [
                        'confidence' => 0.98,
                        'match_reason' => 'Obezite & Metabolik Aşırı Kilo Bulguları (VKİ > 30 kg/m² & Kilo Verememe)',
                        'recommended_drugs' => $this->getRecommendedDrugsForDiagnosis('E66.9')
                    ]));
                }
            }
            usort($suggestions, fn($a, $b) => $b['confidence'] <=> $a['confidence']);
        }

        // 🥗 ANOREKSİYA NERVOZA & YEME BOZUKLUĞU (F50.0) SÜZGECİ
        $isAnorexiaContext = str_contains($findingsStr, 'anoreksiya') || str_contains($findingsStr, 'anoreksik') ||
                             str_contains($findingsStr, 'kilo almaktan korkuyorum') || str_contains($findingsStr, 'kilo almaktan çok korkuyorum') ||
                             str_contains($findingsStr, 'yemek yiyemiyorum kilo kaybediyorum') || str_contains($findingsStr, 'yeme bozukluğu');

        if ($isAnorexiaContext) {
            $hasF50 = false;
            foreach ($suggestions as &$s) {
                if ($s['code'] === 'F50.0' || str_starts_with($s['code'], 'F50')) {
                    $s['confidence'] = 0.98;
                    $s['match_reason'] = 'Anoreksiya Nervoza & Psikro-Nütrisyonel Yeme Bozukluğu Bulguları (Kilo almaktan aşırı korku & ciddi zayıflama)';
                    $hasF50 = true;
                }
            }
            unset($s);

            if (!$hasF50) {
                $f50Item = $this->getByCode('F50.0');
                if ($f50Item) {
                    array_unshift($suggestions, array_merge($f50Item, [
                        'confidence' => 0.98,
                        'match_reason' => 'Anoreksiya Nervoza & Psikro-Nütrisyonel Yeme Bozukluğu Bulguları (Kilo almaktan aşırı korku & ciddi zayıflama)',
                        'recommended_drugs' => $this->getRecommendedDrugsForDiagnosis('F50.0')
                    ]));
                }
            }
            usort($suggestions, fn($a, $b) => $b['confidence'] <=> $a['confidence']);
        }

        // 4. Eğer hiçbir eşleşme bulunamadıysa uydurma/varsayılan tanı koyma, tanınamadığını açıkça belirt!
        if (empty($suggestions)) {
            return [
                [
                    'code' => 'R69',
                    'description' => 'Tanımlanamayan Veya Spesifik Olmayan Semptom (Klinik Değerlendirme Gereklidir)',
                    'confidence' => 0.0,
                    'match_reason' => 'Girilen hasta şikayeti ICD-10 kataloğundaki tanımlı semptomlar ile eşleşmedi. Yapay zeka hatalı/uydurma teşhis koymamak adına fiziksel muayene önermektedir.',
                    'recommended_drugs' => []
                ]
            ];
        }

        return array_values($suggestions);
    }

    /**
     * Belirli ICD-10 teşhisi için kanıta dayalı ve eczane stoklarında bulunan reçetelenebilir ilaç önerilerini döner.
     */
    public function getRecommendedDrugsForDiagnosis(string $icdCode): array
    {
        $codePrefix = strtoupper(substr(trim($icdCode), 0, 3));

        $drugMap = [
            // İnsomnia, Uykusuzluk & Uyku Bozuklukları (G47.0)
            'G47' => [
                ['name' => 'Passiflora 180ml Şurup', 'dosage' => '10ml', 'frequency' => '2x1 (Aç/Tok)', 'route' => 'oral', 'purpose' => 'Bitkisel Sedatif / Uykuya Geçiş Destekleyici'],
                ['name' => 'Atarax 25mg Film Tablet', 'dosage' => '25mg', 'frequency' => '1x1 (Gece Yatmadan Önce)', 'route' => 'oral', 'purpose' => 'Uyku Düzenleyici & Anksiyolitik Sedatif'],
                ['name' => 'Unisom 25mg Tablet', 'dosage' => '25mg', 'frequency' => '1x1 (Gece)', 'route' => 'oral', 'purpose' => 'Uykusuzluk İlacı (Doksilamin)']
            ],
            // Obezite, Aşırı Kilo & Metabolik Sendrom (E66.9)
            'E66' => [
                ['name' => 'Xenical 120mg Kapsül (Orlistat)', 'dosage' => '120mg', 'frequency' => '3x1 (Yemeklerle)', 'route' => 'oral', 'purpose' => 'Lipaz İnhibitörü / Yağ Emilimini Engelleyici Obezite İlacı'],
                ['name' => 'Saxenda 6mg/ml Enjeksiyonluk Kalem (Liraglutid)', 'dosage' => '0.6mg', 'frequency' => '1x1 (Cilt Altı)', 'route' => 'topikal', 'purpose' => 'GLP-1 Analoğu / İştah Baskılayıcı Obezite Tedavisi'],
                ['name' => 'Glucofage 1000mg Tablet (Metformin)', 'dosage' => '1000mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'İnsülin Direnci & Metabolizma Düzenleyici']
            ],
            // Anoreksiya Nervoza & Yeme Bozuklukları (F50.0)
            'F50' => [
                ['name' => 'Cipralex 10mg Film Tablet (Esitalopram)', 'dosage' => '10mg', 'frequency' => '1x1 (Sabah Tok)', 'route' => 'oral', 'purpose' => 'SSRI Antidepresan / Yeme Bozukluğu & Anksiyete Tedavisi'],
                ['name' => 'Prakten 240ml Şurup (Siproheptadin)', 'dosage' => '5ml', 'frequency' => '3x1 (Yemekten Önce)', 'route' => 'oral', 'purpose' => 'İştah Açıcı & Kilo Aldırıcı Antihistaminik'],
                ['name' => 'Nutrision Protein Sıvı Besin Destek 200ml', 'dosage' => '200ml', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Yüksek Kalorili Tıbbi Beslenme Solüsyonu']
            ],
            // Kardiyovasküler (I Serisi)
            'I10' => [
                ['name' => 'Candesartan 16mg Tablet', 'dosage' => '16mg', 'frequency' => '1x1 (Sabah)', 'route' => 'oral', 'purpose' => 'Kan Basıncı Kontrolü'],
                ['name' => 'Amlodipin 5mg Tablet', 'dosage' => '5mg', 'frequency' => '1x1 (Sabah)', 'route' => 'oral', 'purpose' => 'Vazodilatör / Tansiyon Düşürücü'],
                ['name' => 'Coraspin 100mg Tablet', 'dosage' => '100mg', 'frequency' => '1x1 (Tok)', 'route' => 'oral', 'purpose' => 'Antiagregan / Kan Sulandırıcı']
            ],
            'I20' => [
                ['name' => 'Beloc ZOK 50mg Tablet', 'dosage' => '50mg', 'frequency' => '1x1 (Sabah)', 'route' => 'oral', 'purpose' => 'Beta Blokör / Kalp Hızı Düzenleyici'],
                ['name' => 'Coraspin 100mg Tablet', 'dosage' => '100mg', 'frequency' => '1x1 (Tok)', 'route' => 'oral', 'purpose' => 'Kan Sulandırıcı']
            ],
            'I21' => [
                ['name' => 'Coraspin 100mg Tablet', 'dosage' => '100mg', 'frequency' => '1x1 (Tok)', 'route' => 'oral', 'purpose' => 'Antiagregan'],
                ['name' => 'Crestor 10mg Film Tablet', 'dosage' => '10mg', 'frequency' => '1x1 (Gece)', 'route' => 'oral', 'purpose' => 'Statin / Kolesterol Düzenleyici']
            ],
            'I50' => [
                ['name' => 'Lasix 40mg Tablet', 'dosage' => '40mg', 'frequency' => '1x1 (Sabah Aç)', 'route' => 'oral', 'purpose' => 'Loop Diüretik / Ödem & Şişlik Giderici'],
                ['name' => 'Candesartan 16mg Tablet', 'dosage' => '16mg', 'frequency' => '1x1', 'route' => 'oral', 'purpose' => 'Kalp Yükü Azaltıcı']
            ],
            'I49' => [
                ['name' => 'Beloc ZOK 50mg Tablet', 'dosage' => '50mg', 'frequency' => '1x1 (Sabah)', 'route' => 'oral', 'purpose' => 'Antiarrhythmic / Kalp Ritmi Düzenleyici'],
                ['name' => 'Dideral 40mg Tablet', 'dosage' => '40mg', 'frequency' => '2x1', 'route' => 'oral', 'purpose' => 'Çarpıntı Bastırıcı Beta Blokör']
            ],
            'I73' => [
                ['name' => 'Vastarel MR 35mg Film Tablet', 'dosage' => '35mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Periferik Dolaşım Artırıcı / Üşüme Giderici'],
                ['name' => 'Trental 400mg Film Tablet', 'dosage' => '400mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Vazodilatör / Periferik Kan Akımı Düzenleyici']
            ],

            // Diyabet ve Endokrin (E Serisi)
            'E10' => [
                ['name' => 'Lantus SoloStar 100 ünite/ml Enjeksiyon', 'dosage' => '100U/ml', 'frequency' => '1x1 (Gece)', 'route' => 'subkutan', 'purpose' => 'Bazal İnsülin'],
                ['name' => 'Glucophage 1000mg Tablet', 'dosage' => '1000mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Kan Şekeri Düzenleyici']
            ],
            'E11' => [
                ['name' => 'Glucophage 1000mg Tablet', 'dosage' => '1000mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Tip 2 Diyabet Birincil Basamak'],
                ['name' => 'Diamicron MR 60mg Tablet', 'dosage' => '60mg', 'frequency' => '1x1 (Kahvaltıda)', 'route' => 'oral', 'purpose' => 'Sülfonilüre / İnsülin Salgılatıcı']
            ],
            'E03' => [
                ['name' => 'Euthyrox 50mcg Tablet', 'dosage' => '50mcg', 'frequency' => '1x1 (Sabah Aç)', 'route' => 'oral', 'purpose' => 'Tiroid Hormon Takviyesi']
            ],
            'E28' => [
                ['name' => 'Yaz 28 Film Tablet (Drospirenon + Etinilestradiol)', 'dosage' => '1 Tablet', 'frequency' => '1x1 (Günde 1)', 'route' => 'oral', 'purpose' => 'Polikistik Over (PKOS) Adet Düzenleyici & Antiandrojen'],
                ['name' => 'Inofolic Şase (Miyo-İnositol + Folik Asit)', 'dosage' => '1 Şase', 'frequency' => '2x1 (Suya)', 'route' => 'oral', 'purpose' => 'PKOS Yumurta Kalitesi & İnsülin Direnci Desteği'],
                ['name' => 'Glucophage 850mg Tablet (Metformin)', 'dosage' => '850mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'PKOS İnsülin Duyarlılaştırıcı & Kilo Kontrolü'],
                ['name' => 'Diane 35 Draje (Siproteron Asetat)', 'dosage' => '1 Draje', 'frequency' => '1x1 (21 Gün)', 'route' => 'oral', 'purpose' => 'PKOS Aşırı Tüylenme & Sivilce Tedavisi']
            ],
            'N91' => [
                ['name' => 'Duphaston 10mg Film Tablet (Didrogesteron)', 'dosage' => '10mg', 'frequency' => '2x1 (Siklus 14-25. Günler)', 'route' => 'oral', 'purpose' => 'Amenore / Adet Gecikmesi Söktürücü & Progestojen Desteği'],
                ['name' => 'Tarlusal 5mg Tablet (Medroksiprogesteron)', 'dosage' => '5mg', 'frequency' => '2x1 (5 Gün)', 'route' => 'oral', 'purpose' => 'Adet Söktürücü Tablet'],
                ['name' => 'Cyclo-Progynova Draje', 'dosage' => '1 Draje', 'frequency' => '1x1', 'route' => 'oral', 'purpose' => 'Adet Düzenleyici Hormon Replasmanı']
            ],
            'N94' => [
                ['name' => 'Ponstan Fort 500mg Tablet (Mefenamik Asit)', 'dosage' => '500mg', 'frequency' => '3x1 (Tok)', 'route' => 'oral', 'purpose' => 'Dismenore / Sancılı Regl & Adet Kramp Ağrısı Kesici'],
                ['name' => 'Majezik 100mg Film Tablet (Flurbiprofen)', 'dosage' => '100mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Şiddetli Adet Sancısı İlacı'],
                ['name' => 'Buscopan 10mg Film Tablet', 'dosage' => '10mg', 'frequency' => '3x1 (Aç)', 'route' => 'oral', 'purpose' => 'Rahim & Pelvik Kramp Ağrısı Spazmolitiği']
            ],
            'N92' => [
                ['name' => 'Transamine 500mg Film Tablet (Traneksamik Asit)', 'dosage' => '500mg - 1000mg', 'frequency' => '3x1 (Tok)', 'route' => 'oral', 'purpose' => 'Menoraj & Şiddetli Pıhtılı Adet Kanaması Durdurucu'],
                ['name' => 'Primolut-N 5mg Tablet (Noretisteron)', 'dosage' => '5mg', 'frequency' => '3x1 (Tok)', 'route' => 'oral', 'purpose' => 'Aşırı Adet Kanaması Kontrolü & Kanama Erteleyici'],
                ['name' => 'Gynoferon Sanol Draje', 'dosage' => '1 Draje', 'frequency' => '1x1 (Aç)', 'route' => 'oral', 'purpose' => 'Aşırı Kanama Anemisi Demir Takviyesi']
            ],
            'N76' => [
                ['name' => 'Zolax 150mg Kapsül (Flukonazol)', 'dosage' => '150mg', 'frequency' => 'Tek Doz', 'route' => 'oral', 'purpose' => 'Vajinal Mantar Enfeksiyonu Sistemik Antifungal'],
                ['name' => 'Gyno-Lomexin 600mg Vajinal Ovül', 'dosage' => '600mg', 'frequency' => 'Tek Gece Vajinal', 'route' => 'vajinal', 'purpose' => 'Vajinal Kaşıntı & Akıntı Giderici Ovül'],
                ['name' => 'Mixovul Vajinal Kapsül', 'dosage' => '1 Kapsül', 'frequency' => '2x1 (7 Gün)', 'route' => 'vajinal', 'purpose' => 'Geniş Spektrumlu Vajinit & Akıntı Fitili']
            ],
            'N80' => [
                ['name' => 'Visanne 2mg Tablet (Dienogest)', 'dosage' => '2mg', 'frequency' => '1x1 (Günde 1)', 'route' => 'oral', 'purpose' => 'Endometriozis / Çikolata Kisti Altın Standart Tedavisi'],
                ['name' => 'Yasmin Film Tablet', 'dosage' => '1 Tablet', 'frequency' => '1x1', 'route' => 'oral', 'purpose' => 'Endometriozis & Pelvik Ağrı Bastırıcı OOK'],
                ['name' => 'Buscopan 10mg Film Tablet', 'dosage' => '10mg', 'frequency' => '3x1', 'route' => 'oral', 'purpose' => 'Çikolata Kisti Sancısı Spazmolitiği']
            ],
            'D25' => [
                ['name' => 'Esmya 5mg Film Tablet (Ulipristal Asetat)', 'dosage' => '5mg', 'frequency' => '1x1', 'route' => 'oral', 'purpose' => 'Rahim Miyomu Büyüklüğü Küçültücü Tedavi'],
                ['name' => 'Transamine 500mg Film Tablet', 'dosage' => '500mg', 'frequency' => '3x1', 'route' => 'oral', 'purpose' => 'Miyoma Bağlı Aşırı Kanama Kontrolü']
            ],
            'E78' => [
                ['name' => 'Crestor 10mg Film Tablet', 'dosage' => '10mg', 'frequency' => '1x1 (Gece)', 'route' => 'oral', 'purpose' => 'LDL Kolesterol Düşürücü']
            ],

            // Solunum Sistemi (J Serisi)
            'J30' => [
                ['name' => 'Allerset 10mg Film Tablet', 'dosage' => '10mg', 'frequency' => '1x1 (Gece)', 'route' => 'oral', 'purpose' => 'Antihistaminik / Geniz Akıntısı & Alerjik Rinit'],
                ['name' => 'Otrivine %0.1 Burun Spreyi', 'dosage' => '%0.1', 'frequency' => '2x1 Puf', 'route' => 'nasal', 'purpose' => 'Burun & Geniz Dekonjestanı'],
                ['name' => 'Tantum Verde Gargara', 'dosage' => '15ml', 'frequency' => '3x1 (Gargara)', 'route' => 'topikal', 'purpose' => 'Lokal Antiseptik']
            ],
            'J31' => [
                ['name' => 'Allerset 10mg Film Tablet', 'dosage' => '10mg', 'frequency' => '1x1 (Gece)', 'route' => 'oral', 'purpose' => 'Kronik Geniz Akıntısı & Rinit Tedavisi'],
                ['name' => 'Otrivine %0.1 Burun Spreyi', 'dosage' => '%0.1', 'frequency' => '2x1 Puf', 'route' => 'nasal', 'purpose' => 'Burun Dekonjestanı']
            ],
            'J01' => [
                ['name' => 'Augmentin 1000mg Film Tablet', 'dosage' => '1000mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Sinüzit Antibiyotik Tedavisi'],
                ['name' => 'Otrivine %0.1 Burun Spreyi', 'dosage' => '%0.1', 'frequency' => '2x1 Puf', 'route' => 'nasal', 'purpose' => 'Sinüs ve Geniz Drenajı'],
                ['name' => 'Parol 500mg Tablet', 'dosage' => '500mg', 'frequency' => '3x1', 'route' => 'oral', 'purpose' => 'Analjezik / Yüz Ağrısı Kesici']
            ],
            'J11' => [
                ['name' => 'Enfluvir 75mg Kapsül', 'dosage' => '75mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Antiviral / İnfluenza (Grip) İlacı'],
                ['name' => 'Aferin Forte Film Tablet', 'dosage' => '1 Tablet', 'frequency' => '3x1 (Tok)', 'route' => 'oral', 'purpose' => 'Grip, Ateş, Hapşırık & Ağrı Kesici'],
                ['name' => 'Katarin Forte Film Tablet', 'dosage' => '1 Tablet', 'frequency' => '3x1 (Tok)', 'route' => 'oral', 'purpose' => 'Grip & Soğuk Algınlığı Kombinasyonu'],
                ['name' => 'Tylol Hot Efervesan Poşet', 'dosage' => '1 Poşet', 'frequency' => '3x1 (Sıcak Suya)', 'route' => 'oral', 'purpose' => 'Grip & Ateş Düşürücü Sıcak İçecek'],
                ['name' => 'Parol 500mg Tablet', 'dosage' => '500mg', 'frequency' => '3x1', 'route' => 'oral', 'purpose' => 'Analjezik / Antipiretik']
            ],
            'J10' => [
                ['name' => 'Enfluvir 75mg Kapsül', 'dosage' => '75mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Antiviral Grip Tedavisi'],
                ['name' => 'Aferin Forte Film Tablet', 'dosage' => '1 Tablet', 'frequency' => '3x1', 'route' => 'oral', 'purpose' => 'Grip & Vücut Ağrısı Kesici'],
                ['name' => 'Tylol Hot Efervesan Poşet', 'dosage' => '1 Poşet', 'frequency' => '3x1', 'route' => 'oral', 'purpose' => 'Grip İlacı Sıcak Poşet']
            ],
            'J00' => [
                ['name' => 'Iliadin %0.05 Burun Spreyi', 'dosage' => '2 Puf', 'frequency' => '2x1', 'route' => 'nasal', 'purpose' => 'Burun Tıkanıklığı Açıcı Dekonjestan'],
                ['name' => 'Aferin Sinüs Film Tablet', 'dosage' => '1 Tablet', 'frequency' => '3x1 (Tok)', 'route' => 'oral', 'purpose' => 'Soğuk Algınlığı & Burun Tıkanıklığı İlacı'],
                ['name' => 'C-Ester 1000mg Efervesan Tablet', 'dosage' => '1000mg', 'frequency' => '1x1', 'route' => 'oral', 'purpose' => 'C Vitamini Desteği'],
                ['name' => 'Parol 500mg Tablet', 'dosage' => '500mg', 'frequency' => '3x1 (Tok)', 'route' => 'oral', 'purpose' => 'Semptomatik Ağrı & Ateş Düşürücü']
            ],
            'J02' => [
                ['name' => 'Augmentin 1000mg Film Tablet', 'dosage' => '1000mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Geniş Spektrumlu Antibiyotik'],
                ['name' => 'Tantum Verde Gargara', 'dosage' => '15ml', 'frequency' => '3x1 (Gargara)', 'route' => 'topikal', 'purpose' => 'Lokal Analjezik / Antiseptik']
            ],
            'J06' => [
                ['name' => 'Aferin Forte Film Tablet', 'dosage' => '1 Tablet', 'frequency' => '3x1 (Tok)', 'route' => 'oral', 'purpose' => 'ÜSYE & Soğuk Algınlığı İlacı'],
                ['name' => 'Augmentin 1000mg Film Tablet', 'dosage' => '1000mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Bakteriyel ÜSYE Tedavisi'],
                ['name' => 'Parol 500mg Tablet', 'dosage' => '500mg', 'frequency' => '3x1 (Tok)', 'route' => 'oral', 'purpose' => 'Analjezik / Antipiretik']
            ],
            // Kadın Doğum, Gebelik & İnfertilite İlaçları (O & N97 Serisi)
            'O09' => [
                ['name' => 'Elevit Pronatal Film Tablet', 'dosage' => '1 Tablet', 'frequency' => '1x1 (Tok)', 'route' => 'oral', 'purpose' => 'Gebelik Multivitamini & Folik Asit Desteği'],
                ['name' => 'Folbiol 5mg Tablet', 'dosage' => '5mg', 'frequency' => '1x1 (Aç)', 'route' => 'oral', 'purpose' => 'Gebelikte Folik Asit & Nöral Tüp Koruyucu'],
                ['name' => 'Gynoferon Sanol Draje', 'dosage' => '1 Draje', 'frequency' => '1x1 (Aç)', 'route' => 'oral', 'purpose' => 'Gebelikte Anemi & Kan İlacı']
            ],
            'O21' => [
                ['name' => 'Pranox (Doksilamin + B6)', 'dosage' => '2 Tablet', 'frequency' => '1x1 (Yatmadan Önce)', 'route' => 'oral', 'purpose' => 'Gebeliğe Bağlı Bulantı & Kusma İlacı (Güvenli Kategori A)'],
                ['name' => 'Zofran 4mg Film Tablet', 'dosage' => '4mg', 'frequency' => '2x1', 'route' => 'oral', 'purpose' => 'Şiddetli Gebelik Kusması (Hyperemesis) Antiemetik'],
                ['name' => 'Emedur 200mg Suppozituvar', 'dosage' => '200mg', 'frequency' => '1 Fitil (İhtiyaç halinde)', 'route' => 'rektal', 'purpose' => 'Bulantı & Kusma Kesici Fitil']
            ],
            'N97' => [
                ['name' => 'Klomen 50mg Tablet (Klomifen Sitrat)', 'dosage' => '50mg', 'frequency' => '1x1 (Adetin 5. Günü)', 'route' => 'oral', 'purpose' => 'Yumurtlama Uyarısı / Kadın İnfertilite Tedavisi'],
                ['name' => 'Inofolic Şase (Miyo-İnositol + Folik Asit)', 'dosage' => '1 Şase', 'frequency' => '2x1 (Suya)', 'route' => 'oral', 'purpose' => 'Yumurta Kalitesi Desteği & PKOS Gebe Kalma Desteği'],
                ['name' => 'Progestan 200mg Yumuşak Kapsül', 'dosage' => '200mg', 'frequency' => '1x1 (Vajinal/Oral)', 'route' => 'vajinal', 'purpose' => 'Luteal Evre & Rahim Zarı Tutunma Desteği']
            ],
            'O26' => [
                ['name' => 'Calcimax D3 Efervesan Tablet', 'dosage' => '1 Tablet', 'frequency' => '1x1', 'route' => 'oral', 'purpose' => 'Gebelik Kas Krampları & Kalsiyum Desteği'],
                ['name' => 'Magnesie Calcinee Toz', 'dosage' => '1 Ölçek', 'frequency' => '1x1 (Gece)', 'route' => 'oral', 'purpose' => 'Gebelikte Kramp Önleyici Magnezyum']
            ],
            'O14' => [
                ['name' => 'Alfamed 250mg Film Tablet (Metildopa)', 'dosage' => '250mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Gebelikte En Güvenli Tansiyon İlacı (Antihipertansif)'],
                ['name' => 'Coraspin 100mg Tablet', 'dosage' => '100mg', 'frequency' => '1x1 (Tok)', 'route' => 'oral', 'purpose' => 'Preeklampsi Önleyici Antiagregan']
            ],
            'O24' => [
                ['name' => 'İnsülin Humulin N 100IU/ml Enjeksiyon', 'dosage' => 'Kişiye Özel', 'frequency' => '1x1 (Gece)', 'route' => 'subkutan', 'purpose' => 'Gebelik Şekeri (Gestasyonel Diyabet) Güvenli İnsülin']
            ],
            // Sağlık Bakanlığı Listesi Ek Hastalık İlaçları (G00, B18, H40, F20, G40, I21, A23, G50, U07, G35)
            'G00' => [
                ['name' => 'Rocephin 1g IV Flakon (Seftriakson)', 'dosage' => '1g', 'frequency' => '2x1 (IV)', 'route' => 'intravenöz', 'purpose' => 'Bakteriyel Menenjit Üçüncü Kuşak Sefalosporin Antibiyotik'],
                ['name' => 'Avelox 400mg Film Tablet', 'dosage' => '400mg', 'frequency' => '1x1', 'route' => 'oral', 'purpose' => 'Geniş Spektrumlu Santral Enfeksiyon Antibiyotiği'],
                ['name' => 'Parol 500mg Tablet', 'dosage' => '500mg', 'frequency' => '3x1', 'route' => 'oral', 'purpose' => 'Analjezik / Yüksek Ateş Düşürücü']
            ],
            'B18' => [
                ['name' => 'Viread 245mg Film Tablet (Tenofovir)', 'dosage' => '245mg', 'frequency' => '1x1 (Tok)', 'route' => 'oral', 'purpose' => 'Kronik Hepatit B Antiviral Tedavisi'],
                ['name' => 'Baraclude 0.5mg Film Tablet (Entekavir)', 'dosage' => '0.5mg', 'frequency' => '1x1 (Aç)', 'route' => 'oral', 'purpose' => 'Hepatit B Viral Yük Düşürücü'],
                ['name' => 'Ursofalk 250mg Kapsül', 'dosage' => '250mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Karaciğer Hücre Koruyucu']
            ],
            'H40' => [
                ['name' => 'Cosopt Göz Damlası', 'dosage' => '5ml', 'frequency' => '2x1 (Göze)', 'route' => 'oftalmik', 'purpose' => 'Glokom Göz Tansiyonu & İntraoküler Basınç Düşürücü'],
                ['name' => 'Xalatan %0.005 Göz Damlası', 'dosage' => '2.5ml', 'frequency' => '1x1 (Gece Göze)', 'route' => 'oftalmik', 'purpose' => 'Prostaglandin Analog Glokom Damlası'],
                ['name' => 'Alphagan P %0.15 Göz Damlası', 'dosage' => '5ml', 'frequency' => '2x1', 'route' => 'oftalmik', 'purpose' => 'Alfa-2 Adrenerjik Agonist Damla']
            ],
            'F20' => [
                ['name' => 'Zyprexa 10mg Film Tablet (Olanzapin)', 'dosage' => '10mg', 'frequency' => '1x1 (Gece)', 'route' => 'oral', 'purpose' => 'Atipik Antipsikotik / Şizofreni & Sanrı Tedavisi'],
                ['name' => 'Seroquel 200mg Film Tablet (Ketiapin)', 'dosage' => '200mg', 'frequency' => '1x1 (Gece)', 'route' => 'oral', 'purpose' => 'Antipsikotik / Duygu Durum & Algı Düzenleyici'],
                ['name' => 'Abilify 15mg Tablet (Aripiprazol)', 'dosage' => '15mg', 'frequency' => '1x1 (Sabah)', 'route' => 'oral', 'purpose' => 'Dopaminerjik Antipsikotik']
            ],
            'G40' => [
                ['name' => 'Depakin Chrono 500mg Tablet (Sodyum Valproat)', 'dosage' => '500mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Geniş Spektrumlu Antiepileptik / Sara Nöbeti Önleyici'],
                ['name' => 'Keppra 500mg Film Tablet (Levetirasetam)', 'dosage' => '500mg', 'frequency' => '2x1', 'route' => 'oral', 'purpose' => 'Epilepsi Nöbet Engelleyici'],
                ['name' => 'Tegretol CR 400mg Tablet', 'dosage' => '400mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Antiepileptik & Nöralji İlacı']
            ],
            'I21' => [
                ['name' => 'Coraspin 100mg Tablet', 'dosage' => '100mg', 'frequency' => '1x1 (Tok)', 'route' => 'oral', 'purpose' => 'Akut Miyokard Enfarktüsü (Kalp Krizi) Antiagregan'],
                ['name' => 'Plavix 75mg Film Tablet (Klopidogrel)', 'dosage' => '75mg', 'frequency' => '1x1', 'route' => 'oral', 'purpose' => 'Trombosit Agregasyon İnhibitörü'],
                ['name' => 'Beloc ZOK 50mg Kontrollü Salım Tableti', 'dosage' => '50mg', 'frequency' => '1x1', 'route' => 'oral', 'purpose' => 'Beta Bloker / Kalp Yükü Düşürücü']
            ],
            'A23' => [
                ['name' => 'Monodox 100mg Kapsül (Doksisiklin)', 'dosage' => '100mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Bruselloz (Peynir Hastalığı) Birincil Antibiyotiği'],
                ['name' => 'Rifcap 300mg Kapsül (Rifampisin)', 'dosage' => '300mg', 'frequency' => '2x1 (Aç)', 'route' => 'oral', 'purpose' => 'Bruselloz Kombinasyon Antibiyotiği'],
                ['name' => 'Parol 500mg Tablet', 'dosage' => '500mg', 'frequency' => '3x1', 'route' => 'oral', 'purpose' => 'Dalgalı Ateş & Eklem Ağrısı Kesici']
            ],
            'G50' => [
                ['name' => 'Tegretol CR 200mg Tablet (Karbamazepin)', 'dosage' => '200mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Trigeminal Nevralji Altın Standart Ağrı Kesici'],
                ['name' => 'Lyrica 75mg Kapsül (Pregabalin)', 'dosage' => '75mg', 'frequency' => '2x1', 'route' => 'oral', 'purpose' => 'Nöropatik Ağrı & Yüz Şimşek Ağrısı Çözücü'],
                ['name' => 'Neurontin 300mg Kapsül (Gabapentin)', 'dosage' => '300mg', 'frequency' => '3x1', 'route' => 'oral', 'purpose' => 'Nöropatik Ağrı Düzenleyici']
            ],
            'U07' => [
                ['name' => 'Favimol 200mg Film Tablet (Favipiravir)', 'dosage' => '200mg', 'frequency' => '2x1 (Kür)', 'route' => 'oral', 'purpose' => 'COVID-19 Antiviral Tedavisi'],
                ['name' => 'C-Ester 1000mg Efervesan Tablet', 'dosage' => '1000mg', 'frequency' => '1x1', 'route' => 'oral', 'purpose' => 'Bağışıklık Destekleyici C Vitamini'],
                ['name' => 'Enox 4000 Anti-Xa Enjeksiyon', 'dosage' => '4000IU', 'frequency' => '1x1 (SC)', 'route' => 'subkutan', 'purpose' => 'COVID-19 Pıhtı Önleyici Düşük Molekül Ağırlıklı Heparin']
            ],
            'G35' => [
                ['name' => 'Avonex 30mcg IV Enjeksiyon (İnterferon Beta-1a)', 'dosage' => '30mcg', 'frequency' => 'Haftada 1', 'route' => 'intramüsküler', 'purpose' => 'Multipl Skleroz (MS) İmmünomodülatör Atak Önleyici'],
                ['name' => 'Rebif 44mcg Enjeksiyon', 'dosage' => '44mcg', 'frequency' => 'Haftada 3', 'route' => 'subkutan', 'purpose' => 'MS Atak Sıklığı Düşürücü'],
                ['name' => 'Prednol 40mg Flakon (Metilprednizolon)', 'dosage' => '40mg', 'frequency' => 'Puls Tedavisi', 'route' => 'intravenöz', 'purpose' => 'Akut MS Atak Kortikosteroid Tedavisi']
            ],
            // Pediatri, Çocuk Psikiyatrisi & Nörogelişimsel İlaçlar (F, R, A, J, B Serisi)
            'F84' => [
                ['name' => 'Risperdal 1mg/ml Oral Çözelti', 'dosage' => '0.25mg - 0.5mg', 'frequency' => '1x1 (Gece)', 'route' => 'oral', 'purpose' => 'Otizm Spektrumu Davranış & Öfke Nöbeti Düzenleyici'],
                ['name' => 'Efa S-1200 Likit Balık Yağı 200ml', 'dosage' => '5ml', 'frequency' => '1x1 (Tok)', 'route' => 'oral', 'purpose' => 'Yüksek DHA/EPA Otizm Nörogelişimsel Beyin Desteği'],
                ['name' => 'Pharmaton Kiddi Şurup 200ml', 'dosage' => '5ml', 'frequency' => '1x1', 'route' => 'oral', 'purpose' => 'Çocuk Multivitamin & Lizin Takviyesi']
            ],
            'F90' => [
                ['name' => 'Ritalin 10mg Tablet', 'dosage' => '10mg', 'frequency' => '1x1 (Sabah Tok)', 'route' => 'oral', 'purpose' => 'DEHB Odaklanma & Dikkat Süresi Artırıcı'],
                ['name' => 'Concerta 18mg Kontrollü Salınım Tableti', 'dosage' => '18mg', 'frequency' => '1x1 (Sabah)', 'route' => 'oral', 'purpose' => 'DEHB Uzun Etkili Dikkat Düzenleyici'],
                ['name' => 'Risperdal 1mg/ml Oral Çözelti', 'dosage' => '0.5mg', 'frequency' => '1x1', 'route' => 'oral', 'purpose' => 'Aşırı Dürtüsellik & Hiperaktivite Dengeleyici']
            ],
            'R56' => [
                ['name' => 'Diazem 5mg Rektal Tüp', 'dosage' => '5mg', 'frequency' => 'Nöbet Anında Rektal', 'route' => 'rektal', 'purpose' => 'Ateşli Havale / Konvülsiyon Acil Kasılma Çözücü'],
                ['name' => 'Calpol 120mg/5ml Süspansiyon', 'dosage' => '5ml - 10ml', 'frequency' => '4x1', 'route' => 'oral', 'purpose' => 'Çocuk Ateş Düşürücü Parasetamol'],
                ['name' => 'Dolven 100mg/5ml Pediatrik Şurup', 'dosage' => '5ml', 'frequency' => '3x1 (Tok)', 'route' => 'oral', 'purpose' => 'Pediatrik Yüksek Ateş Düşürücü İbuprofen']
            ],
            'A08' => [
                ['name' => 'Reflor 250mg Pediatrik Saşe', 'dosage' => '1 Saşe', 'frequency' => '2x1 (Su/Mamaya)', 'route' => 'oral', 'purpose' => 'Rotavirüs & Çocuk İshal Probiyotik Tedavisi'],
                ['name' => 'Georal Oral Rehidratasyon Sıvısı (ORS)', 'dosage' => '1 Poşet / 1L Su', 'frequency' => 'Yudum Yudum', 'route' => 'oral', 'purpose' => 'Rotavirüs Elektrolit & Dehidrasyon Koruyucu'],
                ['name' => 'Zinca Pediatrik Şurup 15mg/5ml', 'dosage' => '5ml', 'frequency' => '1x1 (Aç)', 'route' => 'oral', 'purpose' => 'Çocuk Bağırsak Mukozası Onarıcı Çinko']
            ],
            'J21' => [
                ['name' => 'Ventolin Nebül 2.5mg/2.5ml', 'dosage' => '1 Nebül', 'frequency' => 'Nebülizatör İle', 'route' => 'inhalasyon', 'purpose' => 'Bebek & Çocuk Akut Bronşit / Bronşoliyit Bronş Açıcı'],
                ['name' => 'Pulmicort 0.25mg/2ml Nebül', 'dosage' => '1 Nebül', 'frequency' => '2x1 Nebül', 'route' => 'inhalasyon', 'purpose' => 'Bebek İnhale İltihap Giderici Kortikosteroid'],
                ['name' => 'Serum Fizyolojik %0.9 İzonazal Damla', 'dosage' => '2 Damla', 'frequency' => '4x1', 'route' => 'nasal', 'purpose' => 'Bebek Burun Açıcı Solüsyon']
            ],
            'B08' => [
                ['name' => 'Calpol 120mg/5ml Süspansiyon', 'dosage' => '5ml', 'frequency' => '4x1', 'route' => 'oral', 'purpose' => 'El-Ayak-Ağız Hastalığı Ateş & Ağrı Kesici'],
                ['name' => 'Stilex Jel 30g', 'dosage' => 'Lokal', 'frequency' => '3x1', 'route' => 'topikal', 'purpose' => 'El Ve Ayak Döküntü Kaşıntı Giderici'],
                ['name' => 'Kloroben Oral Sprey Pediatrik', 'dosage' => '2 Puf', 'frequency' => '3x1', 'route' => 'topikal', 'purpose' => 'Ağız İçi Aft & Döküntü Antiseptiği']
            ],
            'J44' => [
                ['name' => 'Ventolin Inhaler 100mcg', 'dosage' => '100mcg', 'frequency' => '2 Puf (Nefes Darlığında)', 'route' => 'inhalasyon', 'purpose' => 'Hızlı Etkili Bronkodilatör'],
                ['name' => 'Pulmicort 0.5mg/2ml Nebülizasyon Süspansiyonu', 'dosage' => '0.5mg', 'frequency' => '2x1 Nebül', 'route' => 'inhalasyon', 'purpose' => 'İnhale Kortikosteroid']
            ],
            'J45' => [
                ['name' => 'Ventolin Inhaler 100mcg', 'dosage' => '100mcg', 'frequency' => '2 Puf (Atakta)', 'route' => 'inhalasyon', 'purpose' => 'Bronkospazm Çözücü'],
                ['name' => 'Singulair 10mg Çiğneme Tableti', 'dosage' => '10mg', 'frequency' => '1x1 (Gece)', 'route' => 'oral', 'purpose' => 'Lökotrien Reseptör Antagonisti']
            ],

            // Gastroenteroloji & Genel Cerrahi İlaç Protokolleri (K35, K80, K81, K21, K51, K74, K40, K60, K56, K85)
            'K35' => [
                ['name' => 'Serum Fizyolojik %0.9 1000ml IV', 'dosage' => '1000ml', 'frequency' => 'Acil IV İnfüzyon', 'route' => 'intravenöz', 'purpose' => 'Akut Apandisit Sıvı Desteği'],
                ['name' => 'Parol 500mg IV Flakon', 'dosage' => '1000mg', 'frequency' => '3x1 IV', 'route' => 'intravenöz', 'purpose' => 'Akut Karın Ağrısı & Ateş Giderici'],
                ['name' => 'Cefamezin 1g IV Flakon', 'dosage' => '1g', 'frequency' => '2x1 (Profilaksi)', 'route' => 'intravenöz', 'purpose' => 'Pre-op Cerrahi Antibiyotik Profilaksisi']
            ],
            'K80' => [
                ['name' => 'Buscopan 10mg IV/IM Ampul (Hiyosin-N-Butilbromür)', 'dosage' => '20mg', 'frequency' => '3x1 IV', 'route' => 'intravenöz', 'purpose' => 'Safra Yolu Spazmı & Kolik Ağrısı Çözücü'],
                ['name' => 'Apranax Fort 550mg Tablet', 'dosage' => '550mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'NSAİİ Safra Koliği Ağrı Kesici'],
                ['name' => 'Ursofalk 250mg Kapsül', 'dosage' => '250mg', 'frequency' => '2x1', 'route' => 'oral', 'purpose' => 'Safra Çamuru & Taş Eritici']
            ],
            'K81' => [
                ['name' => 'Buscopan 10mg IV Ampul', 'dosage' => '20mg', 'frequency' => '3x1 IV', 'route' => 'intravenöz', 'purpose' => 'Akut Kolesistit Spazmolitik'],
                ['name' => 'Cefamezin 1g IV Flakon', 'dosage' => '1g', 'frequency' => '2x1 IV', 'route' => 'intravenöz', 'purpose' => 'Safra Kesesi İltihabı Antibiyotiği']
            ],
            'K21' => [
                ['name' => 'Nexium 40mg Tablet (Esomeprazol)', 'dosage' => '40mg', 'frequency' => '1x1 (Sabah Aç)', 'route' => 'oral', 'purpose' => 'GÖRH Reflü Mide Asit Baskılama'],
                ['name' => 'Gaviscon Double Action Likit', 'dosage' => '10ml - 20ml', 'frequency' => '4x1 (Yemek Sonrası & Gece)', 'route' => 'oral', 'purpose' => 'Ağza Acı Su Gelmesi & Göğüs Yanması Engelleyici'],
                ['name' => 'Rennie Çiğneme Tableti', 'dosage' => '1-2 Tablet', 'frequency' => 'İhtiyaç Halinde', 'route' => 'oral', 'purpose' => 'Antasit Hızlı Yüzey Koruyucu']
            ],
            'K51' => [
                ['name' => 'Salofalk 500mg Film Tablet (Mesalazin)', 'dosage' => '500mg', 'frequency' => '3x2 (Tok)', 'route' => 'oral', 'purpose' => 'Ülseratif Kolit İltihabi Bağırsak Tedavisi'],
                ['name' => 'Pentasa 1g Saşe', 'dosage' => '1g', 'frequency' => '2x1', 'route' => 'oral', 'purpose' => 'Kanlı-Mukuslu İshal & Kolit Remisyon Desteği'],
                ['name' => 'Reflor 250mg Saşe', 'dosage' => '250mg', 'frequency' => '2x1', 'route' => 'oral', 'purpose' => 'Bağırsak Florası Düzenleyici Probiyotik']
            ],
            'K74' => [
                ['name' => 'Ursofalk 250mg Kapsül (Ursodeoksikolik Asit)', 'dosage' => '250mg', 'frequency' => '3x1 (Tok)', 'route' => 'oral', 'purpose' => 'Kolestaz & Tıkanma Sarılığı Safra Akış Düzenleyici'],
                ['name' => 'Atarax 25mg Film Tablet', 'dosage' => '25mg', 'frequency' => '1x1 (Gece)', 'route' => 'oral', 'purpose' => 'Sarılık Ve Safra Asit Birikimine Bağlı Kaşıntı Giderici'],
                ['name' => 'K1 Vitamini Ampul 10mg', 'dosage' => '10mg', 'frequency' => '1x1 (IM)', 'route' => 'intramüsküler', 'purpose' => 'Kolestaz Pıhtılaşma Desteği']
            ],
            'K40' => [
                ['name' => 'Parol 500mg Tablet', 'dosage' => '500mg', 'frequency' => '3x1 (Tok)', 'route' => 'oral', 'purpose' => 'Kasık Fıtığı Ağrı Giderici'],
                ['name' => 'Arveles 25mg Film Tablet', 'dosage' => '25mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Şiddetli Fıtık Ağrısı Kesici']
            ],
            'K60' => [
                ['name' => 'Anestol %5 Merhem (Lidokain)', 'dosage' => 'Lokal', 'frequency' => '3x1 (Dışkılama Öncesi)', 'route' => 'topikal', 'purpose' => 'Anal Fissür Cam Kesiği Ağrısı Lokal Anestezi'],
                ['name' => 'Rectoderm %0.4 Rektal Merhem (NTG)', 'dosage' => 'Nohut Büyüklüğünde', 'frequency' => '2x1', 'route' => 'topikal', 'purpose' => 'Makat Sfinkter Spazmı Çözücü & Çatlak İyileştirici'],
                ['name' => 'Duphalac 667mg/ml Şurup', 'dosage' => '15ml - 30ml', 'frequency' => '1x1 (Sabah)', 'route' => 'oral', 'purpose' => 'Yumuşatıcı Laksatif / Dışkılama Kolaylaştırıcı']
            ],
            'K56' => [
                ['name' => 'Serum Fizyolojik %0.9 1000ml IV', 'dosage' => '1000ml', 'frequency' => 'Hızlı IV', 'route' => 'intravenöz', 'purpose' => 'İleus / Bağırsak Tıkanıklığı Acil Sıvı Reanimasyonu'],
                ['name' => 'Metpamid 10mg IV Ampul (Metoklopramid)', 'dosage' => '10mg', 'frequency' => '2x1 IV', 'route' => 'intravenöz', 'purpose' => 'Fışkırır Kusma & Bulantı Önleyici Antiemetik']
            ],
            'K85' => [
                ['name' => 'Serum Fizyolojik %0.9 1000ml IV', 'dosage' => '2000ml', 'frequency' => 'Agresif IV Hidrasyon', 'route' => 'intravenöz', 'purpose' => 'Akut Pankreatit Agresif Hidrasyon'],
                ['name' => 'Nexium 40mg IV Flakon', 'dosage' => '40mg', 'frequency' => '2x1 IV', 'route' => 'intravenöz', 'purpose' => 'Pankreatit Mide Koruma & Asit İnhibisyonu'],
                ['name' => 'Contramal 50mg IV Ampul (Tramadol)', 'dosage' => '50mg', 'frequency' => '2x1 (Yavaş IV)', 'route' => 'intravenöz', 'purpose' => 'Şiddetli Pankreatit Kuşak Ağrısı Analjezi']
            ],
            'B08' => [
                ['name' => 'Calpol 120mg/5ml Süspansiyon (Parasetamol)', 'dosage' => '10-15mg/kg', 'frequency' => '4x1 (Ölçekle)', 'route' => 'oral', 'purpose' => 'Pediatrik Ateş Düşürücü & Ağız Yarası Ağrı Kesici Şurup'],
                ['name' => 'Andorex Oral Sprey 30ml', 'dosage' => '1 Puf', 'frequency' => '3x1 (Ağız İçi Yaralara)', 'route' => 'topikal', 'purpose' => 'Ağız İçi Aftöz Yara Rahatlatıcı & Lokal Anestezik Sprey'],
                ['name' => 'Stilex Jel 30g', 'dosage' => 'Lokal', 'frequency' => '3x1 (Deriden)', 'route' => 'topikal', 'purpose' => 'El & Ayak Tabanı Döküntüsü & Kaşıntı Giderici Jel'],
                ['name' => 'Soğuk Sıvı & Yumuşak Diyet', 'dosage' => 'Sürekli', 'frequency' => 'İhtiyaç Halinde', 'route' => 'oral', 'purpose' => 'Yutma Güçlüğünü Azaltıcı & Dehidrasyon Önleyici Destek']
            ],
            // Mide Kanaması & Acil İç Kanama İlaç Protokolleri (K92, K25, R58, I85, I71)
            'K92' => [
                ['name' => 'Nexium 40mg IV Flakon (Esomeprazol)', 'dosage' => '80mg Bolus + 8mg/saat', 'frequency' => 'Sürekli İnfaz', 'route' => 'intravenöz', 'purpose' => 'Akut Mide Kanaması Asit Baskılama & Pıhtı Stabilitesi'],
                ['name' => 'Transamine 500mg IV Ampul (Traneksamik Asit)', 'dosage' => '1000mg', 'frequency' => '3x1 Yavaş IV', 'route' => 'intravenöz', 'purpose' => 'Antifibrinolitik Kanama Durdurucu İlaç'],
                ['name' => 'Serum Fizyolojik %0.9 1000ml IV', 'dosage' => '1000ml', 'frequency' => 'Hızlı İnfüzyon', 'route' => 'intravenöz', 'purpose' => 'Kanama Sonrası Hacim & Sıvı Resüsitasyonu']
            ],
            'K25' => [
                ['name' => 'Nexium 40mg IV Flakon (Esomeprazol)', 'dosage' => '40mg - 80mg', 'frequency' => '2x1 IV', 'route' => 'intravenöz', 'purpose' => 'Kanamalı Mide Ülseri Asit Baskılama'],
                ['name' => 'Transamine 500mg IV Ampul', 'dosage' => '500mg - 1000mg', 'frequency' => '2x1 Yavaş IV', 'route' => 'intravenöz', 'purpose' => 'Mide Ülser Kanaması Durdurucu']
            ],
            'R58' => [
                ['name' => 'Transamine 500mg IV Ampul (Traneksamik Asit)', 'dosage' => '1000mg', 'frequency' => 'Acil IV', 'route' => 'intravenöz', 'purpose' => 'Acil İç Kanama & Pıhtılaşma Desteği'],
                ['name' => 'Serum Fizyolojik %0.9 1000ml IV', 'dosage' => '1000ml', 'frequency' => 'Hızlı IV İnfüzyon', 'route' => 'intravenöz', 'purpose' => 'İç Kanama Hipovolemik Şok Önleyici Sıvı Desteği']
            ],
            'I85' => [
                ['name' => 'Octreotide 0.1mg/ml IV Ampul (Somatostatin)', 'dosage' => '50mcg Bolus + 50mcg/saat', 'frequency' => 'Sürekli İnfüzyon', 'route' => 'intravenöz', 'purpose' => 'Yemek Borusu Varis Kanaması Vazoaktif Basınç Düşürücü'],
                ['name' => 'Nexium 40mg IV Flakon', 'dosage' => '80mg', 'frequency' => '2x1 IV', 'route' => 'intravenöz', 'purpose' => 'Varis Kanaması Mide Asit Koruyucu']
            ],
            'I71' => [
                ['name' => 'Serum Fizyolojik %0.9 1000ml IV', 'dosage' => '2000ml', 'frequency' => 'Çift Damar Yolu Hızlı IV', 'route' => 'intravenöz', 'purpose' => 'Aort Anevrizma Rüptürü Acil Sıvı & Şok Tedavisi'],
                ['name' => 'Transamine 500mg IV Ampul', 'dosage' => '1000mg', 'frequency' => 'Acil IV', 'route' => 'intravenöz', 'purpose' => 'Acil Pıhtılaştırıcı']
            ],
            'N93' => [
                ['name' => 'Buscopan 10mg Film Tablet', 'dosage' => '10mg', 'frequency' => '3x1 (Tok)', 'route' => 'oral', 'purpose' => 'Pelvik & Rahim Kramp Ağrısı Spazmolitiği'],
                ['name' => 'Transamine 500mg Tablet (Traneksamik Asit)', 'dosage' => '500mg', 'frequency' => '3x1 (Tok)', 'route' => 'oral', 'purpose' => 'Anormal Uterus & Düzensiz Lekelenme Kanama Kontrolü']
            ],
            'O00' => [
                ['name' => 'Buscopan 10mg Film Tablet', 'dosage' => '10mg', 'frequency' => '2x1', 'route' => 'oral', 'purpose' => 'Dış Gebelik Kramp Ağrısı Kesici'],
                ['name' => 'Pranox (Doksilamin + B6)', 'dosage' => '2 Tablet', 'frequency' => '1x1 (Yatmadan Önce)', 'route' => 'oral', 'purpose' => 'Bulantı Giderici']
            ],
            'H10' => [
                ['name' => 'Tobrex %0.3 Göz Damlası (Tobramisin)', 'dosage' => '1 Damla', 'frequency' => '4x1 (Göze)', 'route' => 'oftalmik', 'purpose' => 'Bakteriyel Konjonktivit & Çapaklanma Antibiyotik Damlası'],
                ['name' => 'Netira %0.3 Tek Dozluk Göz Damlası', 'dosage' => '1 Damla', 'frequency' => '3x1 (Göze)', 'route' => 'oftalmik', 'purpose' => 'Göz Enfeksiyonu & İltihap Giderici Antibiyotik'],
                ['name' => 'Visine %0.05 Göz Damlası', 'dosage' => '1 Damla', 'frequency' => '3x1 (Göze)', 'route' => 'oftalmik', 'purpose' => 'Gözde Kanlanma, Kızarıklık & Batma Giderici'],
                ['name' => 'Tear Naturale II Göz Damlası', 'dosage' => '1 Damla', 'frequency' => '4x1 (Göze)', 'route' => 'oftalmik', 'purpose' => 'Gözde Batma & Sulanma İçin Suni Göz Yaşı']
            ],
            'E16' => [
                ['name' => 'Dekstroz %20 500ml IV Sudaki Çözeltisi', 'dosage' => '100ml Hızlı Bolus', 'frequency' => 'Acil IV', 'route' => 'intravenöz', 'purpose' => 'Acil Hipoglisemi Kan Şekeri Yükseltici Çözelti'],
                ['name' => 'Glukagon 1mg Hypokit Enjeksiyon', 'dosage' => '1mg', 'frequency' => 'Acil IM', 'route' => 'intramüsküler', 'purpose' => 'Şiddetli Hipoglisemide Acil Şeker Yükseltici İğne']
            ],
            // Sindirim ve Gastroenteroloji (K & A Serisi)
            'A09' => [
                ['name' => 'Ercefuryl 200mg Kapsül', 'dosage' => '200mg', 'frequency' => '3x1 (Tok)', 'route' => 'oral', 'purpose' => 'İntestinal Antiseptik / İshal Tedavisi'],
                ['name' => 'Reflor 250mg Şase', 'dosage' => '250mg', 'frequency' => '2x1 (Aç)', 'route' => 'oral', 'purpose' => 'Probiyotik / Bağırsak Florası Düzenleyici'],
                ['name' => 'Georal Oral Rehidratasyon Tozu', 'dosage' => '1 Poşet / 1L Su', 'frequency' => 'Yudum Yudum', 'route' => 'oral', 'purpose' => 'Elektrolit & Sıvı Kaybı Dengeleyici']
            ],
            'K21' => [
                ['name' => 'Lansor 30mg Kapsül', 'dosage' => '30mg', 'frequency' => '1x1 (Sabah Aç)', 'route' => 'oral', 'purpose' => 'Proton Pompası İnhibitörü (Mide Koruyucu)'],
                ['name' => 'Gaviscon Double Action Likit', 'dosage' => '10ml', 'frequency' => '4x1 (Yemeklerden Sonra)', 'route' => 'oral', 'purpose' => 'Antasit / Reflü Bastırıcı']
            ],
            'K25' => [
                ['name' => 'Nexium 40mg Tablet', 'dosage' => '40mg', 'frequency' => '1x1 (Sabah Aç)', 'route' => 'oral', 'purpose' => 'Ülser Tedavisi / Asit Baskılama'],
                ['name' => 'Gaviscon Double Action Likit', 'dosage' => '10ml', 'frequency' => '3x1', 'route' => 'oral', 'purpose' => 'Mide Mukozası Koruyucu']
            ],
            'K58' => [
                ['name' => 'Duspatalin RETARD 200mg Kapsül', 'dosage' => '200mg', 'frequency' => '2x1 (Aç)', 'route' => 'oral', 'purpose' => 'İntestinal Spazmolitik']
            ],

            // Kas-İskelet ve Ağrı (M & R Serisi)
            'M17' => [
                ['name' => 'Apranax Fort 550mg Tablet', 'dosage' => '550mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'NSAİİ / Yangı ve Ağrı Giderici'],
                ['name' => 'Parol 500mg Tablet', 'dosage' => '500mg', 'frequency' => '3x1', 'route' => 'oral', 'purpose' => 'Analjezik']
            ],
            'M75' => [
                ['name' => 'Apranax Fort 550mg Tablet (Naproksen Sodyum)', 'dosage' => '550mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Rotatör Manşet & Omuz İnflamasyonu Giderici NSAİİ'],
                ['name' => 'Muscoril 4mg Kapsül (Tiokolşikozit)', 'dosage' => '4mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Omuz Çevresi Kas Spazmı Çözücü & Kas Gevşetici'],
                ['name' => 'Voltarol %1 Emulgel 50g', 'dosage' => 'Lokal', 'frequency' => '3x1 (Omza)', 'route' => 'topikal', 'purpose' => 'Lokal Omuz Ağrısı Kesici & Ödem Jeli']
            ],
            'M54' => [
                ['name' => 'Muscoril 4mg Kapsül', 'dosage' => '4mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Kas Gevşetici / Boyun & Bel Tutulması'],
                ['name' => 'Apranax Fort 550mg Tablet', 'dosage' => '550mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Analjezik / Antienflamatuvar']
            ],
            'M25' => [
                ['name' => 'Apranax Fort 550mg Tablet', 'dosage' => '550mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Eklem Ağrısı & Şişliği Giderici NSAİİ'],
                ['name' => 'Voltaren Emulgel %1 Pomad', 'dosage' => 'Lokal', 'frequency' => '3x1 (Haricen)', 'route' => 'topikal', 'purpose' => 'Eklem & Kas Ağrısı Jel']
            ],
            'R25' => [
                ['name' => 'Muscoril 4mg Kapsül', 'dosage' => '4mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Kas Krampları & Spazm Giderici'],
                ['name' => 'Magnesie Calcinee Toz', 'dosage' => '1 Ölçek', 'frequency' => '1x1 (Gece)', 'route' => 'oral', 'purpose' => 'Magnezyum Takviyesi / Kramp Önleyici']
            ],
            'M62' => [
                ['name' => 'Benexol B12 Film Tablet', 'dosage' => '250mg', 'frequency' => '1x1 (Tok)', 'route' => 'oral', 'purpose' => 'Kas & Sinir Güçlendirici B Kompleks'],
                ['name' => 'Supradyn Energy CoQ10', 'dosage' => '1 Tablet', 'frequency' => '1x1', 'route' => 'oral', 'purpose' => 'Kas Enerjisi Desteği']
            ],
            'M89' => [
                ['name' => 'Devit-3 Oral Damla', 'dosage' => '10 Damla', 'frequency' => '1x1 (Günde)', 'route' => 'oral', 'purpose' => 'Kemik D3 Vitamini Takviyesi'],
                ['name' => 'Calcimax D3 Efervesan Tablet', 'dosage' => '1 Tablet', 'frequency' => '1x1 (Suya)', 'route' => 'oral', 'purpose' => 'Kalsiyum & Kemik Güçlendirici']
            ],
            'R26' => [
                ['name' => 'Apranax Fort 550mg Tablet', 'dosage' => '550mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Yürüme Güçlüğü & Ağrı Kesici'],
                ['name' => 'Muscoril 4mg Kapsül', 'dosage' => '4mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Kas Spazm Çözücü']
            ],

            // Sinir, Psikiyatri, Kulak ve Genel Semptomlar (G, F, H, R, D Serisi)
            'G47' => [
                ['name' => 'Desyrel 50mg Tablet', 'dosage' => '50mg', 'frequency' => '1x1 (Gece Yatmadan Önce)', 'route' => 'oral', 'purpose' => 'Uyku Bozukluğu & İnsomnia Tedavisi'],
                ['name' => 'Passiflora Şurup 180ml', 'dosage' => '10ml', 'frequency' => '1x1 (Gece)', 'route' => 'oral', 'purpose' => 'Bitkisel Sedatif / Uyku Destekleyici'],
                ['name' => 'Atarax 25mg Film Tablet', 'dosage' => '25mg', 'frequency' => '1x1 (Gece)', 'route' => 'oral', 'purpose' => 'Anksiyete & Uyku Düzenleyici']
            ],
            'H93' => [
                ['name' => 'Vastarel MR 35mg Film Tablet', 'dosage' => '35mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Vasküler Tinnitus / Kulak Çınlaması Tedavisi'],
                ['name' => 'Betaserc 24mg Tablet', 'dosage' => '24mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'İç Kulak Dolaşımı Düzenleyici']
            ],
            'A09' => [
                ['name' => 'Reflor 250mg Şase (Saccharomyces boulardii)', 'dosage' => '250mg', 'frequency' => '2x1 (Aç)', 'route' => 'oral', 'purpose' => 'Probiyotik / İntestinal Flora Dengeleyici & İshal Durdurucu'],
                ['name' => 'Ge-Oral Toz (Oral Rehidrasyon Sıvısı - ORS)', 'dosage' => '1 Poşet (1L Su)', 'frequency' => 'İnfüzyon / Yudum Yudum', 'route' => 'oral', 'purpose' => 'Akut İshal Dehidrasyonu & Elektrolit Dengeleyici'],
                ['name' => 'Ercefuryl 200mg Kapsül (Nifuroksazid)', 'dosage' => '200mg', 'frequency' => '3x1 (Tok)', 'route' => 'oral', 'purpose' => 'Lokal İntestinal Antiseptik / Bakteriyel-İnfeksiyöz İshal Tedavisi'],
                ['name' => 'Buscopan 10mg Film Tablet', 'dosage' => '10mg', 'frequency' => '3x1 (Krampta)', 'route' => 'oral', 'purpose' => 'Karın Bölgesi Kramp Çözücü & Spazmolitik']
            ],
            'A08' => [
                ['name' => 'Reflor 250mg Şase', 'dosage' => '250mg', 'frequency' => '2x1', 'route' => 'oral', 'purpose' => 'Probiyotik / Viral İshal Durdurucu'],
                ['name' => 'Ge-Oral Toz (ORS)', 'dosage' => '1 Poşet', 'frequency' => 'Bol Sıvı Tüketimi', 'route' => 'oral', 'purpose' => 'Sıvı & Elektrolit Kaybı Dengeleyici'],
                ['name' => 'Zofran 4mg Film Tablet (Ondansetron)', 'dosage' => '4mg', 'frequency' => '2x1 (Gerekirse)', 'route' => 'oral', 'purpose' => 'Gastroenterit Bulantı & Kusma Önleyici']
            ],
            'R41' => [
                ['name' => 'Tebokan Fort 80mg Film Tablet', 'dosage' => '80mg', 'frequency' => '3x1 (Tok)', 'route' => 'oral', 'purpose' => 'Serebral Kan Akımı Artırıcı / Unutkanlık Tedavisi'],
                ['name' => 'Aricept 5mg Film Tablet', 'dosage' => '5mg', 'frequency' => '1x1 (Gece Yatarken)', 'route' => 'oral', 'purpose' => 'Asetilkolinesteraz İnhibitörü / Hafıza Destekleyici']
            ],
            'F90' => [
                ['name' => 'Concerta 18mg Kontrollü Salım Tableti', 'dosage' => '18mg', 'frequency' => '1x1 (Sabah)', 'route' => 'oral', 'purpose' => 'DEHB / Odaklanma Bozukluğu Tedavisi'],
                ['name' => 'Tebokan Fort 80mg Film Tablet', 'dosage' => '80mg', 'frequency' => '2x1', 'route' => 'oral', 'purpose' => 'Konsantrasyon & Zihinsel Performans Destekleyici']
            ],
            'F06' => [
                ['name' => 'Tebokan Fort 80mg Film Tablet', 'dosage' => '80mg', 'frequency' => '3x1 (Tok)', 'route' => 'oral', 'purpose' => 'Zihinsel Performans & Hafıza Desteği'],
                ['name' => 'Cipralex 10mg Film Tablet', 'dosage' => '10mg', 'frequency' => '1x1 (Sabah)', 'route' => 'oral', 'purpose' => 'Odaklanma & Anksiyete Düzeltici']
            ],
            'R20' => [
                ['name' => 'Benexol B12 Film Tablet', 'dosage' => '250mg', 'frequency' => '1x1 (Tok)', 'route' => 'oral', 'purpose' => 'Nörotropik B Kompleks Vitamin / Karıncalanma Giderici'],
                ['name' => 'Nervium 5mg Tablet', 'dosage' => '5mg', 'frequency' => '1x1', 'route' => 'oral', 'purpose' => 'Sinirsel Uyuşma & Karıncalanma Giderici']
            ],
            'R00' => [
                ['name' => 'Beloc ZOK 50mg Tablet', 'dosage' => '50mg', 'frequency' => '1x1 (Sabah)', 'route' => 'oral', 'purpose' => 'Çarpıntı / Ritmi Düzenleyici Beta Blokör'],
                ['name' => 'Dideral 40mg Tablet', 'dosage' => '40mg', 'frequency' => '2x1', 'route' => 'oral', 'purpose' => 'Anksiyete & Çarpıntı Giderici']
            ],
            'R23' => [
                ['name' => 'Stilex Jel 30g', 'dosage' => '30g', 'frequency' => '3x1 (Deriden)', 'route' => 'topikal', 'purpose' => 'Ciltte Kızarıklık, Yangı & Döküntü Jeli'],
                ['name' => 'Allerset 10mg Film Tablet', 'dosage' => '10mg', 'frequency' => '1x1 (Gece)', 'route' => 'oral', 'purpose' => 'Antihistaminik / Kızarıklık & Allerji İlacı'],
                ['name' => 'Hirudoid Forte Jel 40g', 'dosage' => 'Lokal', 'frequency' => '3x1', 'route' => 'topikal', 'purpose' => 'Morarma & Ekimoz Giderici Jel']
            ],
            'R61' => [
                ['name' => 'Beloc ZOK 50mg Tablet', 'dosage' => '50mg', 'frequency' => '1x1', 'route' => 'oral', 'purpose' => 'Sempatik Aktivite & Soğuk Terleme Azaltıcı'],
                ['name' => 'Coraspin 100mg Tablet', 'dosage' => '100mg', 'frequency' => '1x1 (Tok)', 'route' => 'oral', 'purpose' => 'Antiagregan / Kardiyak Koruma']
            ],
            'R60' => [
                ['name' => 'Lasix 40mg Tablet', 'dosage' => '40mg', 'frequency' => '1x1 (Sabah Aç)', 'route' => 'oral', 'purpose' => 'Ödem & Şişlik Giderici Diüretik'],
                ['name' => 'Venoruton Fort 500mg Tablet', 'dosage' => '500mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Venöz Dolaşım Düzenleyici / Ödem Önleyici']
            ],
            'G62' => [
                ['name' => 'Benexol B12 Film Tablet', 'dosage' => '250mg', 'frequency' => '1x1 (Tok)', 'route' => 'oral', 'purpose' => 'Nöropatik Karıncalanma & Uyuşma Tedavisi'],
                ['name' => 'Lyrica 75mg Kapsül', 'dosage' => '75mg', 'frequency' => '2x1', 'route' => 'oral', 'purpose' => 'Nöropatik Ağrı & Karıncalanma İlacı']
            ],
            'R53' => [
                ['name' => 'Bemiks C Film Tablet', 'dosage' => '1 Draje', 'frequency' => '1x1 (Tok)', 'route' => 'oral', 'purpose' => 'Kronik Yorgunluk & Halisizlik Desteği'],
                ['name' => 'Supradyn Energy CoQ10 Film Tablet', 'dosage' => '1 Tablet', 'frequency' => '1x1 (Kahvaltıda)', 'route' => 'oral', 'purpose' => 'Multivitamin & Enerji Takviyesi']
            ],
            'R50' => [
                ['name' => 'Parol 500mg Tablet', 'dosage' => '500mg', 'frequency' => '3x1 (Tok)', 'route' => 'oral', 'purpose' => 'Antipiretik / Ateş Düşürücü'],
                ['name' => 'Calpol Şurup 120mg/5ml', 'dosage' => '5ml', 'frequency' => '3x1', 'route' => 'oral', 'purpose' => 'Ateş & Ağrı Giderici Şurup']
            ],
            'E66' => [
                ['name' => 'Glucophage 1000mg Tablet', 'dosage' => '1000mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Metabolik İnsülin Direnci & Kilo Kontrolü'],
                ['name' => 'Xenical 120mg Kapsül', 'dosage' => '120mg', 'frequency' => '3x1 (Yemekle)', 'route' => 'oral', 'purpose' => 'Lipaz İnhibitörü / Yağ Emilim Engelleyici']
            ],
            'H81' => [
                ['name' => 'Betaserc 24mg Tablet (Betahistin Dihidroklorür)', 'dosage' => '24mg', 'frequency' => '2x1 (Yemekle)', 'route' => 'oral', 'purpose' => 'İç Kulak Kan Akımı Dengeleyici / Vertigo & BPPV Tedavisi'],
                ['name' => 'Dramamine 50mg Tablet (Dimenhidrinat)', 'dosage' => '50mg', 'frequency' => '2x1 (Gerekirse)', 'route' => 'oral', 'purpose' => 'Vestibüler Bulantı & Baş Dönmesi Önleyici Antihistaminik'],
                ['name' => 'Stugeron 25mg Tablet (Sinarizin)', 'dosage' => '25mg', 'frequency' => '3x1', 'route' => 'oral', 'purpose' => 'Labirent / İç Kulak Denge Düzenleyici & Vestibüler Süpresan']
            ],
            'R42' => [
                ['name' => 'Betaserc 24mg Tablet', 'dosage' => '24mg', 'frequency' => '2x1 (Yemekle)', 'route' => 'oral', 'purpose' => 'Vertigo & Baş Dönmesi Dengeleyici'],
                ['name' => 'Dramamine 50mg Tablet', 'dosage' => '50mg', 'frequency' => '2x1', 'route' => 'oral', 'purpose' => 'Baş Dönmesi & Bulantı Önleyici']
            ],
            'R55' => [
                ['name' => 'Serum Fizyolojik %0.9 500ml IV', 'dosage' => '500ml', 'frequency' => 'İnfüzyon', 'route' => 'intravenöz', 'purpose' => 'Hipotansiyon & Baygınlık Hissi Dengeleyici'],
                ['name' => 'Dramamine 50mg Tablet', 'dosage' => '50mg', 'frequency' => '1x1', 'route' => 'oral', 'purpose' => 'Vertigo & Baş Dönmesine Bağlı Baygınlık Önleyici']
            ],
            'D50' => [
                ['name' => 'Maltofer Oral Solüsyon 100mg/5ml', 'dosage' => '5ml', 'frequency' => '1x1 (Aç)', 'route' => 'oral', 'purpose' => 'Demir Eksikliği Anemisi & Yorgunluk Tedavisi'],
                ['name' => 'Ferrum Fort 100mg Film Tablet', 'dosage' => '100mg', 'frequency' => '1x1 (Tok)', 'route' => 'oral', 'purpose' => 'Demir Takviyesi']
            ],
            'R14' => [
                ['name' => 'Meteospasmyl Kapsül', 'dosage' => '60mg', 'frequency' => '3x1 (Yemeklerden Önce)', 'route' => 'oral', 'purpose' => 'Şişkinlik & Gaz Ağrısı Giderici / Antiflatulan'],
                ['name' => 'Duspatalin RETARD 200mg Kapsül', 'dosage' => '200mg', 'frequency' => '2x1 (Aç)', 'route' => 'oral', 'purpose' => 'Gastrointestinal Spazmolitik']
            ],
            'R10' => [
                ['name' => 'Buscopan 10mg Film Tablet', 'dosage' => '10mg', 'frequency' => '3x1 (Aç)', 'route' => 'oral', 'purpose' => 'Karın Ağrısı & Spazm Çözücü'],
                ['name' => 'Parol 500mg Tablet', 'dosage' => '500mg', 'frequency' => '3x1', 'route' => 'oral', 'purpose' => 'Analjezik']
            ],
            'K59' => [
                ['name' => 'Duphalac 667mg/ml Şurup', 'dosage' => '15ml', 'frequency' => '1x1 (Sabah Kahvaltıda)', 'route' => 'oral', 'purpose' => 'Ozmotik Laksatif / Kabızlık Tedavisi'],
                ['name' => 'Bekunis Draje', 'dosage' => '1 Draje', 'frequency' => '1x1 (Gece)', 'route' => 'oral', 'purpose' => 'Bitkisel Laksatif / Bağırsak Çalıştırıcı']
            ],
            'R13' => [
                ['name' => 'Gaviscon Double Action Likit', 'dosage' => '10ml', 'frequency' => '4x1 (Yemeklerden Sonra)', 'route' => 'oral', 'purpose' => 'Yutma Güçlüğü & Reflü Koruyucu'],
                ['name' => 'Lansor 30mg Kapsül', 'dosage' => '30mg', 'frequency' => '1x1 (Sabah Aç)', 'route' => 'oral', 'purpose' => 'Özofajit & Asit Bastırıcı']
            ],
            'R63' => [
                ['name' => 'Prakten 2mg/5ml Şurup', 'dosage' => '5ml', 'frequency' => '3x1 (Yemeklerden Önce)', 'route' => 'oral', 'purpose' => 'İştah Açıcı & Antihistaminik'],
                ['name' => 'Polivit Şurup 100ml', 'dosage' => '5ml', 'frequency' => '1x1', 'route' => 'oral', 'purpose' => 'Multivitamin & İştah Destekleyici']
            ],
            'R19' => [
                ['name' => 'Kloroben Oral Sprey 30ml', 'dosage' => '3 Puf', 'frequency' => '3x1 (Gargara/Sprey)', 'route' => 'topikal', 'purpose' => 'Ağız Dezenfektanı & Halitozis (Ağız Kokusu) Giderici'],
                ['name' => 'Tantum Verde Gargara', 'dosage' => '15ml', 'frequency' => '3x1', 'route' => 'topikal', 'purpose' => 'Lokal Antiseptik']
            ],
            'F32' => [
                ['name' => 'Cipralex 10mg Film Tablet', 'dosage' => '10mg', 'frequency' => '1x1 (Sabah)', 'route' => 'oral', 'purpose' => 'SSRI Antidepresan']
            ],
            'F41' => [
                ['name' => 'Cipralex 10mg Film Tablet', 'dosage' => '10mg', 'frequency' => '1x1 (Sabah)', 'route' => 'oral', 'purpose' => 'Anksiyolitik / Antidepresan'],
                ['name' => 'Xanax 0.5mg Tablet', 'dosage' => '0.5mg', 'frequency' => '1x1 (Gece)', 'route' => 'oral', 'purpose' => 'Kısa Süreli Anksiyete Tedavisi']
            ],
            'G43' => [
                ['name' => 'Relpax 40mg Film Tablet', 'dosage' => '40mg', 'frequency' => '1x1 (Migren Atakta)', 'route' => 'oral', 'purpose' => 'Triptan / Migren Atak İlacı'],
                ['name' => 'Apranax Fort 550mg Tablet', 'dosage' => '550mg', 'frequency' => '1x1', 'route' => 'oral', 'purpose' => 'Analjezik']
            ],

            // Göz, Alerji ve Deri (H & L Serisi)
            'H40' => [
                ['name' => 'Cosopt Göz Damlası', 'dosage' => '5ml', 'frequency' => '2x1 (Göze)', 'route' => 'oftalmik', 'purpose' => 'Göz Tansiyonu / İntraoküler Basınç Düşürücü']
            ],
            'L50' => [
                ['name' => 'Allerset 10mg Film Tablet', 'dosage' => '10mg', 'frequency' => '1x1 (Gece)', 'route' => 'oral', 'purpose' => 'Antihistaminik / Alerji İlacı'],
                ['name' => 'Stilex Jel 30g', 'dosage' => '30g', 'frequency' => '3x1 (Deriden)', 'route' => 'topikal', 'purpose' => 'Kaşıntı Ve Döküntü Giderici']
            ],
            'L29' => [
                ['name' => 'Allerset 10mg Film Tablet', 'dosage' => '10mg', 'frequency' => '1x1 (Gece)', 'route' => 'oral', 'purpose' => 'Antihistaminik / Kaşıntı Giderici'],
                ['name' => 'Stilex Jel 30g', 'dosage' => 'Lokal', 'frequency' => '3x1 (Deriden)', 'route' => 'topikal', 'purpose' => 'Lokal Kaşıntı & Kızarıklık Jeli']
            ],
            'K21' => [
                ['name' => 'Nexium 40mg Enterik Kaplı Tablet', 'dosage' => '40mg', 'frequency' => '1x1 (Sabah Aç)', 'route' => 'oral', 'purpose' => 'Proton Pompası İnhibitörü (PPI) / Mide Asit Süpresyonu & Reflü İlacı'],
                ['name' => 'Gaviscon Double Action 200ml Süspansiyon', 'dosage' => '10ml', 'frequency' => '4x1 (Yemeklerden 30dk Sonra & Gece)', 'route' => 'oral', 'purpose' => 'Aljinat + Antasit / Reflü Bariyeri & Asit Nötralizan'],
                ['name' => 'Rennie Çiğneme Tableti', 'dosage' => '1-2 Tablet', 'frequency' => 'Ağrı/Yanma Anında', 'route' => 'oral', 'purpose' => 'Hızlı Mide Yanması & Ekşime Giderici Antasit']
            ],
            'K29' => [
                ['name' => 'Nexium 40mg Enterik Kaplı Tablet', 'dosage' => '40mg', 'frequency' => '1x1 (Sabah Aç)', 'route' => 'oral', 'purpose' => 'Mide Asidi Dengeleyici & Gastrit İyileştirici PPI'],
                ['name' => 'Gaviscon Double Action 200ml Süspansiyon', 'dosage' => '10ml', 'frequency' => '3x1 (Yemek Sonrası)', 'route' => 'oral', 'purpose' => 'Mide Yanması & Ekşime Karşıtı Şurup'],
                ['name' => 'Famodin 40mg Film Tablet', 'dosage' => '40mg', 'frequency' => '1x1 (Gece Yatarken)', 'route' => 'oral', 'purpose' => 'H2 Reseptör Blokörü Mide Koruyucu']
            ],
            'L27' => [
                ['name' => 'Dermovate %0.05 Krem 30g', 'dosage' => 'Lokal', 'frequency' => '2x1', 'route' => 'topikal', 'purpose' => 'Güçlü Topikal Kortikosteroid / Cilt Döküntüsü'],
                ['name' => 'Allerset 10mg Film Tablet', 'dosage' => '10mg', 'frequency' => '1x1 (Gece)', 'route' => 'oral', 'purpose' => 'Antihistaminik']
            ],
            'L85' => [
                ['name' => 'Excipial Hydro %2 Emülsiyon', 'dosage' => 'Lokal', 'frequency' => '2x1 (Cilde)', 'route' => 'topikal', 'purpose' => 'Üreli Yoğun Nemlendirici / Aşırı Cilt Kuruluğu'],
                ['name' => 'Bepanthol Derma Merhem 30g', 'dosage' => 'Lokal', 'frequency' => '3x1', 'route' => 'topikal', 'purpose' => 'Cilt Bariyeri Onarıcı & Nemlendirici']
            ],
            'L65' => [
                ['name' => 'Priorin 60 Kapsül', 'dosage' => '1 Kapsül', 'frequency' => '2x1 (Yemekten Sonra)', 'route' => 'oral', 'purpose' => 'Saç Kökü Besleyici & Dökülme Karşıtı Vitamin'],
                ['name' => 'Pantogar Kapsül', 'dosage' => '1 Kapsül', 'frequency' => '3x1 (Tok)', 'route' => 'oral', 'purpose' => 'Keratin & Aminoasit Saç Desteği']
            ],
            'L60' => [
                ['name' => 'Medobiotin 5mg Tablet', 'dosage' => '5mg', 'frequency' => '1x1 (Tok)', 'route' => 'oral', 'purpose' => 'Biotin (H Vitamini) / Tırnak Kırılması & Sertleştirici'],
                ['name' => 'Priorin 60 Kapsül', 'dosage' => '1 Kapsül', 'frequency' => '2x1', 'route' => 'oral', 'purpose' => 'Tırnak & Saç Besleyici']
            ],
            'L74' => [
                ['name' => 'Perspirex Sprey 20ml', 'dosage' => 'Lokal', 'frequency' => 'Gece Yatmadan', 'route' => 'topikal', 'purpose' => 'Terleme Düzenleyici & Aşırı Terleme Önleyici'],
                ['name' => 'Beloc ZOK 50mg Tablet', 'dosage' => '50mg', 'frequency' => '1x1', 'route' => 'oral', 'purpose' => 'Sempatik Terleme Kontrolü']
            ],
            'L70' => [
                ['name' => 'Clindoxyl Jel 30g', 'dosage' => 'Lokal', 'frequency' => '1x1 (Gece)', 'route' => 'topikal', 'purpose' => 'Akne & Sivilce Kurutucu Antibiyotikli Jel'],
                ['name' => 'Tetradox 100mg Kapsül', 'dosage' => '100mg', 'frequency' => '1x1 (Tok)', 'route' => 'oral', 'purpose' => 'Sivilce & Akne Sistemik Antibiyotik Tedavisi']
            ],
            // Tahriş & İritasyon & Pişik İlaçları (L24, L25, L30, L22, J31)
            'L24' => [
                ['name' => 'Bepanthol Derma Merhem 30g', 'dosage' => '30g', 'frequency' => '3x1 (Deriden)', 'route' => 'topikal', 'purpose' => 'Cilt Bariyeri Onarıcı & Tahriş Giderici Merhem'],
                ['name' => 'Stilex Jel 30g', 'dosage' => '30g', 'frequency' => '3x1 (Sürerek)', 'route' => 'topikal', 'purpose' => 'Lokal Cilt Tahrişi, Kızarıklık & Kaşıntı Jeli'],
                ['name' => 'Allerset 10mg Film Tablet', 'dosage' => '10mg', 'frequency' => '1x1 (Gece)', 'route' => 'oral', 'purpose' => 'Cilt İritasyonu Antihistaminik']
            ],
            'L25' => [
                ['name' => 'Bepanthol Derma Merhem 30g', 'dosage' => '30g', 'frequency' => '3x1', 'route' => 'topikal', 'purpose' => 'Tahriş & İritasyon Onarıcı Krem'],
                ['name' => 'Stilex Jel 30g', 'dosage' => '30g', 'frequency' => '3x1', 'route' => 'topikal', 'purpose' => 'Lokal İritasyon & Kızarıklık Jeli']
            ],
            'L30' => [
                ['name' => 'Bepanthol Derma Merhem 30g', 'dosage' => '30g', 'frequency' => '3x1', 'route' => 'topikal', 'purpose' => 'Dermatit & Cilt Tahrişi Nemlendirici'],
                ['name' => 'Advantan %0.1 Krem 30g', 'dosage' => '30g', 'frequency' => '1x1', 'route' => 'topikal', 'purpose' => 'Topikal Kortikosteroid / Şiddetli Tahriş & Egzama']
            ],
            'L22' => [
                ['name' => 'Sudocrem Bebek Bakım Kremi 60g', 'dosage' => '60g', 'frequency' => '3x1', 'route' => 'topikal', 'purpose' => 'Pişik & Cilt Tahrişi Önleyici Koruyucu Krem'],
                ['name' => 'Bepanthol Baby Pişik Merhemi 30g', 'dosage' => '30g', 'frequency' => '3x1', 'route' => 'topikal', 'purpose' => 'Pişik & Tahriş Onarıcı Merhem']
            ],
            'J31' => [
                ['name' => 'Tantum Verde Gargara 120ml', 'dosage' => '15ml', 'frequency' => '3x1', 'route' => 'topikal', 'purpose' => 'Boğaz Tahrişi & Yangı Giderici Gargara'],
                ['name' => 'Kloroben Oral Sprey 30ml', 'dosage' => '3 Puf', 'frequency' => '3x1', 'route' => 'topikal', 'purpose' => 'Boğaz Antiseptiği & Sprey'],
                ['name' => 'Strepsils Boğaz Pastili', 'dosage' => '1 Pastil', 'frequency' => '4x1', 'route' => 'oral', 'purpose' => 'Boğaz Tahrişi Yumuşatıcı Pastil']
            ],

            'N39' => [
                ['name' => 'Monurol 3g Efervesan Şase', 'dosage' => '3g', 'frequency' => '1 Tek Doz (Gece Aç)', 'route' => 'oral', 'purpose' => 'İdrar Yolu Antiseptiği & Yanma Giderici'],
                ['name' => 'Cipro 500mg Film Tablet', 'dosage' => '500mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Üriner Sistem Antibiyotiği']
            ],
            'R30' => [
                ['name' => 'Monurol 3g Efervesan Şase', 'dosage' => '3g', 'frequency' => '1 Tek Doz', 'route' => 'oral', 'purpose' => 'Dizüri & Sık İdrara Çıkma İlacı'],
                ['name' => 'Buscopan 10mg Film Tablet', 'dosage' => '10mg', 'frequency' => '3x1', 'route' => 'oral', 'purpose' => 'Mesane Spazm Çözücü']
            ],
            'N20' => [
                ['name' => 'Flomax 0.4mg Kapsül', 'dosage' => '0.4mg', 'frequency' => '1x1 (Günde 1 Tok)', 'route' => 'oral', 'purpose' => 'Alfa-1 Blokör / Üreter Taş Düşürmeyi Kolaylaştırıcı Medikal Ekspulsif Tedavi'],
                ['name' => 'Buscopan Compositum Draje', 'dosage' => '1 Draje', 'frequency' => '3x1 (Ağrıda)', 'route' => 'oral', 'purpose' => 'Üreter Spazm Çözücü & Renal Kolik Ağrı Kesici'],
                ['name' => 'Majezik 100mg Film Tablet', 'dosage' => '100mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Renal Kolik İnflamasyon & Şiddetli Ağrı Kesici NSAİİ']
            ],
            'N23' => [
                ['name' => 'Flomax 0.4mg Kapsül', 'dosage' => '0.4mg', 'frequency' => '1x1 (Günde 1 Tok)', 'route' => 'oral', 'purpose' => 'Alfa Blokör / Taş Düşürmeyi Hızlandırıcı Tedavi'],
                ['name' => 'Buscopan Compositum Draje', 'dosage' => '1 Draje', 'frequency' => '3x1 (Ağrıda)', 'route' => 'oral', 'purpose' => 'Renal Kolik Ağrı Kesici & Spazmolitik'],
                ['name' => 'Parol 1000mg IV Flakon / Tablet', 'dosage' => '1000mg', 'frequency' => '3x1', 'route' => 'oral', 'purpose' => 'Analjezik']
            ],
            'H53' => [
                ['name' => 'Tear Naturale II Göz Damlası', 'dosage' => '15ml', 'frequency' => '4x1 (Göze)', 'route' => 'oftalmik', 'purpose' => 'Suni Göz Yaşı / Bulanık Görme Desteği'],
                ['name' => 'Visine %0.05 Göz Damlası', 'dosage' => '15ml', 'frequency' => '3x1', 'route' => 'oftalmik', 'purpose' => 'Göz Yorgunluğu & Dekonjestan']
            ],
            'H04' => [
                ['name' => 'TobraDex Göz Damlası', 'dosage' => '5ml', 'frequency' => '3x1 (Göze)', 'route' => 'oftalmik', 'purpose' => 'Göz Sulanması & Enfeksiyon Giderici Damla'],
                ['name' => 'Refresh Liquigel Göz Damlası', 'dosage' => '15ml', 'frequency' => '4x1', 'route' => 'oftalmik', 'purpose' => 'Göz Yüzeyi Nemlendirici']
            ],
            'R68' => [
                ['name' => 'Kloroben Oral Sprey 30ml', 'dosage' => '3 Puf', 'frequency' => '3x1', 'route' => 'topikal', 'purpose' => 'Ağız Dezenfektanı & Nemlendirici'],
                ['name' => 'Biotene Oral Nemlendirici Jel', 'dosage' => 'Lokal', 'frequency' => 'İhtiyaç Halinde', 'route' => 'topikal', 'purpose' => 'Ağız Kuruluğu Jeli']
            ],
            'W45' => [
                ['name' => 'Augmentin 1000mg Film Tablet', 'dosage' => '1000mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Yara Enfeksiyonu & Doku Antibiyotiği'],
                ['name' => 'Anestol Pomad %5 30g', 'dosage' => '30g', 'frequency' => '3x1 (Haricen)', 'route' => 'topikal', 'purpose' => 'Yara & Batan Cisim Ağrı Kesici Merhem'],
                ['name' => 'Bepanthen Plus Krem 30g', 'dosage' => '30g', 'frequency' => '2x1', 'route' => 'topikal', 'purpose' => 'Doku Onarıcı & Antiseptik Yara Jeli']
            ],
            'S91' => [
                ['name' => 'Augmentin 1000mg Film Tablet', 'dosage' => '1000mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Ayak Yara & Enfeksiyon Antibiyotiği'],
                ['name' => 'Anestol Pomad %5 30g', 'dosage' => '30g', 'frequency' => '3x1', 'route' => 'topikal', 'purpose' => 'Lokal Yara Ağrı Kesici Merhem']
            ],
            'B35' => [
                ['name' => 'Exoderil %1 Krem 30g', 'dosage' => '30g', 'frequency' => '2x1 (Deriden)', 'route' => 'topikal', 'purpose' => 'Topikal Antifungal / Ayak & Cilt Mantar Jeli'],
                ['name' => 'Travocort Krem 30g', 'dosage' => '30g', 'frequency' => '2x1 (Sürerek)', 'route' => 'topikal', 'purpose' => 'İltihaplı & Kaşıntılı Mantar İlacı'],
                ['name' => 'Terbisil 250mg Tablet', 'dosage' => '250mg', 'frequency' => '1x1 (Tok)', 'route' => 'oral', 'purpose' => 'Sistemik Mantar Tedavisi Oral Antifungal'],
                ['name' => 'Nibulen Tırnak Cilası Seti', 'dosage' => '3g', 'frequency' => '1x1 (Tırnağa)', 'route' => 'topikal', 'purpose' => 'Tırnak Mantarı Seti & Antifungal Cila']
            ],
            'S52' => [
                ['name' => 'Apranax Fort 550mg Tablet', 'dosage' => '550mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Kırık Ağrısı & Antienflamatuvar NSAİİ'],
                ['name' => 'Muscoril 4mg Kapsül', 'dosage' => '4mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Kırık Çevresi Kas Spazmı Giderici'],
                ['name' => 'Voltarol %1 Emulgel 50g', 'dosage' => '50g', 'frequency' => '3x1', 'route' => 'topikal', 'purpose' => 'Lokal Ağrı Kesici & Ödem Jeli']
            ],
            'S82' => [
                ['name' => 'Apranax Fort 550mg Tablet', 'dosage' => '550mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Kırık Ağrı & Ödem Kesici'],
                ['name' => 'Muscoril 4mg Kapsül', 'dosage' => '4mg', 'frequency' => '2x1', 'route' => 'oral', 'purpose' => 'Kas Spazmı Giderici']
            ],
            'S62' => [
                ['name' => 'Apranax Fort 550mg Tablet', 'dosage' => '550mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'El/Bilek Kırık Ağrısı Kesici'],
                ['name' => 'Parol 500mg Tablet', 'dosage' => '500mg', 'frequency' => '3x1', 'route' => 'oral', 'purpose' => 'Analjezik']
            ],
            'S43' => [
                ['name' => 'Muscoril 4mg Kapsül', 'dosage' => '4mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Omuz Çıkığı Kas Gevşetici & Spazm Çözücü'],
                ['name' => 'Apranax Fort 550mg Tablet', 'dosage' => '550mg', 'frequency' => '2x1', 'route' => 'oral', 'purpose' => 'Şiddetli Ağrı & Ödem Giderici']
            ],
            'S63' => [
                ['name' => 'Apranax Fort 550mg Tablet', 'dosage' => '550mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Parmak Çıkık & Ağrı Kesici'],
                ['name' => 'Voltarol %1 Emulgel 50g', 'dosage' => '50g', 'frequency' => '3x1', 'route' => 'topikal', 'purpose' => 'Lokal Ödem & Ağrı Jeli']
            ],
            'S93' => [
                ['name' => 'Apranax Fort 550mg Tablet', 'dosage' => '550mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Burkulma & Şişlik Giderici NSAİİ'],
                ['name' => 'Voltarol %1 Emulgel 50g', 'dosage' => '50g', 'frequency' => '3x1 (Haricen)', 'route' => 'topikal', 'purpose' => 'Lokal Burkulma & Ödem Jeli'],
                ['name' => 'Hirudoid Forte Jel 40g', 'dosage' => '40g', 'frequency' => '3x1', 'route' => 'topikal', 'purpose' => 'Morarma & Ödem Giderici Jel']
            ],
            'S61' => [
                ['name' => 'Augmentin 1000mg Film Tablet', 'dosage' => '1000mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Kesik Yara Enfeksiyonu Antibiyotiği'],
                ['name' => 'Baticon %10 Antiseptik Solüsyon 100ml', 'dosage' => '100ml', 'frequency' => 'Haricen Yaraya', 'route' => 'topikal', 'purpose' => 'Lokal Baticon Dezenfektanı'],
                ['name' => 'Anestol Pomad %5 30g', 'dosage' => '30g', 'frequency' => '3x1', 'route' => 'topikal', 'purpose' => 'Kesik Yarası Ağrı Kesici Merhem']
            ],
            'S51' => [
                ['name' => 'Augmentin 1000mg Film Tablet', 'dosage' => '1000mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Doku Kesisinde Enfeksiyon Önleyici Antibiyotik'],
                ['name' => 'Baticon %10 Antiseptik Solüsyon 100ml', 'dosage' => '100ml', 'frequency' => 'Haricen', 'route' => 'topikal', 'purpose' => 'Antiseptik Solüsyon']
            ],
            'F41' => [
                ['name' => 'Selectra 50mg Film Tablet', 'dosage' => '50mg', 'frequency' => '1x1 (Sabah Tok)', 'route' => 'oral', 'purpose' => 'Antidepresan / SSRI Anksiyete & Panik Atak İlacı'],
                ['name' => 'Passiflora 180ml Şurup', 'dosage' => '10ml', 'frequency' => '2x1 (Aç/Tok)', 'route' => 'oral', 'purpose' => 'Bitkisel Anksiyolitik / Doğal Rahatlatıcı Sedatif'],
                ['name' => 'Atarax 25mg Film Tablet', 'dosage' => '25mg', 'frequency' => '1x1 (Gece)', 'route' => 'oral', 'purpose' => 'Anksiyete Kesici & Sakinleştirici Antihistaminik']
            ],
            'T14' => [
                ['name' => 'Augmentin 1000mg Film Tablet', 'dosage' => '1000mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Yara & Kesik Enfeksiyon Antibiyotiği'],
                ['name' => 'Anestol Pomad %5 30g', 'dosage' => '30g', 'frequency' => '3x1', 'route' => 'topikal', 'purpose' => 'Yara Ağrı Kesici Lokal Krem'],
                ['name' => 'Parol 500mg Tablet', 'dosage' => '500mg', 'frequency' => '3x1', 'route' => 'oral', 'purpose' => 'Analjezik']
            ],
            // Onkoloji & Kanser İlaçları (C Serisi)
            'C50' => [
                ['name' => 'Tamoksifen 20mg Tablet', 'dosage' => '20mg', 'frequency' => '1x1 (Tok)', 'route' => 'oral', 'purpose' => 'Hormonoterapi / Meme Kanseri Tedavisi'],
                ['name' => 'Femara 2.5mg Film Tablet', 'dosage' => '2.5mg', 'frequency' => '1x1', 'route' => 'oral', 'purpose' => 'Aromataz İnhibitörü'],
                ['name' => 'Zofran 8mg Film Tablet', 'dosage' => '8mg', 'frequency' => '2x1', 'route' => 'oral', 'purpose' => 'Kemoterapi Bulantı Önleyici']
            ],
            'C34' => [
                ['name' => 'Tarceva 150mg Film Tablet', 'dosage' => '150mg', 'frequency' => '1x1 (Aç)', 'route' => 'oral', 'purpose' => 'Akciğer Onkoloji Tedavisi'],
                ['name' => 'Zofran 8mg Film Tablet', 'dosage' => '8mg', 'frequency' => '2x1', 'route' => 'oral', 'purpose' => 'Bulantı & Kusma Önleyici Antiemetik']
            ],
            'C18' => [
                ['name' => 'Xeloda 500mg Film Tablet', 'dosage' => '500mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Gastrointestinal Kolon Onkoloji İlacı'],
                ['name' => 'Zofran 8mg Film Tablet', 'dosage' => '8mg', 'frequency' => '2x1', 'route' => 'oral', 'purpose' => 'Bulantı Önleyici']
            ],
            'C16' => [
                ['name' => 'Xeloda 500mg Film Tablet', 'dosage' => '500mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Mide Onkoloji Tedavisi'],
                ['name' => 'Zofran 8mg Film Tablet', 'dosage' => '8mg', 'frequency' => '2x1', 'route' => 'oral', 'purpose' => 'Antiemetik']
            ],
            'C61' => [
                ['name' => 'Casodex 50mg Film Tablet', 'dosage' => '50mg', 'frequency' => '1x1', 'route' => 'oral', 'purpose' => 'Antiandrojen Prostat Kanseri İlacı'],
                ['name' => 'Proscar 5mg Film Tablet', 'dosage' => '5mg', 'frequency' => '1x1', 'route' => 'oral', 'purpose' => 'Prostat Düzenleyici']
            ],
            'C80' => [
                ['name' => 'Endoxan 50mg Draje', 'dosage' => '50mg', 'frequency' => '1x1', 'route' => 'oral', 'purpose' => 'Antineoplastik Kemoterapi İlacı'],
                ['name' => 'Zofran 8mg Film Tablet', 'dosage' => '8mg', 'frequency' => '2x1', 'route' => 'oral', 'purpose' => 'Antiemetik / Bulantı Kesici']
            ],
            'C91' => [
                ['name' => 'Endoxan 50mg Draje', 'dosage' => '50mg', 'frequency' => '1x1', 'route' => 'oral', 'purpose' => 'Lösemi Kemoterapi İlacı'],
                ['name' => 'Bemiks C Film Tablet', 'dosage' => '1 Draje', 'frequency' => '1x1', 'route' => 'oral', 'purpose' => 'Destekleyici Vitamin']
            ],
            'C85' => [
                ['name' => 'Endoxan 50mg Draje', 'dosage' => '50mg', 'frequency' => '1x1', 'route' => 'oral', 'purpose' => 'Lenfoma Onkoloji İlacı']
            ],

            // Diş, Ağız & Çene İlaçları (K00 - K14 Serisi)
            'K08' => [
                ['name' => 'Apranax Fort 550mg Tablet', 'dosage' => '550mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Şiddetli Diş Ağrısı Kesici NSAİİ'],
                ['name' => 'Kloroben Oral Sprey 30ml', 'dosage' => '3 Puf', 'frequency' => '3x1', 'route' => 'topikal', 'purpose' => 'Ağız Dezenfektanı & Gargara'],
                ['name' => 'Majezik %0.25 Oral Sprey', 'dosage' => '3 Puf', 'frequency' => '3x1', 'route' => 'topikal', 'purpose' => 'Lokal Diş Ağrısı Spreyi']
            ],
            'K02' => [
                ['name' => 'Apranax Fort 550mg Tablet', 'dosage' => '550mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Çürük Diş Ağrısı Kesici'],
                ['name' => 'Kloroben Oral Sprey 30ml', 'dosage' => '3 Puf', 'frequency' => '3x1', 'route' => 'topikal', 'purpose' => 'Ağız Antiseptiği']
            ],
            'K04' => [
                ['name' => 'Klamoks BID 1000mg Tablet', 'dosage' => '1000mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Diş Apsei & İltihap Antibiyotiği'],
                ['name' => 'Apranax Fort 550mg Tablet', 'dosage' => '550mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Diş Zonklama & Şişlik Ağrı Kesici'],
                ['name' => 'Kloroben Gargara 200ml', 'dosage' => '15ml', 'frequency' => '3x1', 'route' => 'topikal', 'purpose' => 'Ağız Dezenfektanı & Antiseptik']
            ],
            'K05' => [
                ['name' => 'Kloroben Gargara 200ml', 'dosage' => '15ml', 'frequency' => '3x1', 'route' => 'topikal', 'purpose' => 'Diş Eti İltihabı & Kanama Antiseptiği'],
                ['name' => 'Tantum Verde Gargara', 'dosage' => '15ml', 'frequency' => '3x1', 'route' => 'topikal', 'purpose' => 'Yangı Giderici Gargara'],
                ['name' => 'Parol 500mg Tablet', 'dosage' => '500mg', 'frequency' => '3x1', 'route' => 'oral', 'purpose' => 'Analjezik']
            ],
            'K12' => [
                ['name' => 'Kenacort-A Orabase Pomad 5g', 'dosage' => '5g', 'frequency' => '3x1 (Yaraya)', 'route' => 'topikal', 'purpose' => 'Ağız İçi Aft & Yara Kremi'],
                ['name' => 'Kloroben Oral Sprey 30ml', 'dosage' => '3 Puf', 'frequency' => '3x1', 'route' => 'topikal', 'purpose' => 'Ağız Dezenfektanı'],
                ['name' => 'Pyralvex Solüsyon 10ml', 'dosage' => 'Lokal', 'frequency' => '3x1', 'route' => 'topikal', 'purpose' => 'Aft Ve Diş Eti Solüsyonu']
            ],
            'K07' => [
                ['name' => 'Muscoril 4mg Kapsül', 'dosage' => '4mg', 'frequency' => '2x1 (Tok)', 'route' => 'oral', 'purpose' => 'Çene Kası Spazm Giderici'],
                ['name' => 'Apranax Fort 550mg Tablet', 'dosage' => '550mg', 'frequency' => '2x1', 'route' => 'oral', 'purpose' => 'Çene Eklem Ağrısı Kesici']
            ]
        ];




        return $drugMap[$codePrefix] ?? [
            ['name' => 'Parol 500mg Tablet', 'dosage' => '500mg', 'frequency' => '3x1 (Tok)', 'route' => 'oral', 'purpose' => 'Semptomatik Ağrı Giderici'],
            ['name' => 'Lansor 30mg Kapsül', 'dosage' => '30mg', 'frequency' => '1x1 (Sabah Aç)', 'route' => 'oral', 'purpose' => 'Mide Koruyucu']
        ];
    }
}

