<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariantOption extends Model
{
    protected $fillable = [
        'product_variant_id',
        'attribute_key', // e.g., 'size', 'color'
        'attribute_value', // e.g., 'M', 'Red'
    ];

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
    
    public function getAttributeKey($value)
    {
        return ucfirst($value); // Capitalize the first letter of the attribute key
    }

    public function getAttributeValue($value)
    {
        return ucfirst($value); // Capitalize the first letter of the attribute value
    }

}
