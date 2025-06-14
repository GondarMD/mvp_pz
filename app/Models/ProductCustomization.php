<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCustomization extends Model
{
    protected $fillable = [
        'product_id',
        'label',
        'type', // e.g., 'text', 'select', 'checkbox'
        'required',
        'placeholder', // Placeholder text for text/textarea fields
        'default_value', // Default value for text/textarea fields
        'file_type', // Allowed file types for file uploads (e.g., 'image/*', 'application/pdf')
        'max_file_size', // Maximum file size in KB for file uploads
        'is_active', // Whether the customization is active
        'options', // JSON column for additional options (e.g., dropdown choices)
        'validation_rules', // Validation rules for the customization (e.g., 'required|max:255')
    ];

    protected $casts = [
        'options' => 'array', // Cast options to array for easier manipulation
        'is_active' => 'boolean', // Cast is_active to boolean
        'required' => 'boolean', // Cast required to boolean
        'max_file_size' => 'integer', // Cast max_file_size to integer
        'validation_rules' => 'string', // Cast validation_rules to string
        'default_value' => 'string', // Cast default_value to string
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
