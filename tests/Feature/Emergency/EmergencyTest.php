<?php

namespace Tests\Feature\Emergency;

use Tests\TestCase;
use App\Modules\Emergency\Models\EmergencyTriage;
use App\Modules\Patient\Models\Patient;
use App\Modules\Personnel\Models\Doctor;
use App\Modules\Identity\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmergencyTest extends TestCase
{
    use RefreshDatabase;

    protected Patient $patientRed;
    protected Patient $patientGreen;
    protected Doctor $doctor;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'name'      => 'Dr. Acil Hekim',
            'email'     => 'acil@hbys.test',
            'password'  => bcrypt('Test1234!'),
            'role'      => 'physician',
            'is_active' => true,
        ]);

        $this->patientRed = Patient::create([
            'national_id' => '11111111111',
            'first_name'  => 'Kritik',
            'last_name'   => 'Hasta',
            'birth_date'  => '1970-01-01',
            'gender'      => 'male',
        ]);

        $this->patientGreen = Patient::create([
            'national_id' => '22222222222',
            'first_name'  => 'Hafif',
            'last_name'   => 'Hasta',
            'birth_date'  => '1995-05-05',
            'gender'      => 'female',
        ]);

        $this->doctor = Doctor::create([
            'name'      => 'Dr. Acil Hekim',
            'email'     => 'acil@hbys.test',
            'specialty' => 'Acil Tıp',
        ]);
    }

    public function test_emergency_dashboard_is_accessible(): void
    {
        $response = $this->actingAs($this->user)->get(route('emergency.index'));

        $response->assertStatus(200);
        $response->assertSee('Acil Servis');
    }

    public function test_can_create_emergency_triage(): void
    {
        $data = [
            'patient_id'         => $this->patientRed->id,
            'triage_category'    => 'red',
            'chief_complaint'    => 'Akut göğüs ağrısı ve nefes darlığı',
            'blood_pressure'     => '160/100',
            'pulse'              => 110,
            'fever'              => 37.2,
            'spo2'               => 92,
            'assigned_doctor_id' => $this->doctor->id,
        ];

        $response = $this->actingAs($this->user)->post(route('emergency.store'), $data);

        $response->assertRedirect(route('emergency.index'));
        $this->assertDatabaseHas('emergency_triages', [
            'patient_id'      => $this->patientRed->id,
            'triage_category' => 'red',
            'status'          => 'waiting',
        ]);
    }

    public function test_emergency_prioritizes_red_triage_patients(): void
    {
        // Önce Yeşil Kodlu Hastayı Kaydet
        EmergencyTriage::create([
            'patient_id'      => $this->patientGreen->id,
            'triage_category' => 'green',
            'chief_complaint' => 'Hafif boğaz ağrısı',
            'status'          => 'waiting',
        ]);

        // Sonra Kırmızı Kodlu Hastayı Kaydet
        EmergencyTriage::create([
            'patient_id'      => $this->patientRed->id,
            'triage_category' => 'red',
            'chief_complaint' => 'Travma / Şok',
            'status'          => 'waiting',
        ]);

        $response = $this->actingAs($this->user)->get(route('emergency.index'));

        $response->assertStatus(200);
        // Kırmızı kodlu hastanın ismi yeşil kodludan önce görülmeli
        $content = $response->getContent();
        $redPos = strpos($content, 'Kritik');
        $greenPos = strpos($content, 'Hafif');

        $this->assertTrue($redPos !== false && $greenPos !== false);
        $this->assertTrue($redPos < $greenPos, 'Kırmızı kodlu hasta paneli öncelikle listelenmelidir.');
    }
}
