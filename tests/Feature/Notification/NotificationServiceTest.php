<?php

namespace Tests\Feature\Notification;

use App\Modules\Identity\Models\User;
use App\Modules\Notification\Services\NotificationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function makeUser(string $role = 'physician'): User
    {
        return User::create([
            'name'      => 'Dr. Mehmet Öz',
            'email'     => 'mehmet@hbys.test',
            'password'  => bcrypt('Test1234!'),
            'role'      => $role,
            'is_active' => true,
        ]);
    }

    public function test_unread_count_decreases_when_notification_is_marked_as_read(): void
    {
        $user = $this->makeUser();
        $service = app(NotificationService::class);

        $initialUnread = $service->getUnreadCount(0, $user);
        $this->assertGreaterThan(0, $initialUnread);

        $alerts = $service->getActiveClinicalAlerts(0, $user);
        $firstId = $alerts[0]['id'];

        $service->markAsRead($firstId);

        $newUnread = $service->getUnreadCount(0, $user);
        $this->assertEquals($initialUnread - 1, $newUnread);
    }

    public function test_mark_read_endpoint_returns_updated_unread_count(): void
    {
        $user = $this->makeUser();
        $service = app(NotificationService::class);
        $alerts = $service->getActiveClinicalAlerts(0, $user);
        $targetId = $alerts[0]['id'];

        $response = $this->actingAs($user)->postJson(route('notifications.mark_read', ['id' => $targetId]));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
            'unread_count',
            'stats'
        ]);
        $response->assertJson([
            'status' => 'success',
        ]);
    }

    public function test_mark_all_read_clears_all_unread_notifications(): void
    {
        $user = $this->makeUser();
        $service = app(NotificationService::class);

        $response = $this->actingAs($user)->postJson(route('notifications.mark_all_read'));

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'unread_count' => 0,
        ]);

        $this->assertEquals(0, $service->getUnreadCount(0, $user));
    }
}
