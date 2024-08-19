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
            $table->string('number_vacancy')->nullable()->after('required_skills');
            $table->dateTime('application_expiry')->nullable()->after('required_skills');
            $table->string('language_required')->nullable()->after('required_skills');
            $table->string('email_to_apply')->nullable()->after('required_skills');
            $table->string('career_level')->nullable()->after('required_skills');
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
