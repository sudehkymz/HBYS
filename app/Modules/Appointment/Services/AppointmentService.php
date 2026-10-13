<?php

namespace App\Modules\Appointment\Services;

use App\Modules\Appointment\Models\Appointment;
use App\Modules\Personnel\Models\Doctor;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class AppointmentService
{
    /**
     * Mesai saatlerine (09:00 - 16:30 arası 15'er dakika) göre doktorun dolu ve boş zaman dilimlerini üretir.
     */
    public function getDoctorSlots(int $doctorId, string $date): array
    {
        $startTime = Carbon::createFromFormat('Y-m-d H:i', "$date 09:00");
        $endTime   = Carbon::createFromFormat('Y-m-d H:i', "$date 16:30");

        // Doktora ait o tarihteki mevcut randevuları çek
        $existingAppointments = Appointment::where('doctor_id', $doctorId)
            ->whereDate('appointment_date', $date)
            ->whereIn('status', ['pending', 'completed'])
            ->pluck('appointment_time')
            ->toArray();

        $slots = [];
        $current = $startTime->copy();

        while ($current->lt($endTime)) {
            // Öğle molasını (12:00 - 13:00) pas geç
            if ($current->hour == 12) {
                $current->addMinutes(15);
                continue;
            }

            $timeStr = $current->format('H:i');
            $isBooked = in_array($timeStr, $existingAppointments);

            $slots[] = [
                'time'      => $timeStr,
                'is_booked' => $isBooked,
                'label'     => $timeStr . ($isBooked ? ' (Dolu)' : ' (Müsait)'),
            ];

            $current->addMinutes(15);
        }

        return $slots;
    }

    /**
     * Müsaitlik kontrolü yaparak randevuyu kaydeder.
     */
    public function createAppointment(array $data): array
    {
        $existing = Appointment::where('doctor_id', $data['doctor_id'])
            ->whereDate('appointment_date', $data['appointment_date'])
            ->where('appointment_time', $data['appointment_time'])
            ->whereIn('status', ['pending', 'completed'])
            ->first();

        if ($existing) {
            return [
                'success' => false,
                'message' => "Seçilen tarih ({$data['appointment_date']}) ve saatte ({$data['appointment_time']}) doktorun başka bir randevusu bulunmaktadır.",
            ];
        }

        $appointment = Appointment::create([
            'patient_id'       => $data['patient_id'],
            'doctor_id'        => $data['doctor_id'],
            'clinic_id'        => $data['clinic_id'] ?? null,
            'appointment_date' => $data['appointment_date'],
            'appointment_time' => $data['appointment_time'],
            'status'           => 'pending',
            'notes'            => $data['notes'] ?? null,
        ]);

        return [
            'success'     => true,
            'appointment' => $appointment,
            'message'     => 'Randevu kaydı başarıyla oluşturuldu.',
        ];
    }
}
