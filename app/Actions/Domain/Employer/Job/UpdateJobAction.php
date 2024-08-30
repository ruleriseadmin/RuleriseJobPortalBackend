<?php

namespace App\Actions\Domain\Employer\Job;

use Exception;
use App\Supports\HelperSupport;
use Illuminate\Support\Facades\Log;
use App\Models\Domain\Employer\EmployerJob;
use App\Models\Domain\Shared\Job\JobCategories;

class UpdateJobAction
{
    public function execute(EmployerJob $employerJob, array $input): ?EmployerJob
    {
        try{
            $category = JobCategories::whereUuid($input['categoryId']);

            $input['category_id'] = $category->id;

            $input['job_industry'] = $category->name;

            $employerJob->update(HelperSupport::camel_to_snake($input));
        }catch(Exception $ex){
            Log::error("Error @ UpdateJobAction: " . $ex->getMessage());
            return null;
        }

        return $employerJob;
    }
}
