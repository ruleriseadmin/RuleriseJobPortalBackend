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
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('plan_id')->nullable();
            $table->string('product_id')->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);
            $table->decimal('amount', 18, 2)->nullable();
            $table->string('currency')->nullable();
            $table->string('interval')->nullable();
            $table->integer('interval_count')->nullable();
            $table->integer('trial_period_days')->default(0)->nullable();
            $table->integer('number_of_candidate')->default(0)->nullable();
            $table->string('duration')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};
