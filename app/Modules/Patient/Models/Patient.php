<?php

namespace App\Modules\Patient\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Prescription\Models\Prescription;

class Patient extends Model
{
    use SoftDeletes;

    protected $table = 'patients';

    protected $fillable = [
        'national_id',
        'first_name',
        'last_name',
        'birth_date',
        'gender',
        'phone',
        'address',
        'blood_type',
        'allergies',
        'chronic_conditions',
        'emergency_contact',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function episodesOfCare()
    {
        return $this->hasMany(EpisodeOfCare::class, 'patient_id');
    }

    public function encounters()
    {
        return $this->hasMany(Encounter::class, 'patient_id');
    }

    /**
     * Hastaya ait e-reçeteler (Prescription modülü ile entegrasyon).
     */
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'patient_id');
    }
}