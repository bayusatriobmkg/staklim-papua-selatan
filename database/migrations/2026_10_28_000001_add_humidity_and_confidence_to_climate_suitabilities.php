<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('climate_suitabilities', function (Blueprint $table) {
            $table->decimal('humidity', 5, 2)->nullable()->after('probability');
            $table->string('confidence', 20)->nullable()->after('humidity');
        });
    }

    public function down(): void
    {
        Schema::table('climate_suitabilities', function (Blueprint $table) {
            $table->dropColumn(['humidity', 'confidence']);
        });
    }
};
