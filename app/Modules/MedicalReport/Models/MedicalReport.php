<?php

namespace App\Modules\MedicalReport\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalReport extends Model
{
    protected $table = 'medical_reports';

    protected $fillable = [
        'report_number',
        'patient_id',
        'physician_id',
        'report_type',
        'diagnosis',
        'rest_days',
        'start_date',
        'end_date',
        'report_content',
        'status',
        'chief_physician_approval_status',
        'e_rapor_no'
    ];

    public function approvals()
    {
        return $this->hasMany(ReportApproval::class, 'medical_report_id');
    }
}
