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
        Schema::table('employer_users', function (Blueprint $table) {
            $table->dropUnique(['email']);
            $table->unique(['email', 'deleted_at'], 'unique_email_not_deleted');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employer_users', function (Blueprint $table) {
            //
        });
    }
};
