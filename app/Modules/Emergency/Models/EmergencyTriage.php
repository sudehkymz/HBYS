<?php

namespace App\Modules\Emergency\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Patient\Models\Patient;
use App\Modules\Personnel\Models\Doctor;

class EmergencyTriage extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'emergency_triages';

    protected $fillable = [
        'patient_id',
        'triage_category',
        'chief_complaint',
        'vital_signs',
        'assigned_doctor_id',
        'status',
    ];

    protected $casts = [
        'vital_signs' => 'array',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'assigned_doctor_id');
    }

    public function getCategoryLabelAttribute(): string
    {
        return match ($this->triage_category) {
            'red'    => 'Kırmızı Kod (Kritik / Acil)',
            'yellow' => 'Sarı Kod (Orta Derece Acil)',
            'green'  => 'Yeşil Kod (Ayaktan / Hafif)',
            default  => ucfirst($this->triage_category),
        };
    }

    public function getCategoryBadgeAttribute(): string
    {
        return match ($this->triage_category) {
            'red'    => 'danger',
            'yellow' => 'warning text-dark',
            'green'  => 'success',
            default  => 'secondary',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'waiting'      => 'Sıra Bekliyor',
            'in_treatment' => 'Müdahaleye Alındı',
            'discharged'   => 'Taburcu Edildi',
            'transferred'  => 'Yatış/Sevk Verildi',
            default        => ucfirst($this->status),
        };
    }
}
