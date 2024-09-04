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
        Schema::table('employer_jobs', function (Blueprint $table) {
            $table->boolean('is_draft')->default(false)->after('active');
            $table->string('salary_payment_mode')->nullable()->after('salary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employer_jobs', function (Blueprint $table) {
            //
        });
    }
};
