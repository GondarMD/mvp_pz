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


    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function customizations()
    {
        return $this->hasMany(ProductCustomization::class);
    }

    public function getBaseImageUrlAttribute($value)
    {
        return $value ? asset($value) : null; // Ensure the URL is absolute
    }

    public function getThumbnailImageUrlAttribute($value)
    {
        return $value ? asset($value) : null; // Ensure the URL is absolute
    }

    public function getProductVideoUrlAttribute($value)
    {
        return $value ? asset($value) : null; // Ensure the URL is absolute
    }

    public function getProductPdfUrlAttribute($value)
    {
        return $value ? asset($value) : null; // Ensure the URL is absolute
    }

    public function getProduct3DModelUrlAttribute($value)
    {
        return $value ? asset($value) : null; // Ensure the URL is absolute
    }

    public function getProduct3DModelThumbnailUrlAttribute($value)
    {
        return $value ? asset($value) : null; // Ensure the URL is absolute
    }

    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 2); // Format price to 2 decimal places
    }

    public function getIsDigitalAttribute($value)
    {
        return (bool) $value; // Ensure is_digital is always a boolean
    }

    public function getIsActiveAttribute($value)
    {
        return (bool) $value; // Ensure is_active is always a boolean
    }

    public function getIsDefaultAttribute($value)
    {
        return (bool) $value; // Ensure is_default is always a boolean
    }

    public function getDescriptionAttribute($value)
    {
        return $value ? nl2br(e($value)) : ''; // Convert newlines to <br> tags for HTML display
    }

    public function getNameAttribute($value)
    {
        return ucfirst($value); // Capitalize the first letter of the product name
    }

    public function getCategoryNameAttribute()
    {
        return $this->category ? $this->category->name : 'Uncategorized';
    }

    public function getSubCategoryNameAttribute()
    {
        return $this->subCategory ? $this->subCategory->name : 'No Sub-Category';
    }

    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at ? $this->created_at->format('Y-m-d H:i:s') : null; // Format created_at for display
    }

    public function getFormattedUpdatedAtAttribute()
    {
        return $this->updated_at ? $this->updated_at->format('Y-m-d H:i:s') : null; // Format updated_at for display
    }

    public function getImageUrlAttribute()
    {
        return $this->base_image_url ?: $this->thumbnail_image_url; // Fallback to thumbnail if base image is not set
    }

    public function getVideoUrlAttribute()
    {
        return $this->product_video_url; // Return the product video URL
    }

    public function getPdfUrlAttribute()
    {
        return $this->product_pdf_url; // Return the product PDF URL
    }

    public function get3DModelUrlAttribute()
    {
        return $this->product_3d_model_url; // Return the product 3D model URL
    }

    public function get3DModelThumbnailUrlAttribute()
    {
        return $this->product_3d_model_thumbnail_url; // Return the product 3D model thumbnail URL
    }
    
}
