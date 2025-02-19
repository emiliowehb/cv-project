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
        Schema::create('professor_presentations', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->integer('year');
            $table->enum('month', MonthEnum::values())->nullable();
            $table->text('days')->nullable();
            $table->text('event_name')->nullable();

            $table->unsignedBigInteger('professor_id');
            $table->unsignedBigInteger('country_id');
            $table->text('town')->nullable();
            $table->boolean('is_published_in_proceedings')->default(false);
            $table->unsignedBigInteger('intellectual_contribution_id');

            $table->foreign('professor_id')->references('id')->on('professors')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('intellectual_contribution_id')->references('id')->on('intellectual_contributions')->onDelete('cascade');

            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professor_presentations');
    }
};
