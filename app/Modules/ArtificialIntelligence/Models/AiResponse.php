<?php

namespace App\Modules\ArtificialIntelligence\Models;

use Illuminate\Database\Eloquent\Model;

class AiResponse extends Model
{
    protected $table = 'ai_responses';

    protected $fillable = [
        'ai_request_id',
        'raw_response',
        'summary_text',
        'clinical_suggestions_json',
        'confidence_score',
        'uncertainties_json'
    ];

    protected $casts = [
        'clinical_suggestions_json' => 'array',
        'uncertainties_json' => 'array',
        'confidence_score' => 'float'
    ];

    public function request()
    {
        return $this->belongsTo(AiRequest::class, 'ai_request_id');
    }

    public function suggestions()
    {
        return $this->hasMany(AiClinicalSuggestion::class, 'ai_response_id');
    }

    public function feedback()
    {
        return $this->hasOne(AiPhysicianFeedback::class, 'ai_response_id');
    }
}
