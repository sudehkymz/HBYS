<?php

namespace App\Modules\Personnel\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Identity\Models\User;

class Doctor extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'specialty',
        'academic_title',
        'sub_specialty',
        'clinic_id',
        'other_clinics',
        'examination_room_id',
        'working_hours',
        'appointment_capacity',
        'can_operate',
        'can_consult',
        'can_report',
        'has_e_signature',
        'leave_and_shift_info',
        'user_id'
    ];

    protected $casts = [
        'other_clinics' => 'array',
        'leave_and_shift_info' => 'array',
        'can_operate' => 'boolean',
        'can_consult' => 'boolean',
        'can_report' => 'boolean',
        'has_e_signature' => 'boolean',
    ];

    public function clinic()
    {
        return $this->belongsTo('App\Modules\Organization\Models\Clinic');
    }

    public function examinationRoom()
    {
        return $this->belongsTo('App\Modules\Organization\Models\ExaminationRoom', 'examination_room_id');
    }

    /**
     * Doktorun sistem kullanıcı hesabı (Identity modülü ile entegrasyon).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Kıdemli hekimin bağlı olduğu asistan/intern/araştırma görevlisi atamaları.
     */
    public function academicAssignments()
    {
        return $this->hasMany(DoctorAcademicAssignment::class, 'senior_doctor_id');
    }

    /**
     * Hekime bağlı çalışan hemşire ekibi.
     */
    public function nurseTeams()
    {
        return $this->hasMany(DoctorNurseTeam::class, 'doctor_id');
    }
}
