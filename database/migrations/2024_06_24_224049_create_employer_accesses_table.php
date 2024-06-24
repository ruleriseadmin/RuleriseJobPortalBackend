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
        Schema::create('employer_accesses', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->unsignedBigInteger('employer_id');
            $table->unsignedBigInteger('employer_user_id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('employer_id')->on('employers')->references('id');
            $table->foreign('employer_user_id')->on('employer_users')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employer_accesses');
    }
};
