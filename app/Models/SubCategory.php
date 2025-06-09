<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $fillable = [
        'name',
        'description',
        'category_id',
    ];

    /**
     * Get the category that owns the sub-category.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the products associated with the sub-category.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
