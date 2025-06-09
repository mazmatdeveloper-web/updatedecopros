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
            $table->unsignedBigInteger('beds_area_sqft_id')->nullable();
            $table->unsignedBigInteger('baths_area_sqft_id')->nullable();
            $table->unsignedBigInteger('service_id')->nullable();
        
            // Add foreign key constraints
            $table->foreign('beds_area_sqft_id')
                  ->references('id')
                  ->on('beds_area_sqfts')
                  ->onDelete('set null');
        
            $table->foreign('baths_area_sqft_id')
                  ->references('id')
                  ->on('baths_area_sqfts')
                  ->onDelete('set null');
        
            $table->foreign('service_id')
                  ->references('id')
                  ->on('services')
                  ->onDelete('set null');
        
            // Other fields
            $table->json('addon_ids')->nullable(); 
            $table->string('discount_label')->nullable();
            $table->decimal('discount_price', 8, 2)->default(0);
            $table->decimal('total_price', 8, 2);
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            //
        });
    }
};
