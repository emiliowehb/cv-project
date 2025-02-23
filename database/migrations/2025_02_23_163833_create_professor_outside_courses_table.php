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
        Schema::create('professor_outside_courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('professor_id');
            $table->unsignedBigInteger('session_id');
            $table->string('name');
            $table->string('institution');
            $table->integer('year');
            $table->unsignedBigInteger('country_id');
            $table->text('town')->nullable();
            $table->unsignedBigInteger('language_id');
            $table->boolean('is_graduate')->default(false);
            $table->text('notes')->nullable();

            $table->foreign('professor_id')->references('id')->on('professors')->onDelete('cascade');
            $table->foreign('session_id')->references('id')->on('sessions')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professor_outside_courses');
    }
};
