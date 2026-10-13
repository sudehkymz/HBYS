<?php

namespace App\Modules\Prescription\Models;

use Illuminate\Database\Eloquent\Model;

class PrescriptionItem extends Model
{
    protected $table = 'prescription_items';

    protected $fillable = [
        'prescription_id',
        'drug_name',
        'barcode',
        'dosage',
        'frequency',
        'box_count',
        'usage_route'
    ];
}
