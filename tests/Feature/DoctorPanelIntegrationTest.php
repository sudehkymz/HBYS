<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Modules\Identity\Models\User;
use PHPUnit\Framework\Attributes\Test;

class DoctorPanelIntegrationTest extends TestCase
{
    #[Test]
    public function lab_and_pathology_results_populate_on_doctor_panel()
    {
        $this->artisan('migrate');

        $doctor = new User([
            'id' => 1,
            'name' => 'Dr. Test Hekim',
            'email' => 'doktor@hbys.com',
            'role' => 'admin'
        ]);

        $this->actingAs($doctor);

        // 1. Laboratuvar & Patoloji modül sayfalarını ziyaret ederek varsayılan istemlerin yüklenmesini sağla
        $this->get(route('diagnostics.index', ['admission_id' => 501]))->assertStatus(200);
        $this->get(route('pathology.index', ['admission_id' => 501]))->assertStatus(200);

        // 2. Laboratuvar modülünden yeni bir lab sonucu gir
        $this->post(route('diagnostics.result'), [
            'admission_id' => 501,
            'order_id' => 1001,
            'result_summary' => 'TEST_LAB_GLIKOZ: 110 mg/dL (Yüksek), KREATİNİN: 0.8 mg/dL',
            'technician' => 'Uzm. Lab. Aslı Yıldız'
        ])->assertRedirect();

        // 3. Patoloji modülünden yeni bir patoloji sonucu gir
        $this->post(route('pathology.result'), [
            'admission_id' => 501,
            'order_id' => 2001,
            'result_summary' => 'TEST_PATOLOJİ_BİYOPSİ: Kesitlerde kronik aktif gastrit ve H. Pylori pozitifliği saptandı.',
            'pathologist' => 'Uzm. Dr. Melis Kaya'
        ])->assertRedirect();

        // 4. Doktor Paneli (Chief Physician Dashboard) Sayfasını Hasta #1 için Yükle
        $response = $this->get(route('medical_report.chief_physician', ['patient_id' => 1]));

        $response->assertStatus(200);

        // 5. Doğrula: Lab sonucu Doktor Paneline düştü mü?
        $response->assertSee('TEST_LAB_GLIKOZ: 110 mg/dL (Yüksek)');

        // 6. Doğrula: Patoloji sonucu Doktor Paneli Raporlar sekmesine düştü mü?
        $response->assertSee('TEST_PATOLOJİ_BİYOPSİ: Kesitlerde kronik aktif gastrit');
    }

    #[Test]
    public function surgery_reports_populate_on_doctor_panel()
    {
        $this->artisan('migrate');

        $doctor = new User([
            'id' => 1,
            'name' => 'Dr. Test Hekim',
            'email' => 'doktor@hbys.com',
            'role' => 'admin'
        ]);

        $this->actingAs($doctor);

        // 1. Ameliyathane sayfasını ziyaret et
        $this->get(route('surgery.index', ['admission_id' => 501]))->assertStatus(200);

        // 2. Yeni ameliyat raporu gir
        $this->post(route('surgery.report'), [
            'admission_id' => 501,
            'findings' => 'TEST_AMELİYAT_BULGULARI: Safra kesesi inflamasyonlu, taşlar eksize edildi.',
            'complications' => 'Komplikasyon izlenmedi.',
            'postop_care' => '2 saat yakın vital takip.'
        ])->assertRedirect();

        // 3. Doktor Paneli Sayfasını Hasta #1 için Yükle
        $response = $this->get(route('medical_report.chief_physician', ['patient_id' => 1]));

        $response->assertStatus(200);

        // 4. Doğrula: Ameliyat raporu Doktor Paneli Raporlar sekmesine düştü mü?
        $response->assertSee('TEST_AMELİYAT_BULGULARI: Safra kesesi inflamasyonlu');
    }
}
