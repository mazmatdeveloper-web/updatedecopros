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
        Schema::table('services', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign(['cleaner_id']);

            // Then drop the column
            $table->dropColumn('cleaner_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // Re-add the column
            $table->unsignedBigInteger('cleaner_id')->nullable();

            // Re-add the foreign key constraint (replace 'employees' with actual table if different)
            $table->foreign('cleaner_id')->references('id')->on('employees')->onDelete('set null');
        });
    }
};
