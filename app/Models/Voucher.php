<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = ['voucher_no', 'type', 'date', 'party_id', 'amount', 'payment_mode', 'reference_no', 'remarks'];

    public function party()
    {
        return $this->belongsTo(Party::class);
    }
}
