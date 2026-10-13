<?php

namespace Tests\Feature\Organization;

use Tests\TestCase;
use App\Modules\Identity\Models\User;
use App\Modules\Organization\Models\Building;
use App\Modules\Organization\Models\Floor;
use App\Modules\Organization\Models\Clinic;
use App\Modules\Organization\Models\Poliklinik;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PoliklinikTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Clinic $clinic;

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
        $floor = Floor::create(['building_id' => $building->id, 'name' => '1. Kat']);
        $this->clinic = Clinic::create(['floor_id' => $floor->id, 'name' => 'Göz Kliniği']);
    }

    public function test_poliklinik_index_page_is_accessible()
    {
        $response = $this->actingAs($this->user)->get(route('organization.polikliniks.index'));
        $response->assertStatus(200);
        $response->assertSee('Poliklinikler');
    }

    public function test_can_create_poliklinik()
    {
        $data = [
            'clinic_id' => $this->clinic->id,
            'name'      => 'Göz Polikliniği 1',
        ];

        $response = $this->actingAs($this->user)->post(route('organization.polikliniks.store'), $data);

        $response->assertRedirect(route('organization.polikliniks.index'));
        $this->assertDatabaseHas('polikliniks', ['name' => 'Göz Polikliniği 1', 'clinic_id' => $this->clinic->id]);
    }

    public function test_poliklinik_creation_requires_clinic_and_name()
    {
        $response = $this->actingAs($this->user)->post(route('organization.polikliniks.store'), [
            'clinic_id' => '',
            'name'      => '',
        ]);

        $response->assertSessionHasErrors(['clinic_id', 'name']);
    }

    public function test_can_update_poliklinik()
    {
        $poliklinik = Poliklinik::create(['clinic_id' => $this->clinic->id, 'name' => 'Eski Poliklinik']);

        $response = $this->actingAs($this->user)->put(route('organization.polikliniks.update', $poliklinik), [
            'clinic_id' => $this->clinic->id,
            'name'      => 'Güncellenmiş Poliklinik',
        ]);

        $response->assertRedirect(route('organization.polikliniks.index'));
        $this->assertDatabaseHas('polikliniks', ['id' => $poliklinik->id, 'name' => 'Güncellenmiş Poliklinik']);
    }

    public function test_can_delete_poliklinik()
    {
        $poliklinik = Poliklinik::create(['clinic_id' => $this->clinic->id, 'name' => 'Silinecek Poliklinik']);

        $response = $this->actingAs($this->user)->delete(route('organization.polikliniks.destroy', $poliklinik));

        $response->assertRedirect(route('organization.polikliniks.index'));
        $this->assertSoftDeleted('polikliniks', ['id' => $poliklinik->id]);
    }
}
