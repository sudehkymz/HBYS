<?php

namespace Tests\Feature\Outpatient;

use Tests\TestCase;
use App\Modules\Outpatient\Models\OutpatientExamination;
use App\Modules\Patient\Models\Patient;
use App\Modules\Personnel\Models\Doctor;
use App\Modules\Identity\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OutpatientTest extends TestCase
{
    use RefreshDatabase;

    protected Patient $patient;
    protected Doctor $doctor;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'name'      => 'Dr. Poliklinik Hekim',
            'email'     => 'doktor@hbys.test',
            'password'  => bcrypt('Test1234!'),
            'role'      => 'physician',
            'is_active' => true,
        ]);

        $this->patient = Patient::create([
            'national_id' => '99988877766',
            'first_name'  => 'Mustafa',
            'last_name'   => 'Yılmaz',
            'birth_date'  => '1988-04-12',
            'gender'      => 'male',
        ]);

        $this->doctor = Doctor::create([
            'name'      => 'Dr. Poliklinik Hekim',
            'email'     => 'doktor@hbys.test',
            'specialty' => 'Dahiliye',
        ]);
    }

    public function test_outpatient_dashboard_is_accessible(): void
    {
        $response = $this->actingAs($this->user)->get(route('outpatient.index'));

        $response->assertStatus(200);
        $response->assertSee('Poliklinik Akışı');
    }

    public function test_can_start_and_complete_examination(): void
    {
        // 1. Muayene Başlatma
        $startResponse = $this->actingAs($this->user)->post(route('outpatient.start'), [
            'patient_id' => $this->patient->id,
            'doctor_id'  => $this->doctor->id,
        ]);

        $startResponse->assertRedirect(route('outpatient.examine', $this->patient));
        $this->assertDatabaseHas('outpatient_examinations', [
            'patient_id' => $this->patient->id,
            'status'     => 'in_progress',
        ]);

        $examination = OutpatientExamination::where('patient_id', $this->patient->id)->first();

        // 2. Muayeneyi Tamamlama
        $completeResponse = $this->actingAs($this->user)->post(route('outpatient.complete', $examination), [
            'chief_complaint'      => 'Şiddetli baş ağrısı ve halsizlik',
            'physical_examination' => 'Genel durum iyi, tansiyon 130/80',
            'icd10_code'           => 'R51 - Baş Ağrısı',
            'treatment_plan'       => 'Bol sıvı tüketimi ve dinlenme önerildi.',
            'status'               => 'completed',
        ]);

        $completeResponse->assertRedirect(route('outpatient.index'));
        $this->assertDatabaseHas('outpatient_examinations', [
            'id'         => $examination->id,
            'icd10_code' => 'R51 - Baş Ağrısı',
            'status'     => 'completed',
        ]);
    }
}
