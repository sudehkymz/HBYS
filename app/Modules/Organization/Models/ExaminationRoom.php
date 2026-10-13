<?php

namespace App\Modules\Organization\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExaminationRoom extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['poliklinik_id', 'name', 'capacity'];

    public function poliklinik()
    {
        return $this->belongsTo(Poliklinik::class);
    }
}
