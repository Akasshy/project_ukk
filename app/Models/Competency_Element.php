<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competency_Element extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function competency()
    {
        return $this->belongsTo(Competency_Standar::class);
    }
}
