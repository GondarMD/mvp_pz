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
        Schema::create('customization_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customization_option_id')->constrained()->onDelete('cascade');
            $table->string('label')->default(''); // e.g., 'Large', 'Red'
            $table->string('value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customization_values');
    }
};
