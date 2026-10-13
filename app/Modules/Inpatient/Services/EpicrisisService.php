<?php

namespace App\Modules\Inpatient\Services;

class EpicrisisService
{
    /**
     * Generate structured epicrisis data.
     */
    public function generateData(array $dischargeData)
    {
        return [
            'document_no' => 'EPI-' . time() . '-' . rand(100, 999),
            'issue_date' => now()->format('d.m.Y H:i'),
            'patient_name' => $dischargeData['patient_name'] ?? 'Bilinmeyen Hasta',
            'national_id' => $dischargeData['national_id'] ?? '-',
            'age' => $dischargeData['age'] ?? 0,
            'gender' => $dischargeData['gender'] ?? '-',
            'admission_date' => $dischargeData['admission_date'] ?? '-',
            'discharge_date' => $dischargeData['discharge_date'] ?? '-',
            'admission_diagnosis' => $dischargeData['admission_diagnosis'] ?? '-',
            'discharge_diagnosis' => $dischargeData['discharge_diagnosis'] ?? '-',
            'procedures' => $dischargeData['procedures'] ?? '-',
            'surgeries' => $dischargeData['surgeries'] ?? 'Yok',
            'lab_summary' => $dischargeData['lab_summary'] ?? 'Yapılmadı',
            'radiology_summary' => $dischargeData['radiology_summary'] ?? 'Yapılmadı',
            'pathology_summary' => $dischargeData['pathology_summary'] ?? 'Yapılmadı',
            'active_medications' => $dischargeData['active_medications'] ?? 'Yok',
            'stopped_medications' => $dischargeData['stopped_medications'] ?? 'Yok',
            'discharge_medications' => $dischargeData['discharge_medications'] ?? 'Yok',
            'nutrition_recommendations' => $dischargeData['nutrition_recommendations'] ?? 'Standart diyet',
            'activity_recommendations' => $dischargeData['activity_recommendations'] ?? 'İstirahat önerildi',
            'wound_care' => $dischargeData['wound_care'] ?? 'Gerekmiyor',
            'follow_up_date' => $dischargeData['follow_up_date'] ?? '-',
            'follow_up_clinic' => $dischargeData['follow_up_clinic'] ?? '-',
            'prescription_code' => $dischargeData['prescription_code'] ?? 'MOCK-RX-' . rand(1000, 9999),
            'physician_name' => $dischargeData['physician_name'] ?? 'Dr. Kürşat Kıran',
            'discharge_status' => $dischargeData['discharge_status'] ?? 'Şifa'
        ];
    }
}