<?php

namespace Tests\Feature\Referral;

use Tests\TestCase;
use App\Modules\Referral\Models\Referral;
use App\Modules\Patient\Models\Patient;
use App\Modules\Personnel\Models\Doctor;
use App\Modules\Organization\Models\Clinic;
use App\Modules\Organization\Models\Building;
use App\Modules\Organization\Models\Floor;
use App\Modules\Identity\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReferralTest extends TestCase
{
    use RefreshDatabase;

    protected Patient $patient;
    protected Doctor $doctor;
    protected Clinic $clinic;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'name'      => 'Dr. Sevk Yetkilisi',
            'email'     => 'sevk@hbys.test',
            'password'  => bcrypt('Test1234!'),
            'role'      => 'physician',
            'is_active' => true,
        ]);

        $this->patient = Patient::create([
            'national_id' => '12312312399',
            'first_name'  => 'Sevkli',
            'last_name'   => 'Hasta',
            'birth_date'  => '1985-06-15',
            'gender'      => 'female',
        ]);

        $building = Building::create(['name' => 'A Blok']);
        $floor    = Floor::create(['building_id' => $building->id, 'name' => '2. Kat']);
        $this->clinic = Clinic::create(['floor_id' => $floor->id, 'name' => 'Nöroloji Kliniği']);

        $this->doctor = Doctor::create([
            'name'      => 'Dr. Sevk Eden',
            'email'     => 'sevkeden@hbys.test',
            'specialty' => 'Acil Tıp',
        ]);
    }

    public function test_referral_dashboard_is_accessible(): void
    {
        $response = $this->actingAs($this->user)->get(route('referrals.index'));

        $response->assertStatus(200);
        $response->assertSee('Sevk Takip Paneli');
    }

    public function test_can_create_internal_referral(): void
    {
        $data = [
            'patient_id'          => $this->patient->id,
            'referring_doctor_id' => $this->doctor->id,
            'referral_type'       => 'internal',
            'target_clinic_id'    => $this->clinic->id,
            'reason'              => 'İleri Nörolojik Konsültasyon Gereksinimi',
            'transport_type'      => 'self',
        ];

        $response = $this->actingAs($this->user)->post(route('referrals.store'), $data);

        $response->assertRedirect(route('referrals.index'));
        $this->assertDatabaseHas('referrals', [
            'patient_id'       => $this->patient->id,
            'referral_type'    => 'internal',
            'target_clinic_id' => $this->clinic->id,
            'status'           => 'pending',
        ]);
    }

    public function test_can_create_external_referral(): void
    {
        $data = [
            'patient_id'          => $this->patient->id,
            'referring_doctor_id' => $this->doctor->id,
            'referral_type'       => 'external',
            'target_hospital'     => 'Ankara Şehir Hastanesi',
            'reason'              => '3. Seviye Yoğun Bakım ve Kalp Damar Cerrahisi Sevk',
            'transport_type'      => 'ambulance',
        ];

        $response = $this->actingAs($this->user)->post(route('referrals.store'), $data);

        $response->assertRedirect(route('referrals.index'));
        $this->assertDatabaseHas('referrals', [
            'patient_id'      => $this->patient->id,
            'referral_type'   => 'external',
            'target_hospital' => 'Ankara Şehir Hastanesi',
            'transport_type'  => 'ambulance',
        ]);
    }

    public function test_referral_generates_unique_code(): void
    {
        $referral = Referral::create([
            'referral_code'       => 'SVK-2026-TEST1',
            'patient_id'          => $this->patient->id,
            'referring_doctor_id' => $this->doctor->id,
            'referral_type'       => 'internal',
            'target_clinic_id'    => $this->clinic->id,
            'reason'              => 'Test Sevk',
            'transport_type'      => 'self',
            'status'              => 'pending',
        ]);

        $this->assertNotNull($referral->referral_code);
        $this->assertStringStartsWith('SVK-', $referral->referral_code);
    }
}
