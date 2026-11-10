<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('malaria_observations', function (Blueprint $table) {
            $table->decimal('humidity', 10, 8)->nullable()->change();
            $table->decimal('temperature', 10, 8)->nullable()->change();
            $table->decimal('rainfall', 12, 8)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('malaria_observations', function (Blueprint $table) {
            $table->decimal('humidity', 7, 2)->nullable()->change();
            $table->decimal('temperature', 6, 2)->nullable()->change();
            $table->decimal('rainfall', 8, 2)->nullable()->change();
        });
    }
};
