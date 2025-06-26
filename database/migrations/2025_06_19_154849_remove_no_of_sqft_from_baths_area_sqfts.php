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
        Schema::table('baths_area_sqfts', function (Blueprint $table) {
            $table->dropColumn('no_of_sqft');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('baths_area_sqfts', function (Blueprint $table) {
            //
        });
    }
};
