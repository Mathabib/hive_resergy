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
      
Schema::create('theme_settings', function (Blueprint $table) {
    $table->id();
    $table->string('sidebar_color')->nullable();
    $table->string('sidebar_theme')->nullable();
    $table->string('navbar_color')->nullable();
    $table->string('navbar_theme')->nullable();
    $table->string('footer_color')->nullable();
    $table->string('footer_theme')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('theme_settings');
    }
};
