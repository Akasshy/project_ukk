<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetencyElement extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function competencyStandard()
    {
        return $this->belongsTo(CompetencyStandar::class, 'competency_id');
    }

    public function examinations()
    {
        return $this->hasMany(Examination::class, 'element_id');
    }
    public function competency_standard()
    {
        return $this->belongsTo(CompetencyStandar::class, 'competency_id');
    }
}
