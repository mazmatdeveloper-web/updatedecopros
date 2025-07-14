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
            // Drop the foreign key constraint on cleaner_id first
            $table->dropForeign(['cleaner_id']);

            // Rename the column
            $table->renameColumn('cleaner_id', 'employee_id');
        });

        // Re-add foreign key constraint after renaming
        Schema::table('appointments', function (Blueprint $table) {
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['employee_id']);
            $table->renameColumn('employee_id', 'cleaner_id');
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->foreign('cleaner_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }
};
