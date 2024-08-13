<?php

namespace App\Actions\Domain\Candidate\Job;

use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\Domain\Employer\EmployerJob;

class IncrementJobViewCountAction
{
    public function execute(EmployerJob $job, string $viaBy = 'view_count')
    {
        try{
            $view = $job->jobViewCounts()->whereDate('created_at', Carbon::now())->first();

            $view = $view
                ? $view->update([$viaBy => $view->$viaBy + 1])
                : $job->jobViewCounts()->create([
                    $viaBy => 1,
                    'employer_id' => $job->employer->id,
                ]);
        }catch(Exception $ex){
            Log::error("Error @ IncrementJobViewCountAction: " . $ex->getMessage());
            throw new Exception("Could not increment job view count - {$ex->getMessage()}");
        }
    }
}
