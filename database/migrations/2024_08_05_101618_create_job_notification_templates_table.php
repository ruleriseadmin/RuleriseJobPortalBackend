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
        Schema::create('job_notification_templates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employer_id');
            $table->json('rejected_template')->nullable();
            $table->json('shortlisted_template')->nullable();
            $table->json('offer_sent_template')->nullable();
            $table->timestamps();
            $table->foreign('employer_id')->on('employers')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_notification_templates');
    }
};
