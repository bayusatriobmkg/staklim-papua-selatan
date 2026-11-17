<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('climate_early_warnings', function (Blueprint $table) {
            $table->id();
            $table->string('category', 32); // 'kekeringan' or 'hujan_lebat'
            $table->string('district', 64); // 'Asmat', 'Boven Digoel', 'Mappi', 'Merauke'
            $table->string('status', 32)->default('tidak_ada'); // 'tidak_ada', 'waspada', 'siaga', 'awas'
            $table->text('waspada_areas')->nullable();
            $table->text('siaga_areas')->nullable();
            $table->text('awas_areas')->nullable();
            $table->text('description')->nullable();
            $table->string('period', 64)->nullable(); // e.g. 'Dasarian II November 2026'
            $table->timestamps();

            $table->unique(['category', 'district', 'period']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('climate_early_warnings');
    }
};
