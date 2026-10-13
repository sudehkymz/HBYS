<?php

namespace Tests\Feature\Organization;

use Tests\TestCase;
use App\Modules\Identity\Models\User;
use App\Modules\Organization\Models\Building;
use App\Modules\Organization\Models\Floor;
use App\Modules\Organization\Models\Clinic;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClinicTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Floor $floor;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::create([
            'name' => 'Test Admin',
            'email' => 'admin@hbys.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $building = Building::create(['name' => 'Test Binası']);
        $this->floor = Floor::create(['building_id' => $building->id, 'name' => '1. Kat']);
    }

    public function test_clinic_index_page_is_accessible()
    {
        $response = $this->actingAs($this->user)->get(route('organization.clinics.index'));
        $response->assertStatus(200);
        $response->assertSee('Klinikler');
    }

    public function test_can_create_clinic()
    {
        $data = [
            'floor_id' => $this->floor->id,
            'name'     => 'Kardiyoloji Kliniği',
        ];

        $response = $this->actingAs($this->user)->post(route('organization.clinics.store'), $data);

        $response->assertRedirect(route('organization.clinics.index'));
        $this->assertDatabaseHas('clinics', ['name' => 'Kardiyoloji Kliniği', 'floor_id' => $this->floor->id]);
    }

    public function test_clinic_creation_requires_floor_and_name()
    {
        $response = $this->actingAs($this->user)->post(route('organization.clinics.store'), [
            'floor_id' => '',
            'name'     => '',
        ]);

        $response->assertSessionHasErrors(['floor_id', 'name']);
    }

    public function test_can_update_clinic()
    {
        $clinic = Clinic::create(['floor_id' => $this->floor->id, 'name' => 'Dahiliye']);

        $response = $this->actingAs($this->user)->put(route('organization.clinics.update', $clinic), [
            'floor_id' => $this->floor->id,
            'name'     => 'Genel Dahiliye Kliniği',
        ]);

        $response->assertRedirect(route('organization.clinics.index'));
        $this->assertDatabaseHas('clinics', ['id' => $clinic->id, 'name' => 'Genel Dahiliye Kliniği']);
    }

    public function test_can_delete_clinic()
    {
        $clinic = Clinic::create(['floor_id' => $this->floor->id, 'name' => 'Silinecek Klinik']);

        $response = $this->actingAs($this->user)->delete(route('organization.clinics.destroy', $clinic));

        $response->assertRedirect(route('organization.clinics.index'));
        $this->assertSoftDeleted('clinics', ['id' => $clinic->id]);
    }
}
