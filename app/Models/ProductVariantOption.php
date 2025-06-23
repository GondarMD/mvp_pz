<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\ProductVariantOptionValue;

class ProductVariantOption extends Model
{
    protected $fillable = [
        'product_variant_id',
        'attribute', // e.g., 'size', 'color'
        'label', // e.g., 'Size', 'Color' - used in UI for display
    ];

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function optionValues()
    {
        return $this->hasMany(ProductVariantOptionValue::class);
    }
}
