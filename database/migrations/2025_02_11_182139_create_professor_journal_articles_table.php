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
        Schema::create('professor_journal_articles', function (Blueprint $table) {
            $table->id();
            $table->integer('year');
            $table->enum('month', MonthEnum::values());
            $table->unsignedBigInteger('journal_article_type_id');
            $table->unsignedBigInteger('publication_status_id');
            $table->unsignedBigInteger('professor_id');
            $table->string('title');
            $table->string('volume')->nullable();
            $table->string('issue')->nullable();
            $table->string('pages')->nullable();
            $table->longText('notes')->nullable();
            $table->unsignedBigInteger('primary_field_id')->nullable();
            $table->unsignedBigInteger('secondary_field_id')->nullable();
            $table->enum('admin_status', ArticleStatusEnum::values())->default(ArticleStatusEnum::WAITING_FOR_VALIDATION);

            $table->foreign('journal_article_type_id')->references('id')->on('journal_article_types');
            $table->foreign('publication_status_id')->references('id')->on('publication_statuses');
            $table->foreign('professor_id')->references('id')->on('professors');
            $table->foreign('primary_field_id')->references('id')->on('publication_primary_fields');
            $table->foreign('secondary_field_id')->references('id')->on('publication_secondary_fields');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professor_journal_articles');
    }
};
