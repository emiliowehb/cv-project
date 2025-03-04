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
        Schema::create('reviewables', function (Blueprint $table) {
            $table->id();
            $table->string('reviewable_type');
            $table->enum('status', ArticleStatusEnum::values())->default(ArticleStatusEnum::WAITING_FOR_VALIDATION);
            $table->unsignedBigInteger('type_id')->nullable();
            $table->unsignedBigInteger('reviewable_id');
            $table->text('reason')->nullable();
            $table->timestamps();
            $table->index(['model', 'reviewable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviewables');
    }
};
