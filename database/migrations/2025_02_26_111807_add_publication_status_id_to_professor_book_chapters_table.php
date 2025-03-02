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
        Schema::table('professor_book_chapters', function (Blueprint $table) {
            $table->unsignedBigInteger('publication_status_id')->nullable()->after('published_month');

            $table->foreign('publication_status_id')->references('id')->on('publication_statuses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('professor_book_chapters', function (Blueprint $table) {
            //
        });
    }
};
