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
        Schema::create('customization_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('name'); // e.g., 'Frame Size'
            $table->enum('type', ['text', 'select', 'boolean', 'number', 'json'])->default('text');
            $table->string('default_value')->nullable(); // Default value for the option
            $table->string('description')->nullable(); // Description of the option
            $table->string('icon')->nullable(); // Optional icon for the option
            $table->string('color')->nullable(); // Optional color for the option
            $table->boolean('is_active')->default(true); // Whether the option is active
            $table->boolean('is_required')->default(false); // Whether this option is required
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customization_options');
    }
};
