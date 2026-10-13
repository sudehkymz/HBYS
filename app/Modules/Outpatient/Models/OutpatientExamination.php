<?php

namespace App\Modules\Outpatient\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Patient\Models\Patient;
use App\Modules\Personnel\Models\Doctor;
use App\Modules\Appointment\Models\Appointment;

class OutpatientExamination extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'outpatient_examinations';

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_id',
        'chief_complaint',
        'physical_examination',
        'icd10_code',
        'treatment_plan',
        'status',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'in_progress' => 'Muayenede',
            'completed'   => 'Tamamlandı',
            'referred'    => 'Sevk Edildi',
            'admitted'    => 'Yatış Verildi',
            default       => ucfirst($this->status),
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'in_progress' => 'warning',
            'completed'   => 'success',
            'referred'    => 'info',
            'admitted'    => 'danger',
            default       => 'secondary',
        };
    }
}
