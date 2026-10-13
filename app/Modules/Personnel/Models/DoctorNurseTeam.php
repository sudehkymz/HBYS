<?php

namespace App\Modules\Personnel\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorNurseTeam extends Model
{
    protected $table = 'doctor_nurse_teams';

    protected $fillable = [
        'doctor_id',
        'nurse_personnel_id',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function nurse()
    {
        return $this->belongsTo(Personnel::class, 'nurse_personnel_id');
    }
}
