<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>EHR Tıbbi Özet - {{ $patient->full_name }}</title>
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 12px; color: #333; line-height: 1.5; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #2563eb; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2 { margin: 0; color: #1e3a8a; }
        .patient-box { background: #f8fafc; border: 1px solid #e2e8f0; padding: 12px; border-radius: 6px; margin-bottom: 20px; }
        .section-title { background: #2563eb; color: #fff; padding: 6px 10px; font-weight: bold; border-radius: 4px; margin-top: 20px; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        th, td { border: 1px solid #cbd5e1; padding: 8px; text-align: left; }
        th { background-color: #f1f5f9; }
        .footer { margin-top: 40px; text-align: right; font-size: 10px; color: #64748b; }
    </style>
</head>
<body>

    <div class="header">
        <h2>T.C. HASTANE BİLGİ YÖNETİM SİSTEMİ</h2>
        <h3>ELEKTRONİK HASTA TIBBİ ÖZET RAPORU (EHR)</h3>
        <p>Rapor Tarihi: {{ now()->format('d.m.Y H:i') }}</p>
    </div>

    <div class="patient-box">
        <strong>Hasta Adı Soyadı:</strong> {{ $patient->full_name }}<br>
        <strong>T.C. Kimlik No:</strong> {{ $patient->national_id }}<br>
        <strong>Doğum Tarihi / Yaş:</strong> {{ $patient->birth_date ? $patient->birth_date->format('d.m.Y') : '-' }} ({{ $patient->birth_date ? $patient->birth_date->age : '-' }} Yaş)<br>
        <strong>Cinsiyet:</strong> {{ $patient->gender === 'male' ? 'Erkek' : 'Kadın' }} | <strong>Kan Grubu:</strong> {{ $patient->blood_type ?? 'Belirtilmedi' }}<br>
        <strong>Tıbbi Alerjiler:</strong> {{ $patient->allergies ?? 'Bilinen alerjisi yok' }}<br>
        <strong>Kronik Hastalıklar:</strong> {{ $patient->chronic_conditions ?? 'Bilinen kronik tanısı yok' }}
    </div>

    <div class="section-title">SON HAYATİ BULGULAR (VITALS)</div>
    <table>
        <tr>
            <th>Tansiyon</th>
            <th>Nabız</th>
            <th>Ateş</th>
            <th>SpO2</th>
            <th>Solunum</th>
        </tr>
        <tr>
            <td>{{ $vitals['blood_pressure'] }}</td>
            <td>{{ $vitals['pulse'] }}</td>
            <td>{{ $vitals['fever'] }}</td>
            <td>{{ $vitals['spo2'] }}</td>
            <td>{{ $vitals['respiration'] }}</td>
        </tr>
    </table>

    <div class="section-title">TIBBİ GEÇMİŞ ZAMAN TÜNELİ (KRONOLOJİK)</div>
    <table>
        <thead>
            <tr>
                <th>Tarih</th>
                <th>İşlem / Türü</th>
                <th>Başlık / Açıklama</th>
                <th>Durum</th>
            </tr>
        </thead>
        <tbody>
            @foreach($timeline as $event)
                <tr>
                    <td>{{ $event['date'] }}</td>
                    <td><strong>{{ $event['type'] }}</strong></td>
                    <td>{{ $event['title'] }} - {{ $event['description'] }}</td>
                    <td>{{ $event['status'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Bu döküman HBYS Core Elektronik Hasta Kayıt Sistemi tarafından otomatik üretilmiştir.<br>
        Doktor E-İmza: ___________________________
    </div>

    <script>
        window.onload = function() { window.print(); }
    </script>
</body>
</html>
