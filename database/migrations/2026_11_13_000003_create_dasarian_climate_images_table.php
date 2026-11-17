<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dasarian_climate_images', function (Blueprint $table) {
            $table->id();
            $table->string('category')->default('analisis'); // analisis, prediksi, peluang, lainnya
            $table->string('title');
            $table->string('period_label')->nullable();
            $table->string('image_path');
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dasarian_climate_images');
    }
};
