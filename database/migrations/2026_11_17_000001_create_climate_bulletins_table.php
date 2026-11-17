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
        Schema::create('climate_bulletins', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('edition');
            $table->date('release_date')->nullable();
            $table->text('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('file_path')->nullable();
            $table->string('external_link')->nullable();
            $table->integer('page_count')->default(24);
            $table->string('file_size')->nullable();
            $table->boolean('is_published')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('climate_bulletins');
    }
};
