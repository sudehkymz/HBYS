<?php

namespace Tests\Feature;

use App\Modules\Identity\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function makeAdmin(): User
    {
        return User::create([
            'name'      => 'Test Admin',
            'email'     => 'admin_test@hbys.test',
            'password'  => bcrypt('Test1234!'),
            'role'      => 'admin',
            'is_active' => true,
        ]);
    }

    public function test_admin_can_access_pharmacy_panel(): void
    {
        $admin = $this->makeAdmin();

        $response = $this->actingAs($admin)->get(route('pharmacy.index'));

        $response->assertStatus(200);
        $response->assertSee('Eczane');
    }

    public function test_admin_can_access_prescription_panel(): void
    {
        $admin = $this->makeAdmin();

        $response = $this->actingAs($admin)->get(route('prescription.index'));

        $response->assertStatus(200);
        $response->assertSee('E-Reçete');
    }

    public function test_admin_can_access_chief_physician_doctor_panel(): void
    {
        $admin = $this->makeAdmin();

        $response = $this->actingAs($admin)->get(route('medical_report.chief_physician'));

        $response->assertStatus(200);
        $response->assertSee('Doktor');
    }
}
