<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductUnit extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'alias',
        'factor',
        'purchase_price',
        'sale_price',
        'wholesale_price',
        'is_base_unit',
        'is_default_purchase',
        'is_default_sale',
        'is_purchase_unit',
        'is_sale_unit',
    ];

    protected $casts = [
        'is_base_unit' => 'boolean',
        'is_default_purchase' => 'boolean',
        'is_default_sale' => 'boolean',
        'is_purchase_unit' => 'boolean',
        'is_sale_unit' => 'boolean',
        'purchase_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
