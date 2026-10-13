<?php

namespace App\Modules\Referral\Services;

use App\Modules\Referral\Models\Referral;
use Illuminate\Support\Str;

class ReferralService
{
    /**
     * Sevk Paneli listesini ve istatistiklerini getirir.
     */
    public function getReferralDashboardData(?string $type = null, ?string $status = null): array
    {
        $query = Referral::with(['patient', 'referringDoctor', 'targetClinic']);

        if ($type) {
            $query->where('referral_type', $type);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $referrals = $query->orderBy('created_at', 'desc')->get();

        return [
            'referrals' => $referrals,
            'stats'     => [
                'total_count'    => Referral::count(),
                'internal_count' => Referral::where('referral_type', 'internal')->count(),
                'external_count' => Referral::where('referral_type', 'external')->count(),
                'pending_count'  => Referral::where('status', 'pending')->count(),
            ],
        ];
    }

    /**
     * Benzersiz SVK- koda sahip yeni Sevk kaydı oluşturur.
     */
    public function createReferral(array $data): Referral
    {
        $referralCode = 'SVK-' . date('Y') . '-' . strtoupper(Str::random(5));

        return Referral::create([
            'referral_code'       => $referralCode,
            'patient_id'          => $data['patient_id'],
            'referring_doctor_id' => $data['referring_doctor_id'] ?? null,
            'referral_type'       => $data['referral_type'] ?? 'internal',
            'target_clinic_id'    => $data['target_clinic_id'] ?? null,
            'target_hospital'     => $data['target_hospital'] ?? null,
            'reason'              => $data['reason'],
            'transport_type'      => $data['transport_type'] ?? 'self',
            'status'              => 'pending',
        ]);
    }

    /**
     * Sevk durumunu günceller.
     */
    public function updateStatus(Referral $referral, string $status): Referral
    {
        $referral->update(['status' => $status]);
        return $referral;
    }
}
