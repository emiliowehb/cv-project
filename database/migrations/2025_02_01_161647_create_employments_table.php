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
        Schema::create('employments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('professor_id');
            $table->text('employer');
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('position_id');
            $table->integer('start_year');
            $table->integer('end_year')->nullable();
            $table->boolean('is_current')->default(false);
            $table->boolean('is_full_time')->default(false);

            $table->foreign('professor_id')->references('id')->on('professors');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('position_id')->references('id')->on('positions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employments');
    }
};
