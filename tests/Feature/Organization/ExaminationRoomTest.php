<?php

namespace Tests\Feature\Organization;

use Tests\TestCase;
use App\Modules\Identity\Models\User;
use App\Modules\Organization\Models\Building;
use App\Modules\Organization\Models\Floor;
use App\Modules\Organization\Models\Clinic;
use App\Modules\Organization\Models\Poliklinik;
use App\Modules\Organization\Models\ExaminationRoom;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExaminationRoomTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Poliklinik $poliklinik;

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
        $clinic = Clinic::create(['floor_id' => $floor->id, 'name' => 'Kardiyoloji Kliniği']);
        $this->poliklinik = Poliklinik::create(['clinic_id' => $clinic->id, 'name' => 'EKG Polikliniği']);
    }

    public function test_examination_room_index_page_is_accessible()
    {
        $response = $this->actingAs($this->user)->get(route('organization.examination-rooms.index'));
        $response->assertStatus(200);
        $response->assertSee('Muayene Odaları');
    }

    public function test_can_create_examination_room()
    {
        $data = [
            'poliklinik_id' => $this->poliklinik->id,
            'name'          => 'Oda 101',
            'capacity'      => 2,
        ];

        $response = $this->actingAs($this->user)->post(route('organization.examination-rooms.store'), $data);

        $response->assertRedirect(route('organization.examination-rooms.index'));
        $this->assertDatabaseHas('examination_rooms', ['name' => 'Oda 101', 'poliklinik_id' => $this->poliklinik->id, 'capacity' => 2]);
    }

    public function test_examination_room_creation_requires_fields()
    {
        $response = $this->actingAs($this->user)->post(route('organization.examination-rooms.store'), [
            'poliklinik_id' => '',
            'name'          => '',
            'capacity'      => '',
        ]);

        $response->assertSessionHasErrors(['poliklinik_id', 'name', 'capacity']);
    }

    public function test_can_update_examination_room()
    {
        $room = ExaminationRoom::create(['poliklinik_id' => $this->poliklinik->id, 'name' => 'Oda 101', 'capacity' => 1]);

        $response = $this->actingAs($this->user)->put(route('organization.examination-rooms.update', $room), [
            'poliklinik_id' => $this->poliklinik->id,
            'name'          => 'Oda 101 (Genişletilmiş)',
            'capacity'      => 3,
        ]);

        $response->assertRedirect(route('organization.examination-rooms.index'));
        $this->assertDatabaseHas('examination_rooms', ['id' => $room->id, 'capacity' => 3]);
    }

    public function test_can_delete_examination_room()
    {
        $room = ExaminationRoom::create(['poliklinik_id' => $this->poliklinik->id, 'name' => 'Silinecek Oda', 'capacity' => 1]);

        $response = $this->actingAs($this->user)->delete(route('organization.examination-rooms.destroy', $room));

        $response->assertRedirect(route('organization.examination-rooms.index'));
        $this->assertSoftDeleted('examination_rooms', ['id' => $room->id]);
    }
}
