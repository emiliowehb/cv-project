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
        Schema::create('professor_courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('professor_id');
            $table->string('code');
            $table->string('title');
            $table->unsignedBigInteger('language_id');
            $table->unsignedBigInteger('course_level_id');
            $table->unsignedBigInteger('course_type_id');
            $table->unsignedBigInteger('course_credit_id');
            $table->unsignedBigInteger('course_category_id');
            $table->unsignedBigInteger('course_program_id');
            $table->unsignedBigInteger('course_topic_id');
            $table->boolean('is_graduate')->nullable();

            $table->foreign('professor_id')->references('id')->on('professors');
            $table->foreign('language_id')->references('id')->on('languages');
            $table->foreign('course_level_id')->references('id')->on('course_levels');
            $table->foreign('course_type_id')->references('id')->on('course_types');
            $table->foreign('course_credit_id')->references('id')->on('course_credits');
            $table->foreign('course_category_id')->references('id')->on('course_categories');
            $table->foreign('course_program_id')->references('id')->on('course_programs');
            $table->foreign('course_topic_id')->references('id')->on('course_topics');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professor_courses');
    }
};
