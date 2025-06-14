<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'name',
        'variant_price',
        'sku',
        'barcode',
        'stock_quantity',
        'image_url',
        'thumbnail_image_url',
        'variant_image_urls',
        'video_url',
        'pdf_url',
        '3d_model_url',
        '3d_model_thumbnail_url',
        'is_digital',
        'is_default',
        'is_active',
        'variant_attributes',
        'customization_schema',
    ];

    protected $casts = [
        'variant_image_urls' => 'array',
        'variant_attributes' => 'array',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function options()
    {
        return $this->hasMany(ProductVariantOption::class);
    }
    
}
