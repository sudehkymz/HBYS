<?php

namespace App\Modules\ArtificialIntelligence\Models;

use Illuminate\Database\Eloquent\Model;

class AiClinicalSuggestion extends Model
{
    protected $table = 'ai_clinical_suggestions';

    protected $fillable = [
        'ai_response_id',
        'patient_id',
        'suggestion_type',
        'title',
        'description',
        'severity',
        'status'
    ];
}
