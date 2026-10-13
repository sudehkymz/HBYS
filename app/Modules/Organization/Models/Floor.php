<?php

namespace App\Modules\Organization\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Floor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['building_id', 'name'];

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function clinics()
    {
        return $this->hasMany(Clinic::class);
    }
}
