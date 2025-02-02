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
        Schema::create('professor_teaching_interests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('professor_id');
            $table->unsignedBigInteger('teaching_interest_id');
            $table->boolean('is_current')->default(false);

            $table->foreign('professor_id')->references('id')->on('professors');
            $table->foreign('teaching_interest_id')->references('id')->on('teaching_interests');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professor_teaching_interests');
    }
};
