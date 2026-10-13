<?php

namespace App\Modules\Personnel\Models;

use Illuminate\Database\Eloquent\Model;

class Personnel extends Model
{
    protected $table = 'personnel';

    protected $fillable = ['name', 'email', 'phone', 'role', 'clinic_id'];

    public function clinic()
    {
        return $this->belongsTo('App\Modules\Organization\Models\Clinic');
    }
}
