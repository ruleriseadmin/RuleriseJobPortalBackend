<?php

namespace App\Actions\Domain\Employer\Job;

use Exception;
use App\Supports\HelperSupport;
use Illuminate\Support\Facades\Log;
use App\Models\Domain\Employer\EmployerJob;

class UpdateJobAction
{
    public function execute(EmployerJob $employerJob, array $input): ?EmployerJob
    {
        try{
            $employerJob->update(HelperSupport::camel_to_snake($input));
        }catch(Exception $ex){
            Log::error("Error @ UpdateJobAction: " . $ex->getMessage());
            return null;
        }

        return $employerJob;
    }
}
