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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->boolean('is_digital')->default(false);
            $table->foreignId('category_id')->constrained();
            $table->foreignId('sub_category_id')->nullable()->constrained();
            $table->string('base_image_url')->nullable();
            $table->string('thumbnail_image_url')->nullable();
            $table->string('product_video_url')->nullable();
            $table->string('product_pdf_url')->nullable();
            $table->string('product_3d_model_url')->nullable();
            $table->string('product_3d_model_thumbnail_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
