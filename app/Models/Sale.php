<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_no',
        'date',
        'party_id',
        'salesman_id',
        'amount',
        'discount',
        'net_amount',
        'remarks',
    ];

    public function party()
    {
        return $this->belongsTo(Party::class);
    }

    public function salesman()
    {
        return $this->belongsTo(Salesman::class);
    }

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }
}
