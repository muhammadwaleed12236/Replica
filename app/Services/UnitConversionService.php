<?php

namespace App\Services;

use App\Models\ProductUnit;
use App\Models\Product;
use Exception;

class UnitConversionService
{
    /**
     * Convert a quantity to the base unit quantity based on the provided unit's operator and factor.
     */
    public function convertToBase($qty, ProductUnit $unit)
    {
        return (float) $qty * (float) $unit->factor;
    }

    /**
     * Format a base quantity into a readable string or specific unit format if needed.
     */
    public function formatFromBase($baseQty, $productId)
    {
        $units = ProductUnit::where('product_id', $productId)->get();
        $baseUnit = $units->where('is_base_unit', true)->first();
        
        if (!$baseUnit) {
            return $baseQty;
        }
        
        $baseUnitName = $baseUnit->name;
        
        // Find the largest unit that fits
        $largestUnit = $units->where('factor', '>', 1)->sortByDesc('factor')->first();
        
        if ($largestUnit && $largestUnit->factor > 1) {
            $largestUnitQty = floor($baseQty / $largestUnit->factor);
            $remainingBaseQty = fmod((float)$baseQty, (float)$largestUnit->factor);
            
            if ($largestUnitQty > 0) {
                if ($remainingBaseQty > 0) {
                    return "{$baseQty} {$baseUnitName} ({$largestUnitQty} {$largestUnit->name} + {$remainingBaseQty} {$baseUnitName})";
                }
                return "{$baseQty} {$baseUnitName} ({$largestUnitQty} {$largestUnit->name})";
            }
        }

        return "{$baseQty} {$baseUnitName}";
    }

    /**
     * Validate that no duplicate alias exists for a product.
     */
    public function validateUniqueAlias($productId, $alias, $excludeUnitId = null)
    {
        $query = ProductUnit::where('product_id', $productId)
            ->where('alias', $alias);

        if ($excludeUnitId) {
            $query->where('id', '!=', $excludeUnitId);
        }

        if ($query->exists()) {
            throw new Exception("Duplicate alias '{$alias}' for this product is not allowed.");
        }
    }
}
