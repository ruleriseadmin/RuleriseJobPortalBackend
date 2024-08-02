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
        Schema::create('subscription_usages', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->unsignedBigInteger('subscription_id');
            $table->integer('quota')->default(0);
            $table->integer('quota_used')->default(0);
            $table->integer('quota_remaining')->default(0);
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('subscription_id')->on('subscriptions')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_usages');
    }
};
