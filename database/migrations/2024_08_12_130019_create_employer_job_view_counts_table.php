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
        Schema::create('employer_job_view_counts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employer_id');
            $table->unsignedBigInteger('employer_job_id');
            $table->integer('view_count')->default(0);
            $table->integer('apply_count')->default(0);
            $table->timestamps();
            $table->foreign('employer_id')->on('employers')->references('id');
            $table->foreign('employer_job_id')->on('employer_jobs')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employer_job_view_counts');
    }
};
