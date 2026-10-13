<?php

namespace App\Modules\Patient\Models;

use Illuminate\Database\Eloquent\Model;

class EpisodeOfCare extends Model
{
    protected $table = 'episodes_of_care';

    protected $fillable = [
        'patient_id',
        'title',
        'status',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date'   => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function encounters()
    {
        return $this->hasMany(Encounter::class, 'episode_of_care_id');
    }
}