<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amanat extends Model
{
    protected $fillable = ['party_id', 'depositor_name', 'amount', 'date', 'details'];

    public function party()
    {
        return $this->belongsTo(Party::class);
    }
}
