<?php

use App\Enums\ArticleStatusEnum;
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
        Schema::create('professor_articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('professor_id');
            $table->unsignedBigInteger('article_type_id');
            $table->string('title');
            $table->string('publisher_name');
            $table->integer('year');
            $table->string('nb_pages')->nullable();
            $table->enum('admin_status', ArticleStatusEnum::values())->default(ArticleStatusEnum::WAITING_FOR_VALIDATION);
            $table->text('url')->nullable();
            $table->string('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professor_articles');
    }
};
