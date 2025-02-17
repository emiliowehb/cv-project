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
        Schema::create('professor_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('professor_id');
            $table->integer('start_year');
            $table->integer('end_year')->nullable();
            $table->unsignedBigInteger('activity_service_id');
            $table->text('name');
            $table->boolean('is_current')->default(false);
            $table->longText('notes')->nullable();

            $table->foreign('professor_id')->references('id')->on('professors')->onDelete('cascade');
            $table->foreign('activity_service_id')->references('id')->on('professional_activity_services')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professor_activities');
    }
};
