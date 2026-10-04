<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_no',
        'date',
        'party_id',
        'company_id',
        'amount',
        'discount',
        'net_amount',
        'remarks',
    ];

    public function party()
    {
        return $this->belongsTo(Party::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }
}
