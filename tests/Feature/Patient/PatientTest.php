<?php

namespace Tests\Feature\Patient;

use App\Modules\Patient\Models\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PatientTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_patients(): void
    {
        $response = $this->get(route('patients.index'));
        $response->assertStatus(200);
    }

    public function test_can_search_patients_by_national_id_or_name(): void
    {
        $patient = Patient::create([
            'national_id' => '11122233344',
            'first_name' => 'Caner',
            'last_name' => 'Öztürk',
            'birth_date' => '1990-01-01',
            'gender' => 'male',
        ]);

        $response = $this->get(route('patients.index', ['search' => '11122233344']));
        $response->assertStatus(200);
        $response->assertSee('Caner');
    }

    public function test_can_create_patient(): void
    {
        $data = [
            'national_id' => '99988877766',
            'first_name' => 'Elif',
            'last_name' => 'Yıldız',
            'birth_date' => '1995-06-15',
            'gender' => 'female',
            'phone' => '05559998877',
            'blood_type' => '0 Rh+',
        ];

        $response = $this->post(route('patients.store'), $data);
        $this->assertDatabaseHas('patients', ['national_id' => '99988877766']);
        
        $patient = Patient::where('national_id', '99988877766')->first();
        $response->assertRedirect();
    }

    public function test_can_view_patient_card(): void
    {
        $patient = Patient::create([
            'national_id' => '55566677788',
            'first_name' => 'Murat',
            'last_name' => 'Şen',
            'birth_date' => '1988-12-10',
            'gender' => 'male',
        ]);

        $response = $this->get(route('patients.show', $patient));
        $response->assertStatus(200);
        $response->assertSee('Murat Şen');
        $response->assertSee('55566677788');
    }

    public function test_can_update_patient(): void
    {
        $patient = Patient::create([
            'national_id' => '33344455566',
            'first_name' => 'Eski',
            'last_name' => 'İsim',
            'birth_date' => '1990-01-01',
            'gender' => 'male',
        ]);

        $response = $this->put(route('patients.update', $patient), [
            'national_id' => '33344455566',
            'first_name' => 'Yeni',
            'last_name' => 'İsim',
            'birth_date' => '1990-01-01',
            'gender' => 'male',
            'phone' => '05001234567',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('patients', ['first_name' => 'Yeni', 'phone' => '05001234567']);
    }

    public function test_can_delete_patient(): void
    {
        $patient = Patient::create([
            'national_id' => '77788899900',
            'first_name'  => 'Silinecek',
            'last_name'   => 'Hasta',
            'birth_date'  => '1990-01-01',
            'gender'      => 'female',
        ]);

        $response = $this->delete(route('patients.destroy', $patient));
        $response->assertRedirect(route('patients.index'));
        $this->assertSoftDeleted('patients', ['id' => $patient->id]);
    }

    // ───── PR #2 / PR #3 Entegrasyon Testleri ──────────────────────

    public function test_patient_show_contains_prescription_action_button(): void
    {
        $patient = Patient::create([
            'national_id' => '44455566677',
            'first_name'  => 'Ahmet',
            'last_name'   => 'Kaya',
            'birth_date'  => '1985-03-20',
            'gender'      => 'male',
        ]);

        $response = $this->get(route('patients.show', $patient));

        $response->assertStatus(200);
        // E-Reçete butonu hasta profil sayfasında olmalı
        $response->assertSee('E-Reçete');
    }

    public function test_patient_show_contains_inpatient_admission_link(): void
    {
        $patient = Patient::create([
            'national_id' => '55566677788',
            'first_name'  => 'Fatma',
            'last_name'   => 'Demir',
            'birth_date'  => '1978-07-12',
            'gender'      => 'female',
        ]);

        $response = $this->get(route('patients.show', $patient));

        $response->assertStatus(200);
        // Yatış butonu hasta profil sayfasında olmalı
        $response->assertSee('Yatış İşlemi');
    }

    public function test_patient_show_contains_ai_analysis_link(): void
    {
        $patient = Patient::create([
            'national_id' => '66677788899',
            'first_name'  => 'Mehmet',
            'last_name'   => 'Arslan',
            'birth_date'  => '1992-11-05',
            'gender'      => 'male',
        ]);

        $response = $this->get(route('patients.show', $patient));

        $response->assertStatus(200);
        // AI Analiz butonu hasta profil sayfasında olmalı
        $response->assertSee('AI ile Analiz');
    }

    public function test_patient_has_prescriptions_relationship(): void
    {
        $patient = Patient::create([
            'national_id' => '77788899911',
            'first_name'  => 'Zeynep',
            'last_name'   => 'Yıldız',
            'birth_date'  => '2000-02-14',
            'gender'      => 'female',
        ]);

        // İlişki metodu çağrılabilmeli (0 reçete de olsa hata vermemeli)
        $count = $patient->prescriptions()->count();
        $this->assertIsInt($count);
        $this->assertGreaterThanOrEqual(0, $count);
    }
}
