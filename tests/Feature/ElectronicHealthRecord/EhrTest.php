<?php

namespace Tests\Feature\ElectronicHealthRecord;

use Tests\TestCase;
use App\Modules\Patient\Models\Patient;
use App\Modules\Identity\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EhrTest extends TestCase
{
    use RefreshDatabase;

    protected Patient $patient;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'name'      => 'Dr. Test Hekim',
            'email'     => 'doktor@hbys.test',
            'password'  => bcrypt('Test1234!'),
            'role'      => 'physician',
            'is_active' => true,
        ]);

        $this->patient = Patient::create([
            'national_id' => '12345678901',
            'first_name'  => 'Ahmet',
            'last_name'   => 'Kaya',
            'birth_date'  => '1990-01-01',
            'gender'      => 'male',
            'blood_type'  => 'A Rh+',
        ]);
    }

    public function test_ehr_dashboard_page_is_accessible(): void
    {
        $response = $this->actingAs($this->user)->get(route('ehr.show', $this->patient));

        $response->assertStatus(200);
        $response->assertSee('Elektronik Hasta Dosyası (EHR)');
        $response->assertSee('Ahmet Kaya');
        $response->assertSee('12345678901');
    }

    public function test_can_add_vital_signs_to_patient_ehr(): void
    {
        $vitalsData = [
            'blood_pressure' => '130/85',
            'pulse'          => '80',
            'fever'          => '36.8',
            'spo2'           => '99',
            'respiration'    => '18',
        ];

        $response = $this->actingAs($this->user)->post(route('ehr.vitals.store', $this->patient), $vitalsData);

        $response->assertRedirect(route('ehr.show', $this->patient));
        $response->assertSessionHas('success');

        // Dosya açıldığında yeni vitaller ekranda görünmeli
        $showResponse = $this->actingAs($this->user)->get(route('ehr.show', $this->patient));
        $showResponse->assertSee('130/85');
        $showResponse->assertSee('80 /dk');
        $showResponse->assertSee('36.8 °C');
    }

    public function test_ehr_print_summary_view_is_accessible(): void
    {
        $response = $this->actingAs($this->user)->get(route('ehr.print', $this->patient));

        $response->assertStatus(200);
        $response->assertSee('ELEKTRONİK HASTA TIBBİ ÖZET RAPORU');
        $response->assertSee('Ahmet Kaya');
    }
}
