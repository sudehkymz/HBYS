<?php

namespace App\Modules\MedicalReport\Models;

use Illuminate\Database\Eloquent\Model;

class ReportApproval extends Model
{
    protected $table = 'report_approvals';

    protected $fillable = [
        'medical_report_id',
        'approver_id',
        'status',
        'notes'
    ];
}
