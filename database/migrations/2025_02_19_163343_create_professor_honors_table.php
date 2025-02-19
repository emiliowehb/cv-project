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
        Schema::create('professor_honors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('professor_id');
            $table->unsignedBigInteger('honor_type_id');
            $table->unsignedBigInteger('honor_organization_id');
            $table->string('name');
            $table->integer('start_year');
            $table->integer('end_year')->nullable();
            $table->boolean('is_ongoing');
            $table->string('notes')->nullable();

            $table->foreign('professor_id')->references('id')->on('professors')->onDelete('cascade');
            $table->foreign('honor_type_id')->references('id')->on('honor_types')->onDelete('cascade');
            $table->foreign('honor_organization_id')->references('id')->on('honor_organizations')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professor_honors');
    }
};
