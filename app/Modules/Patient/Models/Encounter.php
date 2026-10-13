<?php

namespace App\Modules\Patient\Models;

use Illuminate\Database\Eloquent\Model;

class Encounter extends Model
{
    protected $table = 'encounters';

    protected $fillable = [
        'patient_id',
        'episode_of_care_id',
        'physician_id',
        'type',
        'status',
        'encounter_date',
    ];

    protected $casts = [
        'encounter_date' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function episodeOfCare()
    {
        return $this->belongsTo(EpisodeOfCare::class, 'episode_of_care_id');
    }

    public function physician()
    {
        return $this->belongsTo(\App\Modules\Identity\Models\User::class, 'physician_id');
    }
}