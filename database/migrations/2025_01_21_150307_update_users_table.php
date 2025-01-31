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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('first_name')->after('id');
            $table->string('last_name')->after('first_name');
            $table->unsignedBigInteger('workspace_id')->after('avatar')->nullable();
            $table->unsignedBigInteger('professor_id')->after('workspace_id')->nullable();
            $table->string('third_party_id')->after('professor_id')->nullable();
            $table->string('role')->after('third_party_id')->default('member');
            $table->boolean('is_active')->after('role')->default(true);

            $table->foreign('workspace_id')->references('id')->on('workspaces');
            $table->foreign('professor_id')->references('id')->on('professors');

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
