<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_customizations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('label');
            $table->string('type'); // text, textarea, file
            $table->boolean('required')->default(false);
            $table->string('placeholder')->nullable(); // Placeholder text for text/textarea fields
            $table->string('default_value')->nullable(); // Default value for text/textarea fields
            $table->string('file_type')->nullable(); // Allowed file types for file uploads (e.g., 'image/*', 'application/pdf')
            $table->integer('max_file_size')->nullable(); // Maximum file size in KB for file uploads
            $table->boolean('is_active')->default(true); // Whether the customization is active
            $table->json('options')->nullable(); // JSON column for additional options (e.g., dropdown choices)
            $table->string('validation_rules')->nullable(); // Validation rules for the customization (e.g., 'required|max:255')
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_customizations');
    }
};
