<?php

namespace App\Modules\Nutrition\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NutritionController extends Controller
{
    /**
     * Display nutrition management dashboard.
     */
    public function index(Request $request)
    {
        $admissions = session('admissions', []);
        $selectedId = $request->query('admission_id');

        $selectedAdmission = null;
        if ($selectedId) {
            foreach ($admissions as $adm) {
                if ($adm['id'] == $selectedId) {
                    $selectedAdmission = $adm;
                    break;
                }
            }
        } elseif (count($admissions) > 0) {
            $selectedAdmission = $admissions[0];
            $selectedId = $selectedAdmission['id'];
        }

        // Available diet plans
        $diets = [
            'Normal Diyet' => 'Tüm besin gruplarını içeren standart hastane menüsü',
            'Diyabetik Diyet' => 'Şeker oranı düşük, karbonhidrat kontrollü menü (Diyabet hastaları için)',
            'Tuzsuz (Düşük Sodyum) Diyet' => 'Hipertansiyon ve böbrek hastaları için sodyumu kısıtlanmış menü',
            'Glutensiz Diyet' => 'Çölyak ve gluten hassasiyeti olan hastalar için unsuz menü',
            'Sıvı Diyet' => 'Post-op dönemdeki hastalar için çorba, komposto ve püre bazlı menü'
        ];

        // Allergens list
        $allergens = ['Gluten', 'Laktoz', 'Kuruyemiş', 'Çilek', 'Deniz Ürünleri'];

        // Default diet assignments
        $defaultAssignments = [
            501 => [
                'diet_name' => 'Sıvı Diyet',
                'allergens' => ['Gluten'],
                'nutritionist' => 'Dyt. Merve Demir',
                'assigned_at' => '27.07.2026 12:00'
            ],
            502 => [
                'diet_name' => 'Diyabetik Diyet',
                'allergens' => [],
                'nutritionist' => 'Dyt. Merve Demir',
                'assigned_at' => '28.07.2026 09:00'
            ],
            503 => [
                'diet_name' => 'Tuzsuz (Düşük Sodyum) Diyet',
                'allergens' => [],
                'nutritionist' => 'Dyt. Merve Demir',
                'assigned_at' => '28.07.2026 10:30'
            ],
            504 => [
                'diet_name' => 'Normal Diyet',
                'allergens' => ['Laktoz'],
                'nutritionist' => 'Dyt. Merve Demir',
                'assigned_at' => '29.07.2026 11:00'
            ],
            505 => [
                'diet_name' => 'Normal Diyet',
                'allergens' => [],
                'nutritionist' => 'Dyt. Merve Demir',
                'assigned_at' => '29.07.2026 11:30'
            ]
        ];

        if (!session()->has('nutrition_assignments')) {
            session(['nutrition_assignments' => $defaultAssignments]);
        }

        $assignments = session('nutrition_assignments');
        $activeAssignment = $selectedId && isset($assignments[$selectedId]) ? $assignments[$selectedId] : null;

        return view('modules.nutrition.index', compact(
            'admissions',
            'selectedAdmission',
            'selectedId',
            'diets',
            'allergens',
            'assignments'
        ));
    }

    /**
     * Assign a diet plan to a patient with allergen warning checks.
     */
    public function assign(Request $request)
    {
        $validated = $request->validate([
            'admission_id' => 'required|integer',
            'diet_name' => 'required|string',
            'allergens' => 'nullable|array',
            'nutritionist' => 'required|string|max:100',
        ]);

        $admissionId = $validated['admission_id'];
        $dietName = $validated['diet_name'];
        $patientAllergens = $validated['allergens'] ?? [];

        // Allergen Safety Check!
        // If patient is "Zeynep Ak" (Diyabet hastası) and gets "Normal Diyet", warn or throw error.
        $admissions = session('admissions', []);
        $patientName = 'Hasta';
        $diagnosis = '';
        foreach ($admissions as $adm) {
            if ($adm['id'] == $admissionId) {
                $patientName = $adm['patient_name'];
                $diagnosis = $adm['diagnosis'];
                break;
            }
        }

        // Custom validation check
        if (str_contains(strtolower($diagnosis), 'diyabet') && $dietName === 'Normal Diyet') {
            return redirect()->back()->withErrors([
                'diet_name' => "UYARI: Diyabetik tanıya sahip olan {$patientName} isimli hastaya 'Normal Diyet' atanamaz. Lütfen 'Diyabetik Diyet' seçin."
            ]);
        }

        if (in_array('Gluten', $patientAllergens) && $dietName === 'Normal Diyet') {
            return redirect()->back()->withErrors([
                'diet_name' => "UYARI: Gluten hassasiyeti/alerjisi olan {$patientName} isimli hastaya 'Normal Diyet' atanamaz. Lütfen 'Glutensiz Diyet' seçin."
            ]);
        }

        $assignments = session('nutrition_assignments', []);
        $assignments[$admissionId] = [
            'diet_name' => $dietName,
            'allergens' => $patientAllergens,
            'nutritionist' => $validated['nutritionist'],
            'assigned_at' => now()->format('d.m.Y H:i')
        ];

        session(['nutrition_assignments' => $assignments]);

        // Add to timeline
        $timelineEvents = session('timeline_events', []);
        array_unshift($timelineEvents, [
            'time' => now()->format('d.m.Y H:i'),
            'type' => 'Diyet / Beslenme',
            'badge_color' => 'success',
            'details' => "{$patientName} isimli hasta için diyet planı atandı: {$dietName} (Diyetisyen: {$validated['nutritionist']})."
        ]);
        session(['timeline_events' => $timelineEvents]);

        return redirect()->route('nutrition.index', ['admission_id' => $admissionId])
            ->with('success', 'Beslenme ve diyet planı başarıyla kaydedildi.');
    }
}
