<?php

namespace App\Modules\Identity\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Identity\Models\User;
use App\Modules\Identity\Requests\LoginRequest;
use App\Modules\Identity\Requests\RegisterRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    // ─────────────────────────── LOGIN ─────────────────────────────

    public function showLogin(): View
    {
        return view('identity.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'E-posta veya şifre hatalı.']);
        }

        /** @var User $user */
        $user = Auth::user();

        if (!$user->is_active) {
            Auth::logout();
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Hesabınız pasif durumda. Lütfen yönetici ile iletişime geçin.']);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    // ─────────────────────────── REGISTER ──────────────────────────

    public function showRegister(): View
    {
        return view('identity.register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'role'     => $request->role,
            'password' => $request->password, // hashed otomatik
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')
            ->with('success', 'Hesabınız başarıyla oluşturuldu. Hoş geldiniz, ' . $user->name . '!');
    }

    // ─────────────────────────── LOGOUT ────────────────────────────

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Başarıyla çıkış yapıldı.');
    }

    // ─────────────────────────── DASHBOARD ─────────────────────────

    public function dashboard(): View
    {
        /** @var \App\Modules\Identity\Models\User $user */
        $user = Auth::user();

        // ── Gerçek İstatistikler ───────────────────────────────────────
        $stats = [
            'patients'  => \App\Modules\Patient\Models\Patient::count(),
            'doctors'   => \App\Modules\Personnel\Models\Doctor::count(),
            'personnel' => \App\Modules\Personnel\Models\Personnel::count(),
            'clinics'   => \App\Modules\Organization\Models\Clinic::count(),
        ];

        // ── Rol Bazlı Hızlı Erişim Modülleri ─────────────────────────
        $quickLinks = match ($user->role) {
            'physician' => [
                ['icon' => 'fa-pills',           'color' => '#8b5cf6', 'label' => 'E-Reçete Yaz',        'route' => 'prescription.index'],
                ['icon' => 'fa-user-doctor',      'color' => '#0ea5e9', 'label' => 'Doktor Paneli',       'route' => 'medical_report.chief_physician'],
                ['icon' => 'fa-user-injured',     'color' => '#10b981', 'label' => 'Hasta Listesi',       'route' => 'patients.index'],
                ['icon' => 'fa-bed',              'color' => '#f59e0b', 'label' => 'Yatış Yönetimi',      'route' => 'inpatient.admission.index'],
            ],
            'nurse' => [
                ['icon' => 'fa-syringe',          'color' => '#10b981', 'label' => 'Hemşirelik',          'route' => 'nursing.index'],
                ['icon' => 'fa-bed',              'color' => '#f59e0b', 'label' => 'Yatış Takibi',        'route' => 'inpatient.admission.index'],
                ['icon' => 'fa-bell',             'color' => '#ef4444', 'label' => 'Klinik Uyarılar',     'route' => 'notifications.index'],
                ['icon' => 'fa-user-injured',     'color' => '#0ea5e9', 'label' => 'Hastalar',            'route' => 'patients.index'],
            ],
            'pharmacist' => [
                ['icon' => 'fa-prescription-bottle-medical', 'color' => '#059669', 'label' => 'Eczane Takip',    'route' => 'pharmacy.index'],
                ['icon' => 'fa-pills',            'color' => '#8b5cf6', 'label' => 'E-Reçete Sorgula',    'route' => 'pharmacy.index'],
                ['icon' => 'fa-bell',             'color' => '#ef4444', 'label' => 'Klinik Uyarılar',     'route' => 'notifications.index'],
                ['icon' => 'fa-chart-line',        'color' => '#0ea5e9', 'label' => 'Kontrol Paneli',      'route' => 'dashboard'],
            ],
            'admin', 'manager' => [
                ['icon' => 'fa-user-injured',     'color' => '#0ea5e9', 'label' => 'Hastalar',            'route' => 'patients.index'],
                ['icon' => 'fa-users',            'color' => '#8b5cf6', 'label' => 'Personeller',         'route' => 'personnel.personnels.index'],
                ['icon' => 'fa-user-doctor',      'color' => '#10b981', 'label' => 'Doktor Paneli',       'route' => 'medical_report.chief_physician'],
                ['icon' => 'fa-building',         'color' => '#f59e0b', 'label' => 'Organizasyon',        'route' => 'organization.buildings.index'],
            ],
            default => [
                ['icon' => 'fa-user-injured',     'color' => '#0ea5e9', 'label' => 'Hastalar',            'route' => 'patients.index'],
                ['icon' => 'fa-user-doctor',      'color' => '#8b5cf6', 'label' => 'Doktor Paneli',       'route' => 'medical_report.chief_physician'],
                ['icon' => 'fa-pills',            'color' => '#10b981', 'label' => 'E-Reçete',            'route' => 'prescription.index'],
                ['icon' => 'fa-bell',             'color' => '#ef4444', 'label' => 'Bildirimler',         'route' => 'notifications.index'],
            ],
        };

        return view('identity.dashboard', compact('stats', 'quickLinks'));
    }
}