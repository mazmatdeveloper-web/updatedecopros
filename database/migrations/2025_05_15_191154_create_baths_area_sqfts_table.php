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
        Schema::create('baths_area_sqfts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cleaner_id');
            $table->foreign('cleaner_id')->references('id')->on('cleaners')->onDelete('cascade');
            $table->string('no_of_sqft');
            $table->integer('baths');
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baths_area_sqfts');
    }
};
