<?php

namespace Tests\Feature\Organization;

use Tests\TestCase;
use App\Modules\Identity\Models\User;
use App\Modules\Organization\Models\Building;
use App\Modules\Organization\Models\Floor;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FloorTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Building $building;

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

        $this->building = Building::create(['name' => 'Test Binası']);
    }

    public function test_floor_index_page_is_accessible()
    {
        $response = $this->actingAs($this->user)->get(route('organization.floors.index'));
        $response->assertStatus(200);
        $response->assertSee('Katlar');
    }

    public function test_can_create_floor()
    {
        $data = [
            'building_id' => $this->building->id,
            'name'        => '1. Kat',
        ];

        $response = $this->actingAs($this->user)->post(route('organization.floors.store'), $data);

        $response->assertRedirect(route('organization.floors.index'));
        $this->assertDatabaseHas('floors', ['name' => '1. Kat', 'building_id' => $this->building->id]);
    }

    public function test_floor_creation_requires_building_and_name()
    {
        $response = $this->actingAs($this->user)->post(route('organization.floors.store'), [
            'building_id' => '',
            'name'        => '',
        ]);

        $response->assertSessionHasErrors(['building_id', 'name']);
    }

    public function test_can_update_floor()
    {
        $floor = Floor::create(['building_id' => $this->building->id, 'name' => 'Zemin Kat']);

        $response = $this->actingAs($this->user)->put(route('organization.floors.update', $floor), [
            'building_id' => $this->building->id,
            'name'        => 'Giriş Katı',
        ]);

        $response->assertRedirect(route('organization.floors.index'));
        $this->assertDatabaseHas('floors', ['id' => $floor->id, 'name' => 'Giriş Katı']);
    }

    public function test_can_delete_floor()
    {
        $floor = Floor::create(['building_id' => $this->building->id, 'name' => 'Silinecek Kat']);

        $response = $this->actingAs($this->user)->delete(route('organization.floors.destroy', $floor));

        $response->assertRedirect(route('organization.floors.index'));
        $this->assertSoftDeleted('floors', ['id' => $floor->id]);
    }
}
