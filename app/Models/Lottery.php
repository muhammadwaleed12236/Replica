<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lottery extends Model
{
    protected $fillable = ['scheme_name', 'amount', 'date', 'status', 'remarks'];
}
