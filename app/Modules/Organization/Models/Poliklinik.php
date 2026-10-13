<?php

namespace App\Modules\Organization\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Poliklinik extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['clinic_id', 'name'];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function examinationRooms()
    {
        return $this->hasMany(ExaminationRoom::class);
    }
}
