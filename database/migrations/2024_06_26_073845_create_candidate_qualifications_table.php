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
        Schema::create('candidate_qualifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('highest_qualification')->nullable();
            $table->string('year_of_experience')->nullable();
            $table->string('prefer_job_industry')->nullable();
            $table->boolean('available_to_work')->default(false);
            $table->json('skills')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->on('users')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_qualifications');
    }
};
