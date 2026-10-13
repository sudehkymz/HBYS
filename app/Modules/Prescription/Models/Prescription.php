<?php

namespace App\Modules\Prescription\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    protected $table = 'prescriptions';

    protected $fillable = [
        'prescription_code',
        'patient_id',
        'physician_id',
        'diagnosis_code',
        'status',
        'is_erecepta_sent',
        'erecepta_no',
        'notes'
    ];

    protected $casts = [
        'is_erecepta_sent' => 'boolean',
    ];

    public function items()
    {
        return $this->hasMany(PrescriptionItem::class, 'prescription_id');
    }
}
