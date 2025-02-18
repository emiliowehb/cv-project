<?php

use App\Enums\MonthEnum;
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
        Schema::create('professor_book_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('professor_id');
            $table->unsignedBigInteger('reviewed_medium_id');
            $table->integer('year');
            $table->enum('month', MonthEnum::values())->nullable();
            $table->text('name');
            $table->text('periodical_title');
            $table->text('reviewed_work_authors')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('intellectual_contribution_id');

            $table->foreign('professor_id')->references('id')->on('professors')->onDelete('cascade');
            $table->foreign('reviewed_medium_id')->references('id')->on('reviewed_media')->onDelete('cascade');
            $table->foreign('intellectual_contribution_id')->references('id')->on('intellectual_contributions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professor_book_reviews');
    }
};
