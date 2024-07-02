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
        Schema::create('employer_jobs', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->unsignedBigInteger('employer_id');
            $table->string('title');
            $table->text('summary')->nullable();
            $table->longText('description');
            $table->string('job_type')->nullable();
            $table->string('employment_type')->nullable();
            $table->string('job_industry')->nullable();
            $table->string('location')->nullable();
            $table->integer('years_experience')->default(0);
            $table->decimal('salary', 10, 2)->default(0.00);
            $table->boolean('easy_apply')->default(false);
            $table->boolean('email_apply')->default(false);
            $table->boolean('active')->default(false);
            $table->json('required_skills');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('employer_id')->on('employers')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
