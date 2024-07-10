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
        Schema::create('candidate_job_pools', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->unsignedBigInteger('employer_id');
            $table->string('name');
            $table->json('candidate_ids')->nullable();
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
        Schema::dropIfExists('candidate_job_pools');
    }
};
