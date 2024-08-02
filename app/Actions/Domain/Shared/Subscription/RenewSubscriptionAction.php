<?php

namespace App\Actions\Domain\Shared\Subscription;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;

class RenewSubscriptionAction
{
    public function execute(Model $model)
    {
        try{
            $model->renewSubscription();
        }catch(Exception $ex){
            Log::error("Error @ RenewSubscriptionAction - {$ex->getMessage()}");
        }
    }
}
