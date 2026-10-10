<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'barcode',
        'name',
        'company_id',
        'category',
        'unit',
        'purchase_price',
        'sale_price',
        'wholesale_price',
        'stock_quantity',
        'description',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function units()
    {
        return $this->hasMany(ProductUnit::class);
    }
}
