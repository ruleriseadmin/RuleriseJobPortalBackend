<?php

use App\Models\Domain\Shared\Subscription\SubscriptionTransaction;
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
        Schema::create('subscription_transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('reference');
            $table->unsignedBigInteger('subscription_plan_id');
            $table->morphs('subscribable');
            $table->string('status')->default(SubscriptionTransaction::PENDING_STATUS);
            $table->decimal('amount', 10, 2)->default(0.00);
            $table->string('currency')->nullable();
            $table->json('meta')->nullable();
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
        Schema::dropIfExists('subscription_transactions');
    }
};
