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
        Schema::create('professor_interviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('professor_id');
            $table->longText('name');
            $table->unsignedBigInteger('type_id');
            $table->text('source')->nullable();
            $table->text('notes')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();

            $table->foreign('professor_id')->references('id')->on('professors')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('interview_types')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professor_interviews');
    }
};
