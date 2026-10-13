<?php

namespace App\Modules\Personnel\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorAcademicAssignment extends Model
{
    protected $table = 'doctor_academic_assignments';

    protected $fillable = [
        'senior_doctor_id',
        'junior_doctor_id',
        'role_type',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function seniorDoctor()
    {
        return $this->belongsTo(Doctor::class, 'senior_doctor_id');
    }

    public function juniorDoctor()
    {
        return $this->belongsTo(Doctor::class, 'junior_doctor_id');
    }
}
