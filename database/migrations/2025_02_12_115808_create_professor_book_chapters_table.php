<?php

use App\Enums\ArticleStatusEnum;
use App\Enums\MonthEnum;
use App\Models\IntellectualContribution;
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
        Schema::create('professor_book_chapters', function (Blueprint $table) {
            $intellectual_contribution = IntellectualContribution::where('name', 'None')->firstOrFail();
            $table->id();
            $table->integer('published_year');
            $table->enum('published_month', MonthEnum::values());
            $table->unsignedBigInteger('book_type_id');
            $table->unsignedBigInteger('professor_id');
            $table->unsignedBigInteger('work_classification_id');
            $table->string('book_name');
            $table->text('chapter_title');
            $table->string('volume')->nullable();
            $table->unsignedBigInteger('research_area_id');
            $table->integer('nb_pages')->nullable();
            $table->unsignedBigInteger('publisher_id');
            $table->enum('admin_status', ArticleStatusEnum::values())->default(ArticleStatusEnum::WAITING_FOR_VALIDATION->value);
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('intellectual_contribution_id')->default($intellectual_contribution->id);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professor_book_chapters');
    }
};
