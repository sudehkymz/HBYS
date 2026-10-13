<?php

namespace App\Modules\Outpatient\Services;

use App\Modules\Outpatient\Models\OutpatientExamination;
use App\Modules\Appointment\Models\Appointment;
use App\Modules\Patient\Models\Patient;

class OutpatientService
{
    /**
     * Günlük poliklinik muayene sırasını ve aktif muayenedeki hastaları getirir.
     */
    public function getQueueData(?int $doctorId = null): array
    {
        $today = date('Y-m-d');

        // 1. Bekleyen / Bugünkü Randevular (Sıra Bekleyenler)
        $appointmentQuery = Appointment::with(['patient', 'doctor'])
            ->whereDate('appointment_date', $today)
            ->where('status', 'pending');

        if ($doctorId) {
            $appointmentQuery->where('doctor_id', $doctorId);
        }

        $waitingAppointments = $appointmentQuery->orderBy('appointment_time', 'asc')->get();

        // 2. Aktif ve Tamamlanan Poliklinik Muayeneleri
        $examinationQuery = OutpatientExamination::with(['patient', 'doctor'])
            ->whereDate('created_at', $today);

        if ($doctorId) {
            $examinationQuery->where('doctor_id', $doctorId);
        }

        $examinations = $examinationQuery->orderBy('created_at', 'desc')->get();

        return [
            'waiting_appointments' => $waitingAppointments,
            'examinations'         => $examinations,
            'stats'                => [
                'waiting_count'   => $waitingAppointments->count(),
                'active_count'    => $examinations->where('status', 'in_progress')->count(),
                'completed_count' => $examinations->where('status', 'completed')->count(),
            ],
        ];
    }

    /**
     * Hasta için yeni Poliklinik Muayenesi başlatır.
     */
    public function startExamination(Patient $patient, ?int $doctorId = null, ?int $appointmentId = null): OutpatientExamination
    {
        // Eğer varsa mevcut randevu durumunu 'completed' yap
        if ($appointmentId) {
            $appointment = Appointment::find($appointmentId);
            if ($appointment) {
                $appointment->update(['status' => 'completed']);
            }
        }

        return OutpatientExamination::create([
            'patient_id'     => $patient->id,
            'doctor_id'      => $doctorId ?? 1,
            'appointment_id' => $appointmentId,
            'status'         => 'in_progress',
        ]);
    }

    /**
     * Muayeneyi tanı ve bulgularla tamamlar.
     */
    public function completeExamination(OutpatientExamination $examination, array $data): OutpatientExamination
    {
        $examination->update([
            'chief_complaint'      => $data['chief_complaint'] ?? $examination->chief_complaint,
            'physical_examination' => $data['physical_examination'] ?? $examination->physical_examination,
            'icd10_code'           => $data['icd10_code'] ?? $examination->icd10_code,
            'treatment_plan'       => $data['treatment_plan'] ?? $examination->treatment_plan,
            'status'               => $data['status'] ?? 'completed',
        ]);

        return $examination;
    }
}
