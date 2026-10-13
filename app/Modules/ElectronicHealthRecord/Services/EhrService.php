<?php

namespace App\Modules\ElectronicHealthRecord\Services;

use App\Modules\Patient\Models\Patient;
use App\Modules\Prescription\Models\Prescription;
use App\Modules\MedicalReport\Models\MedicalReport;
use Illuminate\Support\Collection;

class EhrService
{
    /**
     * Hastanın tüm tıbbi geçmişini (reçete, muayene, yatış, rapor) kronolojik Zaman Tüneline dönüştürür.
     */
    public function getPatientEhrSummary(Patient $patient): array
    {
        $patient->load([
            'episodesOfCare.encounters.physician',
            'encounters.physician',
            'prescriptions.items',
            'prescriptions.physician',
        ]);

        $timelineEvents = new Collection();

        // 1. Reçeteler
        foreach ($patient->prescriptions as $rx) {
            $drugList = $rx->items->pluck('drug_name')->join(', ');
            $timelineEvents->push([
                'id'          => 'rx_' . $rx->id,
                'date'        => $rx->created_at ? $rx->created_at->format('d.m.Y H:i') : now()->format('d.m.Y H:i'),
                'raw_date'    => $rx->created_at ?? now(),
                'type'        => 'E-Reçete',
                'badge'       => 'purple',
                'icon'        => 'fa-pills',
                'title'       => "Reçete #{$rx->prescription_code}",
                'subtitle'    => "Tanı Kodu: {$rx->diagnosis_code} | Hekim: " . ($rx->physician->name ?? 'Dr. Klinik Hekim'),
                'description' => "Yazılan İlaçlar: " . ($drugList ?: 'Tanımlı ilaç yok'),
                'status'      => $rx->is_erecepta_sent ? 'SGK E-Reçete Onaylı' : 'Taslak Reçete',
                'link'        => route('prescription.index'),
            ]);
        }

        // 2. Muayene / Kabuller (Encounters)
        foreach ($patient->encounters as $enc) {
            $timelineEvents->push([
                'id'          => 'enc_' . $enc->id,
                'date'        => $enc->encounter_date ? $enc->encounter_date->format('d.m.Y H:i') : now()->subDays(2)->format('d.m.Y H:i'),
                'raw_date'    => $enc->encounter_date ?? now()->subDays(2),
                'type'        => 'Muayene / Kabul',
                'badge'       => 'primary',
                'icon'        => 'fa-notes-medical',
                'title'       => "Poliklinik Muayenesi (" . strtoupper($enc->type ?? 'Giriş') . ")",
                'subtitle'    => "Hekim: " . ($enc->physician->name ?? 'Dr. Poliklinik Hekimi'),
                'description' => "Şikayet & Muayene Notu: Hasta genel sağlık kontrolü ve semptom değerlendirmesi yapıldı.",
                'status'      => $enc->status === 'completed' ? 'Muayene Tamamlandı' : 'Devam Ediyor',
                'link'        => route('patients.show', $patient),
            ]);
        }

        // 3. Tıbbi Raporlar (MedicalReport modülünden)
        $medicalReports = MedicalReport::where('patient_id', $patient->id)->get();
        foreach ($medicalReports as $report) {
            $timelineEvents->push([
                'id'          => 'rep_' . $report->id,
                'date'        => $report->created_at ? $report->created_at->format('d.m.Y H:i') : now()->subDays(5)->format('d.m.Y H:i'),
                'raw_date'    => $report->created_at ?? now()->subDays(5),
                'type'        => 'Tıbbi Rapor',
                'badge'       => 'success',
                'icon'        => 'fa-file-medical',
                'title'       => "Sağlık / Durum Raporu #{$report->report_code}",
                'subtitle'    => "Rapor Türü: " . ucfirst($report->report_type ?? 'Durum Raporu'),
                'description' => "Teşhis: " . ($report->diagnosis ?? 'Genel Durum Değerlendirmesi'),
                'status'      => $report->status === 'approved' ? 'Başhekimlikçe Onaylandı' : 'Onay Bekliyor',
                'link'        => route('medical_report.index'),
            ]);
        }

        // 4. Varsayılan Hayati Bulgular (Vitals Panel) - Session veya Varsayılan
        $vitalsKey = 'patient_vitals_' . $patient->id;
        $vitals = session($vitalsKey, [
            'blood_pressure' => '120/80 mmHg',
            'pulse'          => '72 /dk',
            'fever'          => '36.6 °C',
            'spo2'           => '%98',
            'respiration'    => '16 /dk',
            'last_update'    => now()->format('d.m.Y H:i'),
        ]);

        // Zaman Tüneli Olaylarını Tarihe Göre Yeniden Sırala
        $sortedTimeline = $timelineEvents->sortByDesc('raw_date')->values()->all();

        return [
            'patient'  => $patient,
            'timeline' => $sortedTimeline,
            'vitals'   => $vitals,
            'stats'    => [
                'total_encounters'    => $patient->encounters->count(),
                'total_prescriptions' => $patient->prescriptions->count(),
                'total_reports'       => $medicalReports->count(),
            ],
        ];
    }

    /**
     * Hastaya yeni hayati bulgu kaydeder.
     */
    public function saveVitalSigns(int $patientId, array $data): array
    {
        $vitalsKey = 'patient_vitals_' . $patientId;
        $vitals = [
            'blood_pressure' => $data['blood_pressure'] ?? '120/80 mmHg',
            'pulse'          => ($data['pulse'] ?? '72') . ' /dk',
            'fever'          => ($data['fever'] ?? '36.6') . ' °C',
            'spo2'           => '%' . ($data['spo2'] ?? '98'),
            'respiration'    => ($data['respiration'] ?? '16') . ' /dk',
            'last_update'    => now()->format('d.m.Y H:i'),
        ];

        session([$vitalsKey => $vitals]);
        return $vitals;
    }
}
