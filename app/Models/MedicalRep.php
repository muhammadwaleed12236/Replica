<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalRep extends Model
{
    protected $table = 'medical_reps';
    protected $fillable = ['name', 'phone', 'company_name'];
}
