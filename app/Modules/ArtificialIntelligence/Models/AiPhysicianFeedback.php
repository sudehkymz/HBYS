<?php

namespace App\Modules\ArtificialIntelligence\Models;

use Illuminate\Database\Eloquent\Model;

class AiPhysicianFeedback extends Model
{
    protected $table = 'ai_physician_feedback';

    protected $fillable = [
        'ai_response_id',
        'physician_id',
        'action',
        'feedback_notes'
    ];
}
