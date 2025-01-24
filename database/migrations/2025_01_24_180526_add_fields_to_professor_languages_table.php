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
        Schema::table('professor_languages', function (Blueprint $table) {
            $table->unsignedBigInteger('spoken_language_level_id')->after('language_id');
            $table->unsignedBigInteger('written_language_level_id')->after('spoken_language_level_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('professor_languages', function (Blueprint $table) {
            //
        });
    }
};
