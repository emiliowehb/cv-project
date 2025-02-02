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
        Schema::create('professor_degrees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('professor_id');
            $table->integer('year');
            $table->unsignedBigInteger('degree_id');
            $table->unsignedBigInteger('discipline_id');
            $table->unsignedBigInteger('department_id');

            $table->foreign('professor_id')->references('id')->on('professors');
            $table->foreign('degree_id')->references('id')->on('degrees');
            $table->foreign('discipline_id')->references('id')->on('disciplines');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professor_degrees');
    }
};
