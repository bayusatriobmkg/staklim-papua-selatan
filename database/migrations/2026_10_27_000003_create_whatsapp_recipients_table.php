<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_recipients', function (Blueprint $table) {
            $table->id();
            $table->string('district', 80);
            $table->string('name', 120);
            $table->string('phone', 20);
            $table->timestamps();
            $table->unique(['district', 'phone']);
            $table->index(['district', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_recipients');
    }
};
