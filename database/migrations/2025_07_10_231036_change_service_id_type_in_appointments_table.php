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
            $table->dropForeign(['service_id']);

            // Now modify the column type
            $table->longText('service_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
              // Revert to unsignedBigInteger
              $table->unsignedBigInteger('service_id')->change();

              // Restore the foreign key constraint (assuming services table)
              $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
        });
    }
};
