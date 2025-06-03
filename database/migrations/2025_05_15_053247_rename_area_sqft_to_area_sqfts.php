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
        Schema::rename('area_sqft', 'area_sqfts');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('area_sqfts', function (Blueprint $table) {
            //
        });
    }
};
