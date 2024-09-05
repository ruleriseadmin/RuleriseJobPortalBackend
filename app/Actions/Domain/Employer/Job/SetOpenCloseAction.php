<?php

namespace App\Actions\Domain\Employer\Job;

use App\Models\Domain\Employer\EmployerJob;
use Exception;
use Illuminate\Support\Facades\Log;

class SetOpenCloseAction
{
    public function execute(EmployerJob $employerJob): bool
    {
        try{
            $employerJob->update([
                'active' => ! $employerJob->active,
            ]);
            return true;
        }catch(Exception $ex){
            Log::error('Error @ SetOpenCloseAction: ' . $ex->getMessage());
            return false;
        }
    }
}
