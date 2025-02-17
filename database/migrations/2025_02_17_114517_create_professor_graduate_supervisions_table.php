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
        Schema::create('professor_graduate_supervisions', function (Blueprint $table) {
            $table->id();
            $table->text('student_first_name');
            $table->text('student_last_name');
            $table->unsignedBigInteger('professor_id');
            $table->integer('start_year');
            $table->enum('start_month', MonthEnum::values());
            $table->integer('end_year')->nullable();
            $table->enum('end_month', MonthEnum::values())->nullable();
            $table->text('student_program_area');
            $table->text('student_program_name');
            $table->unsignedBigInteger('study_program_id');
            $table->unsignedBigInteger('supervision_status_id');
            $table->unsignedBigInteger('supervision_role_id');

            $table->boolean('is_undergraduate')->default(false);
            $table->boolean('is_graduate')->default(false);
            $table->boolean('is_doctoral')->default(false);

            $table->foreign('professor_id')->references('id')->on('professors')->onDelete('cascade');
            $table->foreign('study_program_id')->references('id')->on('study_programs')->onDelete('cascade');
            $table->foreign('supervision_status_id')->references('id')->on('supervision_statuses')->onDelete('cascade');
            $table->foreign('supervision_role_id')->references('id')->on('supervision_roles')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professor_graduate_supervisions');
    }
};
