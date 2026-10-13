<?php

namespace Tests\Feature\ArtificialIntelligence;

use App\Modules\Identity\Models\User;
use App\Modules\ArtificialIntelligence\Services\LabAnalysisAiService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LabAnalysisAiTest extends TestCase
{
    use RefreshDatabase;

    protected function makeDoctorUser(): User
    {
        return User::create([
            'name'      => 'Dr. Mehmet Öz',
            'email'     => 'mehmet_ai@hbys.test',
            'password'  => bcrypt('Test1234!'),
            'role'      => 'physician',
            'is_active' => true,
        ]);
    }

    public function test_doctor_can_access_ai_lab_analysis_portal(): void
    {
        $doctor = $this->makeDoctorUser();

        $response = $this->actingAs($doctor)->get(route('ai.lab_analysis.index'));

        $response->assertStatus(200);
        $response->assertSee('Yapay Zekâ Tıbbi Dosya & Lab Analiz Portalı');
    }

    public function test_ai_lab_analysis_service_generates_three_dimensional_report(): void
    {
        $service = app(LabAnalysisAiService::class);

        $result = $service->analyzePatientLabResults(1);

        $this->assertEquals('success', $result['status']);
        $this->assertGreaterThan(0, $result['scanned_labs_count']);
        $this->assertNotEmpty($result['current_diagnoses']);
        $this->assertNotEmpty($result['future_risks']);
        $this->assertArrayHasKey('medical_adjustments', $result['improvement_recommendations']);
        $this->assertArrayHasKey('lifestyle_and_nutrition', $result['improvement_recommendations']);
        $this->assertArrayHasKey('followup_schedule', $result['improvement_recommendations']);
    }

    public function test_ai_lab_analysis_endpoint_returns_json_response(): void
    {
        $doctor = $this->makeDoctorUser();

        $response = $this->actingAs($doctor)->postJson(route('ai.lab_analysis.analyze'), [
            'patient_id' => 1,
            'custom_labs' => [
                ['test_name' => 'HbA1c', 'value' => '8.5', 'unit' => '%', 'reference' => '4.0 - 6.0', 'date' => '2026-08-04']
            ]
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'analysis_id',
            'patient_info',
            'scanned_lab_results',
            'current_diagnoses',
            'future_risks',
            'improvement_recommendations'
        ]);
        $response->assertJson(['status' => 'success']);
    }

    public function test_export_summary_returns_formatted_text(): void
    {
        $doctor = $this->makeDoctorUser();

        $response = $this->actingAs($doctor)->postJson(route('ai.lab_analysis.export_summary'), [
            'patient_id' => 1
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['status', 'summary_text']);
        $this->assertStringContainsString('YAPAY ZEKÂ TIBBİ DOSYA & LAB ANALİZ ÖZET RAPORU', $response->json('summary_text'));
    }
}
