<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariantOptionValue extends Model
{
    protected $fillable = [
        'product_variant_option_id',
        'attribute', // e.g., 'size', 'color' - corresponds to the option key in ProductVariantOption
        'value', // e.g., 'Small', 'Red'
    ];

    public function productVariantOption()
    {
        return $this->belongsTo(ProductVariantOption::class);
    }

    public function productVariant() {
        return $this->productVariantOption()->productVariant();
    }
}