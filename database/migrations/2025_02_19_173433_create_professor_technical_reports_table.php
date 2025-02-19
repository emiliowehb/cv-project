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
        Schema::create('professor_technical_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('professor_id');
            $table->integer('year');
            $table->enum('month', MonthEnum::values())->nullable();
            $table->unsignedBigInteger('publisher_id');
            $table->text('identifying_number')->nullable();
            $table->text('volume')->nullable();
            $table->text('nb_pages')->nullable();
            $table->unsignedBigInteger('work_classification_id');
            $table->unsignedBigInteger('research_area_id');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('publication_status_id');
            $table->unsignedBigInteger('intellectual_contribution_id');

            $table->foreign('professor_id')->references('id')->on('professors')->onDelete('cascade');
            $table->foreign('publisher_id')->references('id')->on('publishers')->onDelete('cascade');
            $table->foreign('work_classification_id')->references('id')->on('work_classifications')->onDelete('cascade');
            $table->foreign('research_area_id')->references('id')->on('research_areas')->onDelete('cascade');
            $table->foreign('publication_status_id')->references('id')->on('publication_statuses')->onDelete('cascade');
            $table->foreign('intellectual_contribution_id')->references('id')->on('intellectual_contributions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professor_technical_reports');
    }
};
