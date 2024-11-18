<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competency_Standar extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    public function assessor()
    {
        return $this->belongsTo(Assessor::class);
    }

    public function elements()
    {
        return $this->hasMany(Competency_Element::class);
    }
}
