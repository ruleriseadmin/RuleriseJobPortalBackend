<?php

namespace App\Actions\Domain\Employer\Subscription;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class SetSubscriptionUsageAction
{
    protected Model $model;

    public function execute(Model $model, string $candidateId): bool
    {
        $this->model = $model;

        $usage = $this->model->subscriptionUsage();

        $cvDownloaded = ! collect($usage->meta)->has('cv_downloaded')
            ? [$candidateId]
            : collect($usage->meta['cv_downloaded'])->push($candidateId);

        try{

            $model->updateSubscriptionUsage(['cv_downloaded' => $cvDownloaded]);
        }catch(Exception $ex){
            Log::error("Error @ SetSubscriptionUsageAction - {$ex->getMessage()}");
            return false;
        }

        return true;
    }
}
