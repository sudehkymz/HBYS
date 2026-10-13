<?php

namespace Tests\Feature\Personnel;

use App\Modules\Organization\Models\Clinic;
use App\Modules\Personnel\Models\Personnel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PersonnelTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_personnel(): void
    {
        $response = $this->get(route('personnel.personnels.index'));
        $response->assertStatus(200);
    }

    public function test_can_create_personnel(): void
    {
        $data = [
            'name' => 'Fatma Şahin',
            'email' => 'fatma.sahin@hbys.com',
            'phone' => '05001112233',
            'role' => 'Hemşire',
        ];

        $response = $this->post(route('personnel.personnels.store'), $data);
        $response->assertRedirect(route('personnel.personnels.index'));
        $this->assertDatabaseHas('personnel', ['email' => 'fatma.sahin@hbys.com']);
    }

    public function test_can_update_personnel(): void
    {
        $personnel = Personnel::create([
            'name' => 'Eski İsim',
            'email' => 'eski@hbys.com',
            'role' => 'Danışman',
        ]);

        $response = $this->put(route('personnel.personnels.update', $personnel), [
            'name' => 'Yeni İsim',
            'email' => 'eski@hbys.com',
            'role' => 'Başdanışman',
        ]);

        $response->assertRedirect(route('personnel.personnels.index'));
        $this->assertDatabaseHas('personnel', ['name' => 'Yeni İsim', 'role' => 'Başdanışman']);
    }

    public function test_can_delete_personnel(): void
    {
        $personnel = Personnel::create([
            'name'  => 'Silinecek Personel',
            'email' => 'silinecek@hbys.com',
        ]);

        $response = $this->delete(route('personnel.personnels.destroy', $personnel));
        $response->assertRedirect(route('personnel.personnels.index'));
        $this->assertDatabaseMissing('personnel', ['id' => $personnel->id]);
    }

    // ───── PR Entegrasyon Testi: Doctor ↔ Clinic ↔ Organization ───────

    public function test_doctor_has_clinic_relation(): void
    {
        $building = \App\Modules\Organization\Models\Building::create(['name' => 'Test Bina']);
        $floor    = \App\Modules\Organization\Models\Floor::create(['building_id' => $building->id, 'name' => '1. Kat']);
        $clinic   = Clinic::create(['floor_id' => $floor->id, 'name' => 'Kardiyoloji']);

        $doctor = \App\Modules\Personnel\Models\Doctor::create([
            'name'      => 'Dr. Test',
            'email'     => 'drtest@hbys.test',
            'specialty' => 'Kardiyoloji',
            'clinic_id' => $clinic->id,
        ]);

        // Doctor clinic ilişkisi çalışmalı
        $this->assertNotNull($doctor->clinic);
        $this->assertEquals('Kardiyoloji', $doctor->clinic->name);

        // Clinic doctors ilişkisi çalışmalı (PR #2 entegrasyon)
        $clinicDoctors = $clinic->doctors;
        $this->assertCount(1, $clinicDoctors);
        $this->assertEquals('Dr. Test', $clinicDoctors->first()->name);
    }
}
