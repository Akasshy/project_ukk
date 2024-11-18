<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = ['major_name', 'description'];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function competencyStandards()
    {
        return $this->hasMany(CompetencyStandar::class);
    }
}
