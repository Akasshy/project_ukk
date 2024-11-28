<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examination extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function assessor()
    {
        return $this->belongsTo(Assessor::class);
    }
    public function standar()
    {
        return $this->belongsTo(CompetencyStandar::class, 'standar_id');
    }
    public function competencyElement()
    {
        return $this->belongsTo(CompetencyElement::class, 'element_id');
    }
    public function element()
    {
        return $this->belongsTo(CompetencyElement::class, 'element_id');
    }
    public function elements()
    {
        return $this->hasMany(CompetencyElement::class, 'id', 'element_id');
    }
}
