<?php

namespace Tests\Feature\Personnel;

use App\Modules\Personnel\Models\Doctor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DoctorTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_doctors(): void
    {
        $response = $this->get(route('personnel.doctors.index'));
        $response->assertStatus(200);
    }

    public function test_can_create_doctor(): void
    {
        $data = [
            'name' => 'Dr. Ahmet Yıldız',
            'email' => 'ahmet.yildiz@hbys.com',
            'phone' => '05441112233',
            'specialty' => 'Göz Hastalıkları',
        ];

        $response = $this->post(route('personnel.doctors.store'), $data);
        $response->assertRedirect(route('personnel.doctors.index'));
        $this->assertDatabaseHas('doctors', ['email' => 'ahmet.yildiz@hbys.com']);
    }

    public function test_can_update_doctor(): void
    {
        $doctor = Doctor::create([
            'name' => 'Dr. Caner',
            'email' => 'caner@hbys.com',
            'specialty' => 'Üroloji',
        ]);

        $response = $this->put(route('personnel.doctors.update', $doctor), [
            'name' => 'Dr. Caner Gündüz',
            'email' => 'caner@hbys.com',
            'specialty' => 'Pediatrik Üroloji',
        ]);

        $response->assertRedirect(route('personnel.doctors.index'));
        $this->assertDatabaseHas('doctors', ['name' => 'Dr. Caner Gündüz', 'specialty' => 'Pediatrik Üroloji']);
    }

    public function test_can_delete_doctor(): void
    {
        $doctor = Doctor::create([
            'name' => 'Dr. Silinecek',
            'email' => 'drsilinecek@hbys.com',
            'specialty' => 'Cildiye',
        ]);

        $response = $this->delete(route('personnel.doctors.destroy', $doctor));
        $response->assertRedirect(route('personnel.doctors.index'));
        $this->assertDatabaseMissing('doctors', ['id' => $doctor->id]);
    }
}
