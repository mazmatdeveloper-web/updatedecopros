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
        
        Schema::table('appointments', function (Blueprint $table) {
            // First, drop the foreign key constraint
            $table->dropForeign(['beds_area_sqft_id']);

            // Then drop the column
            $table->dropColumn('beds_area_sqft_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Re-add the column
            $table->unsignedBigInteger('beds_area_sqft_id')->nullable();

            // Re-add the foreign key (update the referenced table if needed)
            $table->foreign('beds_area_sqft_id')->references('id')->on('beds_area_sqfts')->onDelete('cascade');
        });
    }
};
