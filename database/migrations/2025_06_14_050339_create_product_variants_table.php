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
       Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->decimal('variant_price', 10, 2)->default(0.00);
            $table->string('sku')->unique()->nullable();
            $table->string('barcode')->unique()->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->string('image_url')->nullable();
            $table->string('thumbnail_image_url')->nullable();
            $table->json('variant_image_urls')->nullable(); // JSON column for image gallery URLs
            $table->string('video_url')->nullable();
            $table->string('pdf_url')->nullable();
            $table->string('3d_model_url')->nullable();
            $table->string('3d_model_thumbnail_url')->nullable();
            $table->boolean('is_digital')->default(false); // Indicates if the variant is a digital product
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);
            $table->json('variant_attributes')->nullable(); // JSON column for variant attribute descriptions only, i.e. the keys of the attributes that define this variant (e.g., size, color). The actual attribute values are stored in the `product_variant_optionx` table.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
