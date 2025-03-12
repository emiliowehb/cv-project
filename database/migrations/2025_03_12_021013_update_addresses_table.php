<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('addresses', function (Blueprint $table)
        {
            $table->dropColumn('country');
        });

        Schema::table('addresses', function (Blueprint $table)
        {
            $table->unsignedBigInteger('country_id')->after('state')->default(76);
            $table->foreign('country_id')->references('id')->on('countries');
        });

        DB::table('addresses')->where('id', 2)->update(['country_id' => 39]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
