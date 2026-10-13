<?php

namespace App\Modules\Referral\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Patient\Models\Patient;
use App\Modules\Personnel\Models\Doctor;
use App\Modules\Organization\Models\Clinic;

class Referral extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'referrals';

    protected $fillable = [
        'referral_code',
        'patient_id',
        'referring_doctor_id',
        'referral_type',
        'target_clinic_id',
        'target_hospital',
        'reason',
        'transport_type',
        'status',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function referringDoctor()
    {
        return $this->belongsTo(Doctor::class, 'referring_doctor_id');
    }

    public function targetClinic()
    {
        return $this->belongsTo(Clinic::class, 'target_clinic_id');
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->referral_type) {
            'internal' => 'İç Sevk (Klinikler Arası)',
            'external' => 'Dış Sevk (Hastaneler Arası / Üst Merkez)',
            default    => ucfirst($this->referral_type),
        };
    }

    public function getTransportLabelAttribute(): string
    {
        return match ($this->transport_type) {
            'ambulance' => 'Ambulans / 112 Acil',
            'self'      => 'Kendi İmkânıyla / Ayaktan',
            default     => ucfirst($this->transport_type),
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'     => 'Onay Bekliyor',
            'approved'    => 'Onaylandı',
            'transferred' => 'Transfer Edildi',
            'completed'   => 'Sevk Tamamlandı',
            'cancelled'   => 'İptal Edildi',
            default       => ucfirst($this->status),
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending'     => 'warning text-dark',
            'approved'    => 'info',
            'transferred' => 'primary',
            'completed'   => 'success',
            'cancelled'   => 'danger',
            default       => 'secondary',
        };
    }
}
