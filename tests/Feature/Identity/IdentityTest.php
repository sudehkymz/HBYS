<?php

namespace Tests\Feature\Identity;

use Tests\TestCase;
use App\Modules\Identity\Models\User;
use App\Modules\Patient\Models\Patient;
use App\Modules\Personnel\Models\Doctor;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * IdentityTest — Auth akışı ve Dashboard entegrasyon testleri.
 *
 * PR #2 ve #3 entegrasyonu sonrasında:
 * - Dashboard artık gerçek veritabanı istatistiklerini gösteriyor
 * - Rol bazlı hızlı erişim linkleri döndürülüyor
 */
class IdentityTest extends TestCase
{
    use RefreshDatabase;

    protected function makeUser(string $role = 'admin'): User
    {
        return User::create([
            'name'      => 'Test Kullanici',
            'email'     => "test_{$role}@hbys.test",
            'password'  => bcrypt('Test1234!'),
            'role'      => $role,
            'is_active' => true,
        ]);
    }

    // ─────────────────────────── LOGIN ─────────────────────────────

    public function test_login_page_is_accessible(): void
    {
        $response = $this->get(route('login'));
        $response->assertStatus(200);
        $response->assertSee('Giriş');
    }

    public function test_login_with_valid_credentials_redirects_to_dashboard(): void
    {
        $user = $this->makeUser('admin');

        $response = $this->post(route('login'), [
            'email'    => $user->email,
            'password' => 'Test1234!',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_with_wrong_password_fails(): void
    {
        $user = $this->makeUser('physician');

        $response = $this->post(route('login'), [
            'email'    => $user->email,
            'password' => 'WrongPass!',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_inactive_user_cannot_login(): void
    {
        $user = User::create([
            'name'      => 'Pasif Kullanici',
            'email'     => 'pasif@hbys.test',
            'password'  => bcrypt('Test1234!'),
            'role'      => 'nurse',
            'is_active' => false,
        ]);

        $response = $this->post(route('login'), [
            'email'    => 'pasif@hbys.test',
            'password' => 'Test1234!',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    // ─────────────────────────── REGISTER ──────────────────────────

    public function test_register_page_is_accessible(): void
    {
        if (!\Illuminate\Support\Facades\Route::has('register')) {
            $this->markTestSkipped('Kullanıcı kayıt rotası kapatılmıştır.');
        }
        $response = $this->get(route('register'));
        $response->assertStatus(200);
    }

    public function test_registration_creates_user_and_logs_in(): void
    {
        if (!\Illuminate\Support\Facades\Route::has('register')) {
            $this->markTestSkipped('Kullanıcı kayıt rotası kapatılmıştır.');
        }
        $response = $this->post(route('register'), [
            'name'                  => 'Yeni Doktor',
            'email'                 => 'yenidoktor@hbys.test',
            'phone'                 => '05551234567',
            'role'                  => 'physician',
            'password'              => 'Test1234!',
            'password_confirmation' => 'Test1234!',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('users', ['email' => 'yenidoktor@hbys.test', 'role' => 'physician']);
    }

    // ─────────────────────────── DASHBOARD ─────────────────────────

    public function test_dashboard_requires_auth(): void
    {
        $response = $this->get(route('dashboard'));
        $response->assertRedirect(route('login'));
    }

    public function test_dashboard_loads_real_stats_from_database(): void
    {
        $user = $this->makeUser('admin');

        // Gerçek hasta ve doktor oluştur
        Patient::create([
            'national_id' => '12345678901',
            'first_name'  => 'Test',
            'last_name'   => 'Hasta',
            'birth_date'  => '1990-01-01',
            'gender'      => 'male',
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertStatus(200);
        // İstatistik değeri view'da görünmeli
        $response->assertSee('1'); // patient count
        $response->assertSee('Kayıtlı Hasta');
    }

    public function test_physician_dashboard_shows_prescription_quick_link(): void
    {
        $user = $this->makeUser('physician');

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('E-Reçete Yaz');
        $response->assertSee('Doktor Paneli');
    }

    public function test_pharmacist_dashboard_shows_pharmacy_quick_link(): void
    {
        $user = $this->makeUser('pharmacist');

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Eczane Takip');
        $response->assertSee('E-Reçete Sorgula');
    }

    public function test_nurse_dashboard_shows_nursing_quick_link(): void
    {
        $user = $this->makeUser('nurse');

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Hemşirelik');
        $response->assertSee('Klinik Uyarılar');
    }

    // ─────────────────────────── LOGOUT ────────────────────────────

    public function test_logout_clears_session_and_redirects(): void
    {
        $user = $this->makeUser('admin');

        $this->actingAs($user)->post(route('logout'));

        $this->assertGuest();
    }
}
