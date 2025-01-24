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
        Schema::create('professor_languages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('professor_id');
            $table->unsignedBigInteger('language_id');

            $table->foreign('professor_id')->references('id')->on('professors');
            $table->foreign('language_id')->references('id')->on('languages');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professor_languages');
    }
};
