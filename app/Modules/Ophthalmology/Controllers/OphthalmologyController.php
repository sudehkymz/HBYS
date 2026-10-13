<?php

namespace App\Modules\Ophthalmology\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OphthalmologyController extends Controller
{
    public function index(Request $request)
    {
        $context = $this->getPatientContext($request, 'general');
        return view('modules.ophthalmology.subspecialties.general', $context);
    }

    public function glaucoma(Request $request)
    {
        $context = $this->getPatientContext($request, 'glaucoma');
        return view('modules.ophthalmology.subspecialties.glaucoma', $context);
    }

    public function retina(Request $request)
    {
        $context = $this->getPatientContext($request, 'retina');
        return view('modules.ophthalmology.subspecialties.retina', $context);
    }

    public function strabismus(Request $request)
    {
        $context = $this->getPatientContext($request, 'strabismus');
        return view('modules.ophthalmology.subspecialties.strabismus', $context);
    }

    public function uvea(Request $request)
    {
        $context = $this->getPatientContext($request, 'uvea');
        return view('modules.ophthalmology.subspecialties.uvea', $context);
    }

    public function cornea(Request $request)
    {
        $context = $this->getPatientContext($request, 'cornea');
        return view('modules.ophthalmology.subspecialties.cornea', $context);
    }

    public function oculoplastics(Request $request)
    {
        $context = $this->getPatientContext($request, 'oculoplastics');
        return view('modules.ophthalmology.subspecialties.oculoplastics', $context);
    }

    public function storeExam(Request $request)
    {
        $admissionId = $request->input('admission_id');
        $subSpecialty = $request->input('sub_specialty', 'general');
        $notes = $request->input('notes');
        $diagnosis = $request->input('diagnosis');
        $subSpecialtyData = $request->input('sub_specialty_data', []);
        $redirectRoute = $request->input('redirect_route', 'ophthalmology.index');

        $exams = session('ophthalmology_exams', []);
        $exams[$admissionId] = [
            'sub_specialty' => $subSpecialty,
            'notes' => $notes,
            'diagnosis' => $diagnosis,
            'data' => $subSpecialtyData,
            'doctor' => auth()->user()->name ?? 'Prof. Dr. Halil İbrahim Altın',
            'date' => date('d.m.Y H:i')
        ];

        session(['ophthalmology_exams' => $exams]);

        return redirect()->route($redirectRoute, ['admission_id' => $admissionId])
            ->with('success', 'Göz Hastalıkları göz muayenesi ve birim tetkik kaydı başarıyla kaydedildi.');
    }

    private function getPatientContext(Request $request, string $activeSubKey)
    {
        $defaultAdmissions = [
            [
                'id' => 1701,
                'patient_name' => 'Fehmi Şen',
                'national_id' => '10293848251',
                'age' => 67,
                'gender' => 'Erkek',
                'room' => 'GÖZ-101 (FAKO Ameliyathane)',
                'service' => 'Göz Hastalıkları (Ana Branş)',
                'diagnosis' => 'Senil Nükleer Katarakt & FAKO + Katlanabilir Göz İçi Lens (IOL) İmplantasyonu',
                'attending_physician' => 'Prof. Dr. Halil İbrahim Altın',
                'visual_acuity' => 'Görme Keskinliği: OD 0.2, OS 0.9 (Snellen)',
                'iop_pressure' => 'Göz İçi Basınç (GİB): OD 15 mmHg, OS 14 mmHg (Goldmann)',
                'ophthalmology_med' => 'Moxifloksasin 0.5% + Prednizolon Asetat Damla 4x1'
            ],
            [
                'id' => 1702,
                'patient_name' => 'Gülsüm Doğan',
                'national_id' => '21039486362',
                'age' => 61,
                'gender' => 'Kadın',
                'room' => 'GÖZ-102 (Glokom Birimi)',
                'service' => 'Glokom Birimi',
                'diagnosis' => 'Primer Açık Açılı Glokom (PAAG) & Retinal Sinir Lifi (RNFL) İncelemesi / SLT Lazer',
                'attending_physician' => 'Doç. Dr. Meltem Yılmaz',
                'iop_pressure' => 'OD 24 mmHg, OS 18 mmHg (Paşimetri CCT: 535 µm)',
                'oct_rnfl' => 'OCT RNFL: Superior & İnferior Kadran İnceltme (MD: -4.8 dB)',
                'ophthalmology_med' => 'Latanoprost 0.005% (Gece 1x1) + Timolol/Dorzolamid 2x1'
            ],
            [
                'id' => 1703,
                'patient_name' => 'Kemal Varol',
                'national_id' => '32140597473',
                'age' => 55,
                'gender' => 'Erkek',
                'room' => 'GÖZ-103 (Retina & Vitreoretinal)',
                'service' => 'Retina Birimi',
                'diagnosis' => 'Diyabetik Makula Ödemi (DMÖ) & İntravitreal Anti-VEGF (Aflibercept) Enjeksiyonu',
                'attending_physician' => 'Prof. Dr. Halil İbrahim Altın',
                'oct_retina' => 'Makula OCT: Santral Foveal Kalınlık 410 µm (Kistik Ödem)',
                'ffa_result' => 'FFA Fundus Anjiyosu: Temporal Makuler Sızıntı & Mikroanevrizmalar',
                'ophthalmology_med' => 'İntravitreal Aflibercept (Eylea 2mg/0.05ml) Enjeksiyonu Tamamlandı'
            ],
            [
                'id' => 1704,
                'patient_name' => 'Eren Uçar (Çocuk)',
                'national_id' => '43251608584',
                'age' => 7,
                'gender' => 'Erkek',
                'room' => 'GÖZ-104 (Şaşılık Birimi)',
                'service' => 'Şaşılık Birimi',
                'diagnosis' => 'Konjenital İnfantil Ezotropya (İçe Şaşılık) & 25 Prizm Diyoptri Cerrahi Planı',
                'attending_physician' => 'Uzm. Dr. Aylin Can',
                'strabismus_angle' => 'Hirschberg / Prizm Kapama Testi: 25 PD Sağ Ezotropya',
                'stereoacuity' => 'Titmus Fly Stereopsis: 100 arcsec (Ambliyopi Kapama Tedavisi 4 Saat/gün)',
                'surgical_plan' => 'Bilateral İç Rekstus Kas Geriletmesi (Recession 5.5mm)'
            ],
            [
                'id' => 1705,
                'patient_name' => 'Sevim Kılıç',
                'national_id' => '54362719695',
                'age' => 34,
                'gender' => 'Kadın',
                'room' => 'GÖZ-105 (Uvea Birimi)',
                'service' => 'Uvea Birimi',
                'diagnosis' => 'Behçet Hastalığına Bağlı Ön ve Arka Üveit & Hipopiyon / İnfliksimab Biyolojik Tedavi',
                'attending_physician' => 'Doç. Dr. Meltem Yılmaz',
                'uveitis_grade' => 'Ön Kamara Reaksiyonu: SUN Cell 3+ Hücre & 1mm Hipopiyon',
                'fundus_exam' => 'Vitreus Hücre 2+, Retina Vasküliti Kılıflanması Pozitif',
                'biologic_med' => 'Sistemik Metilprednizolon 1mg/kg + İnfliksimab Biyolojik İnfizyon'
            ],
            [
                'id' => 1706,
                'patient_name' => 'Kaan Sönmez',
                'national_id' => '65473820706',
                'age' => 26,
                'gender' => 'Erkek',
                'room' => 'GÖZ-106 (Kornea Birimi)',
                'service' => 'Kornea Birimi',
                'diagnosis' => 'Progresif Keratokonus & Pentacam Topografi / Corneal Cross-Linking (CXL)',
                'attending_physician' => 'Prof. Dr. Halil İbrahim Altın',
                'topography_kmax' => 'Pentacam Keratometri: Kmax 54.8 D (Progresif İncelme 440 µm)',
                'refractive_plan' => 'Epi-Off Riboflavin + UV-A Corneal Cross-Linking (CXL) Çapraz Bağlama'
            ],
            [
                'id' => 1707,
                'patient_name' => 'Nevin Polat',
                'national_id' => '76584931817',
                'age' => 69,
                'gender' => 'Kadın',
                'room' => 'GÖZ-107 (Oküloplasti Birimi)',
                'service' => 'Oküloplasti Birimi',
                'diagnosis' => 'Sol Üst Göz Kapağı Senil Pitozis & Levator Rezeksiyonu / Blefaroplasti',
                'attending_physician' => 'Uzm. Dr. Aylin Can',
                'mrd_measure' => 'Marginal Reflex Distance (MRD-1): OD 4.0 mm, OS 1.0 mm (Belirgin Pitozis)',
                'levator_fn' => 'Levator Kas Fonksiyonu: 12 mm (İyi Kas Fonksiyonu)',
                'oculoplastic_surg' => 'Sol Levator Aponöroz Rezeksiyonu + Üst Kapak Blefaroplasti'
            ]
        ];

        if (!session()->has('ophthalmology_admissions')) {
            session(['ophthalmology_admissions' => $defaultAdmissions]);
        }

        $ophAdmissions = session('ophthalmology_admissions', $defaultAdmissions);
        $selectedId = $request->query('admission_id');
        $selectedAdmission = null;

        if ($selectedId) {
            foreach ($ophAdmissions as $adm) {
                if ($adm['id'] == $selectedId) {
                    $selectedAdmission = $adm;
                    break;
                }
            }
        }

        if (!$selectedAdmission && count($ophAdmissions) > 0) {
            $selectedAdmission = reset($ophAdmissions);
            $selectedId = $selectedAdmission['id'];
        }

        $ophExams = session('ophthalmology_exams', []);

        return compact(
            'ophAdmissions',
            'selectedAdmission',
            'selectedId',
            'ophExams',
            'activeSubKey'
        );
    }
}
