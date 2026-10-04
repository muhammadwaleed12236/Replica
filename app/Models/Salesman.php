<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salesman extends Model
{
    protected $table = 'salesmen';
    protected $fillable = ['name', 'phone', 'commission_rate'];
}
