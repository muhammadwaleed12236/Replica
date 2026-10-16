<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name', 'phone', 'city'];

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
