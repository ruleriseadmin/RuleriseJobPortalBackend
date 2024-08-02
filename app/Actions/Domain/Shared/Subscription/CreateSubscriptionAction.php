<?php

namespace App\Actions\Domain\Shared\Subscription;

use App\Models\Domain\Shared\Subscription\Subscription;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class CreateSubscriptionAction
{
    public function execute(Model $model, string $planId): ?Subscription
    {
        try{
            $subscription = $model->subscribe($planId);
        }catch(Exception $ex){
            Log::error("Error @ CreateSubscriptionAction - {$ex->getMessage()}");
            return null;
        }

        return $subscription;
    }
}
