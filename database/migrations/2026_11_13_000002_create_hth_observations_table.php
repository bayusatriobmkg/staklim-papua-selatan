<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hth_observations', function (Blueprint $table) {
            $table->id();
            $table->string('station_name', 128);
            $table->string('district', 64); // 'Asmat', 'Boven Digoel', 'Mappi', 'Merauke'
            $table->string('subdistrict', 64)->nullable();
            $table->decimal('latitude', 10, 6);
            $table->decimal('longitude', 10, 6);
            $table->unsignedInteger('days')->default(0);
            $table->string('classification', 64);
            $table->date('updated_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hth_observations');
    }
};
