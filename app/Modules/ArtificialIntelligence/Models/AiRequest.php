<?php

namespace App\Modules\ArtificialIntelligence\Models;

use Illuminate\Database\Eloquent\Model;

class AiRequest extends Model
{
    protected $table = 'ai_requests';

    protected $fillable = [
        'user_id',
        'patient_id',
        'request_type',
        'model_name',
        'anonymized_input',
        'status'
    ];

    public function response()
    {
        return $this->hasOne(AiResponse::class, 'ai_request_id');
    }
}
