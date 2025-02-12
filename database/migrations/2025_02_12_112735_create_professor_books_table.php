<?php

use App\Enums\ArticleStatusEnum;
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
        Schema::create('professor_books', function (Blueprint $table) {
            $table->id();
            $table->integer('year');
            $table->enum('month', MonthEnum::values());
            $table->unsignedBigInteger('book_type_id');
            $table->unsignedBigInteger('professor_id');
            $table->unsignedBigInteger('work_classification_id');
            $table->text('name');
            $table->text('volume')->nullable();
            $table->unsignedBigInteger('research_area_id');
            $table->integer('nb_pages')->nullable();
            $table->unsignedBigInteger('publisher_id');
            $table->unsignedBigInteger('publication_status_id');
            $table->unsignedBigInteger('primary_field_id');
            $table->unsignedBigInteger('secondary_field_id');
            $table->enum('admin_status', ArticleStatusEnum::values())->default(ArticleStatusEnum::WAITING_FOR_VALIDATION);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professor_books');
    }
};
