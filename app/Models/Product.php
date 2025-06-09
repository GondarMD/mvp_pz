<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
     protected $fillable = [
        'name',
        'description',
        'price',
        'is_digital',
        'category_id',
        'sub_category_id',
        'base_image_url',
        'thumbnail_image_url',
        'product_video_url',
        'product_pdf_url',
        'product_3d_model_url',
        'product_3d_model_thumbnail_url',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_digital' => 'boolean',
    ];

       /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the sub-category that owns the product.
     */
    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }

    /**
     * Check if the product has a 3D model.
     */
    public function has3DModel(): bool
    {
        return !is_null($this->product_3d_model_url);
    }

    /**
     * Check if the product has additional media (video or PDF).
     */
    public function hasAdditionalMedia(): bool
    {
        return !is_null($this->product_video_url) || !is_null($this->product_pdf_url);
    }


}
