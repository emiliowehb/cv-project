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
        Schema::table('professors', function (Blueprint $table) {
            $table->string('first_name')->after('address_id');
            $table->string('middle_name')->age('first_name')->nullable();
            $table->string('last_name')->after('first_name');
            $table->date('birth_date')->after('last_name')->nullable();
            $table->unsignedBigInteger('country_id')->after('birth_date');
            $table->unsignedBigInteger('gender')->after('birth_date');
            $table->string('email')->after('gender');
            $table->string('office_email')->after('email');
            $table->string('website')->after('office_email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
