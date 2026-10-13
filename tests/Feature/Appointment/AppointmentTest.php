<?php

namespace Tests\Feature\Appointment;

use Tests\TestCase;
use App\Modules\Appointment\Models\Appointment;
use App\Modules\Patient\Models\Patient;
use App\Modules\Personnel\Models\Doctor;
use App\Modules\Identity\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AppointmentTest extends TestCase
{
    use RefreshDatabase;

    protected Patient $patient;
    protected Doctor $doctor;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'name'      => 'Test Admin',
            'email'     => 'admin@hbys.test',
            'password'  => bcrypt('Test1234!'),
            'role'      => 'admin',
            'is_active' => true,
        ]);

        $this->patient = Patient::create([
            'national_id' => '11122233344',
            'first_name'  => 'Caner',
            'last_name'   => 'Yılmaz',
            'birth_date'  => '1992-05-10',
            'gender'      => 'male',
        ]);

        $this->doctor = Doctor::create([
            'name'      => 'Dr. Ahmet Tan',
            'email'     => 'ahmet.tan@hbys.test',
            'specialty' => 'Kardiyoloji',
        ]);
    }

    public function test_can_list_appointments(): void
    {
        $response = $this->actingAs($this->user)->get(route('appointments.index'));

        $response->assertStatus(200);
        $response->assertSee('Randevu ve Poliklinik Zaman Çizelgesi');
    }

    public function test_can_create_appointment(): void
    {
        $date = date('Y-m-d', strtotime('+1 day'));
        $data = [
            'patient_id'       => $this->patient->id,
            'doctor_id'        => $this->doctor->id,
            'appointment_date' => $date,
            'appointment_time' => '10:15',
            'notes'            => 'Rutin muayene kontrolü',
        ];

        $response = $this->actingAs($this->user)->post(route('appointments.store'), $data);

        $response->assertRedirect(route('appointments.index'));
        $this->assertDatabaseHas('appointments', [
            'patient_id'       => $this->patient->id,
            'doctor_id'        => $this->doctor->id,
            'appointment_time' => '10:15',
            'status'           => 'pending',
        ]);
    }

    public function test_cannot_create_duplicate_slot_appointment(): void
    {
        $date = date('Y-m-d', strtotime('+1 day'));

        Appointment::create([
            'patient_id'       => $this->patient->id,
            'doctor_id'        => $this->doctor->id,
            'appointment_date' => $date,
            'appointment_time' => '11:00',
            'status'           => 'pending',
        ]);

        // Aynı doktor ve aynı zaman dilimi için tekrar randevu almaya çalış
        $data = [
            'patient_id'       => $this->patient->id,
            'doctor_id'        => $this->doctor->id,
            'appointment_date' => $date,
            'appointment_time' => '11:00',
        ];

        $response = $this->actingAs($this->user)->post(route('appointments.store'), $data);

        $response->assertSessionHasErrors('appointment_time');
    }

    public function test_can_update_appointment_status(): void
    {
        $appointment = Appointment::create([
            'patient_id'       => $this->patient->id,
            'doctor_id'        => $this->doctor->id,
            'appointment_date' => date('Y-m-d'),
            'appointment_time' => '14:00',
            'status'           => 'pending',
        ]);

        $response = $this->actingAs($this->user)->post(route('appointments.status', $appointment), [
            'status' => 'completed',
        ]);

        $response->assertRedirect(route('appointments.index'));
        $this->assertDatabaseHas('appointments', [
            'id'     => $appointment->id,
            'status' => 'completed',
        ]);
    }

    public function test_can_fetch_doctor_slots_via_ajax(): void
    {
        $date = date('Y-m-d', strtotime('+2 days'));

        $response = $this->actingAs($this->user)->getJson(route('appointments.slots', [
            'doctor_id'        => $this->doctor->id,
            'appointment_date' => $date,
        ]));

        $response->assertStatus(200);
        $response->assertJsonStructure(['slots']);
        $this->assertNotEmpty($response->json('slots'));
    }
}
