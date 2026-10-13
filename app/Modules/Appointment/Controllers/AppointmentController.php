<?php

namespace App\Modules\Appointment\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Appointment\Models\Appointment;
use App\Modules\Appointment\Services\AppointmentService;
use App\Modules\Patient\Models\Patient;
use App\Modules\Personnel\Models\Doctor;
use App\Modules\Organization\Models\Clinic;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    protected AppointmentService $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    /**
     * Randevu Listesi ve Filtreleme Ekranı
     */
    public function index(Request $request): View
    {
        $query = Appointment::with(['patient', 'doctor.clinic', 'clinic']);

        if ($search = $request->input('search')) {
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('national_id', 'like', "%{$search}%");
            });
        }

        if ($doctorId = $request->input('doctor_id')) {
            $query->where('doctor_id', $doctorId);
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($date = $request->input('date')) {
            $query->whereDate('appointment_date', $date);
        }

        $appointments = $query->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'asc')
            ->paginate(15);

        $doctors = Doctor::orderBy('name')->get();

        return view('modules.appointment.index', compact('appointments', 'doctors'));
    }

    /**
     * Yeni Randevu Oluşturma Sayfası
     */
    public function create(Request $request): View
    {
        $patients = Patient::orderBy('first_name')->get();
        $doctors  = Doctor::with('clinic')->orderBy('name')->get();
        $clinics  = Clinic::orderBy('name')->get();
        $selectedPatientId = $request->input('patient_id');

        return view('modules.appointment.create', compact('patients', 'doctors', 'clinics', 'selectedPatientId'));
    }

    /**
     * AJAX: Seçilen Doktor ve Tarihe göre müsait saat slotlarını döner.
     */
    public function getSlots(Request $request): JsonResponse
    {
        $request->validate([
            'doctor_id'        => 'required|integer',
            'appointment_date' => 'required|date',
        ]);

        $slots = $this->appointmentService->getDoctorSlots(
            $request->integer('doctor_id'),
            $request->string('appointment_date')
        );

        return response()->json(['slots' => $slots]);
    }

    /**
     * Yeni Randevu Kaydetme
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'patient_id'       => 'required|exists:patients,id',
            'doctor_id'        => 'required|exists:doctors,id',
            'clinic_id'        => 'nullable|exists:clinics,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|string',
            'notes'            => 'nullable|string|max:500',
        ]);

        $result = $this->appointmentService->createAppointment($validated);

        if (!$result['success']) {
            return back()->withInput()->withErrors(['appointment_time' => $result['message']]);
        }

        return redirect()->route('appointments.index')
            ->with('success', 'Randevu kaydı başarıyla oluşturuldu.');
    }

    /**
     * Randevu Durumunu Güncelleme (Tamamlandı / İptal / Gelmedi)
     */
    public function updateStatus(Request $request, Appointment $appointment): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:pending,completed,cancelled,no_show',
        ]);

        $appointment->update(['status' => $request->string('status')]);

        return redirect()->route('appointments.index')
            ->with('success', "Randevu durumu '{$appointment->status_label}' olarak güncellendi.");
    }

    /**
     * Randevu İptal / Silme
     */
    public function destroy(Appointment $appointment): RedirectResponse
    {
        $appointment->delete();

        return redirect()->route('appointments.index')
            ->with('success', 'Randevu kaydı silindi.');
    }
}
