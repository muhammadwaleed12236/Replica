<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'type',
        'phone',
        'city',
        'opening_balance',
        'current_balance',
        'credit_limit',
        'credit_days_limit',
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function vouchers()
    {
        return $this->hasMany(Voucher::class);
    }

    public function recalculateBalance()
    {
        $totalSales = $this->sales()->sum('net_amount');
        $totalPurchases = $this->purchases()->sum('net_amount');
        $totalReceipts = $this->vouchers()->where('type', 'receipt')->sum('amount');
        $totalPayments = $this->vouchers()->where('type', 'payment')->sum('amount');

        if ($this->type === 'supplier') {
            $newBalance = $this->opening_balance + $totalPurchases - $totalPayments;
        } else {
            // Customer or Both
            $newBalance = $this->opening_balance + $totalSales - $totalReceipts;
        }

        $this->update(['current_balance' => $newBalance]);
        return $newBalance;
    }
}
