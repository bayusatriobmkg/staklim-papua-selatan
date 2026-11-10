<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('malaria_observations', function (Blueprint $table) {
            $table->id();
            $table->string('district', 80);
            $table->string('period', 7);
            $table->unsignedInteger('cases')->nullable();
            $table->decimal('humidity', 7, 2)->nullable();
            $table->decimal('temperature', 6, 2)->nullable();
            $table->decimal('rainfall', 8, 2)->nullable();
            $table->timestamps();
            $table->unique(['district', 'period']);
            $table->index('period');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('malaria_observations');
    }
};
