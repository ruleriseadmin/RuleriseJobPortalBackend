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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->unsignedBigInteger('subscription_plan_id');
            $table->morphs('subscribable');
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->json('meta')->nullable();
            $table->boolean('active')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('subscription_plan_id')->on('subscription_plans')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
