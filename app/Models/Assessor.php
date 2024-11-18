<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessor extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function competencyStandards()
    {
        return $this->hasMany(CompetencyStandar::class);
    }

    public function examinations()
    {
        return $this->hasMany(Examination::class);
    }
}
