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
        Schema::table('cleaners', function (Blueprint $table) {
            
             $table->unsignedBigInteger('user_id')->after('id');
             $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
             $table->string('phone')->nullable();
             $table->text('bio')->nullable();
             $table->string('profile_picture')->nullable(); // path to image
             $table->decimal('price', 8, 2); // cleaner's rate, e.g., 99.99
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cleaners', function (Blueprint $table) {
            //
        });
    }
};
