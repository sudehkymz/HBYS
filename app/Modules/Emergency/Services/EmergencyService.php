<?php

namespace App\Modules\Emergency\Services;

use App\Modules\Emergency\Models\EmergencyTriage;
use App\Modules\Patient\Models\Patient;

class EmergencyService
{
    /**
     * Acil Servis Triyaj Paneli verilerini Kırmızı > Sarı > Yeşil sırasına göre getirir.
     */
    public function getEmergencyDashboardData(): array
    {
        // Kırmızı kodlular en üstte olacak şekilde sıralama (Hem MySQL hem SQLite uyumlu CASE WHEN)
        $triages = EmergencyTriage::with(['patient', 'doctor'])
            ->whereIn('status', ['waiting', 'in_treatment'])
            ->orderByRaw("CASE triage_category WHEN 'red' THEN 1 WHEN 'yellow' THEN 2 WHEN 'green' THEN 3 ELSE 4 END")
            ->orderBy('created_at', 'asc')
            ->get();

        $completedCount = EmergencyTriage::whereIn('status', ['discharged', 'transferred'])
            ->whereDate('created_at', date('Y-m-d'))
            ->count();

        return [
            'triages' => $triages,
            'stats'   => [
                'red_count'       => $triages->where('triage_category', 'red')->count(),
                'yellow_count'    => $triages->where('triage_category', 'yellow')->count(),
                'green_count'     => $triages->where('triage_category', 'green')->count(),
                'completed_count' => $completedCount,
            ],
        ];
    }

    /**
     * Yeni Acil Kayıt ve Triyaj sınıflandırması oluşturur.
     */
    public function createTriage(array $data): EmergencyTriage
    {
        return EmergencyTriage::create([
            'patient_id'         => $data['patient_id'],
            'triage_category'    => $data['triage_category'] ?? 'yellow',
            'chief_complaint'    => $data['chief_complaint'],
            'vital_signs'        => [
                'blood_pressure' => $data['blood_pressure'] ?? '120/80',
                'pulse'          => $data['pulse'] ?? '75',
                'fever'          => $data['fever'] ?? '36.6',
                'spo2'           => $data['spo2'] ?? '98',
            ],
            'assigned_doctor_id' => $data['assigned_doctor_id'] ?? null,
            'status'             => 'waiting',
        ]);
    }

    /**
     * Hasta triyaj durumunu günceller.
     */
    public function updateStatus(EmergencyTriage $triage, string $status, ?int $doctorId = null): EmergencyTriage
    {
        $updateData = ['status' => $status];
        if ($doctorId) {
            $updateData['assigned_doctor_id'] = $doctorId;
        }

        $triage->update($updateData);
        return $triage;
    }
}
