<?php

namespace Tests\Feature\Organization;

use Tests\TestCase;
use App\Modules\Identity\Models\User;
use App\Modules\Organization\Models\Building;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BuildingTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

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
    }

    public function test_building_index_page_is_accessible()
    {
        $response = $this->actingAs($this->user)->get(route('organization.buildings.index'));
        $response->assertStatus(200);
        $response->assertSee('Binalar');
    }

    public function test_can_create_building()
    {
        $data = [
            'name' => 'Merkez A Blok',
            'address' => 'Atatürk Cad. No: 123',
        ];

        $response = $this->actingAs($this->user)->post(route('organization.buildings.store'), $data);

        $response->assertRedirect(route('organization.buildings.index'));
        $this->assertDatabaseHas('buildings', ['name' => 'Merkez A Blok']);
    }

    public function test_building_creation_requires_name()
    {
        $response = $this->actingAs($this->user)->post(route('organization.buildings.store'), [
            'name' => '',
            'address' => 'Adres Var',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_can_update_building()
    {
        $building = Building::create(['name' => 'Eski Bina', 'address' => 'Eski Adres']);

        $response = $this->actingAs($this->user)->put(route('organization.buildings.update', $building), [
            'name' => 'Yeni Bina Adı',
            'address' => 'Yeni Adres',
        ]);

        $response->assertRedirect(route('organization.buildings.index'));
        $this->assertDatabaseHas('buildings', ['id' => $building->id, 'name' => 'Yeni Bina Adı']);
    }

    public function test_can_delete_building()
    {
        $building = Building::create(['name' => 'Silinecek Bina']);

        $response = $this->actingAs($this->user)->delete(route('organization.buildings.destroy', $building));

        $response->assertRedirect(route('organization.buildings.index'));
        $this->assertSoftDeleted('buildings', ['id' => $building->id]);
    }
}
