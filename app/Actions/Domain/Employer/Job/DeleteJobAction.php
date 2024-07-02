<?php

namespace App\Actions\Domain\Employer\Job;

use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\Domain\Employer\EmployerJob;

class DeleteJobAction
{
    public function execute(EmployerJob $employerJob): bool
    {
        try{
            $employerJob->delete();
        }catch(Exception $ex){
            Log::error("Error @ DeleteJobAction: " . $ex->getMessage());
            return false;
        }

        return true;
    }
}
