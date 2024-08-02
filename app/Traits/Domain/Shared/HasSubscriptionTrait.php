<?php

namespace App\Traits\Domain\Shared;

use App\Models\Domain\Shared\Subscription\SubscriptionTransaction;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\Domain\Shared\Subscription\Subscription;
use App\Models\Domain\Shared\Subscription\SubscriptionPlan;
use App\Models\Domain\Shared\Subscription\SubscriptionHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait HasSubscriptionTrait
{
    public function subscriptions(): MorphMany
    {
        return $this->morphMany(Subscription::class, 'subscribable');
    }

    public function subscriptionHistories(): MorphMany
    {
        return $this->morphMany(SubscriptionHistory::class, 'subscribable');
    }

    public function activeSubscription()
    {
        return $this->subscriptions->where('active', true)->first();
    }

    public function hasActiveSubscription(): bool
    {
        return (bool) $this->activeSubscription();
    }

    public function subscriptionEnds(): string
    {
        return $this->activeSubscription()?->ends_at;
    }

    public function subscriptionUsage()
    {
        return $this->activeSubscription()?->subscriptionUsage  ;
    }

    public function subscriptionTransactions(): MorphMany
    {
        return $this->morphMany(SubscriptionTransaction::class, 'subscribable');
    }

    public function hasSubscriptionQuota(): bool
    {
        return (bool) $this->subscriptionUsage()?->quota_remaining > 0;
    }

    public function subscribe(string $id, $activateSubscription = true)
    {
        $plan = SubscriptionPlan::find($id);

        match ( $plan->interval ){
            'day' => $period = 'addDays',
            default => $period = null,
        };

        if ( ! $period ) throw new Exception("Invalid plan interval");

        $duration = $plan->duration;

        $endAt = Carbon::now()->$period($duration);

        DB::beginTransaction();
        try{
            $subscription = $this->subscriptions()->create([
                'uuid' => str()->uuid(),
                'subscription_plan_id' => $plan->id,
                'start_at' => Carbon::now(),
                'end_at' => $endAt,
                'active' => $activateSubscription,
            ]);

            $this->subscriptionHistories()->create([
                'uuid' => str()->uuid(),
                'subscription_plan_id' => $plan->id,
                'start_at' => Carbon::now(),
                'end_at' => $endAt,
            ]);

            // create subscription usage if plan has a set quota
            if ( $plan->quota > 0 ){
                $subscription->subscriptionUsage()->create([
                    'uuid' => str()->uuid(),
                    'quota' => $plan->quota,
                    'quota_remaining' => $plan->quota,
                ]);
            }
            DB::commit();
        }catch(Exception $ex){
            DB::rollBack();
            Log::error("Error @ HasSubscriptionTrait::subscribe - {$ex->getMessage()}");
            throw new Exception("Could not subscribe - {$ex->getMessage()}");
        }

        return $subscription;
    }

    public function renewSubscription($rolloverQuota = false)
    {
        if ( ! $this->hasActiveSubscription() ) throw new Exception('No active subscription');

        $activeSubscription = $this->activeSubscription();

        $plan = $activeSubscription->subscriptionPlan;

        match ( $plan->interval ){
            'day' => $period = 'addDays',
            default => $period = null,
        };

        $duration = $plan->duration;

        $endAt = Carbon::now()->$period($duration);

        DB::beginTransaction();
        try{
            $this->subscriptionHistories()->create([
                'uuid' => str()->uuid(),
                'subscription_plan_id' => $plan->id,
                'start_at' => Carbon::now(),
                'end_at' => $endAt,
            ]);

            $activeSubscription->update([
                'end_at' => $endAt,
            ]);

            //check if active subscription has quota
            if ( $activeSubscription->subscriptionUsage ){

                $quotaRemaining = $rolloverQuota
                    ? $plan->quota + $activeSubscription->subscriptionUsage->quota_remaining
                    : $plan->quota;

                $quota = $rolloverQuota
                    ? $plan->quota + $activeSubscription->subscriptionUsage->quota
                    : $plan->quota;

                $quota_used = $rolloverQuota ? $activeSubscription->subscriptionUsage->quota_used : 0;

                $activeSubscription->subscriptionUsage->update([
                    'quota_used' => $quota_used,
                    'quota_remaining' => $quotaRemaining,
                    'quota' => $quota,
                ]);
            }
            DB::commit();
        }catch(Exception $ex){
            DB::rollBack();
            Log::error("Error @ HasSubscriptionTrait::renewSubscription - {$ex->getMessage()}");
            throw new Exception("Could not renew subscription - {$ex->getMessage()}");
        }
    }

    public function updateSubscriptionUsage(array $meta = null)
    {
        $subscriptionUsage = $this->subscriptionUsage();

        if ( ! $subscriptionUsage ) return;

        try{
            $subscriptionUsage->update([
                'meta' => $meta,
                'quota_used' => $subscriptionUsage->quota_used + 1,
                'quota_remaining' => $subscriptionUsage->quota_remaining - 1,
            ]);
        }catch(Exception $ex){
            throw new Exception("Could not update subscription usage - {$ex->getMessage()}");
        }
    }
}
