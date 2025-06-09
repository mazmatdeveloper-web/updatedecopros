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
           // Add the column first if it doesn't exist
    if (!Schema::hasColumn('appointments', 'customer_id')) {
        $table->unsignedBigInteger('customer_id')->nullable()->after('cleaner_id');
    } else {
        // Make it nullable if already exists and not nullable
        $table->unsignedBigInteger('customer_id')->nullable()->change();
    }

    // Add foreign key
    $table->foreign('customer_id')
        ->references('id')
        ->on('users')
        ->onDelete('set null');
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
