<?php

namespace App\Modules\Organization\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clinic extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['floor_id', 'name'];

    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }

    public function polikliniks()
    {
        return $this->hasMany(Poliklinik::class);
    }

    /**
     * Kliniğe atanmış doktorlar (Personnel modülü ile entegrasyon).
     */
    public function doctors()
    {
        return $this->hasMany(\App\Modules\Personnel\Models\Doctor::class, 'clinic_id');
    }
}