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
        Schema::dropIfExists('beds_area_sqfts');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('beds_area_sqfts', function ($table) {
            $table->id();
            // Add your table columns here
            $table->timestamps();
        });
    }
};
