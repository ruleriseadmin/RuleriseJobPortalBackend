<?php

namespace App\Actions\Domain\Employer\Job;

use Exception;
use App\Supports\HelperSupport;
use App\Models\Domain\Employer\EmployerJob;
use Illuminate\Support\Facades\Log;
use App\Models\Domain\Employer\Employer;
use App\Models\Domain\Shared\Job\JobCategories;

class CreateJobAction
{
    public function execute(Employer $employer, array $input): ?EmployerJob
    {
        try{
            $input['uuid'] = str()->uuid();

            $category = JobCategories::whereUuid($input['categoryId']);

            $input['category_id'] = $category->id;

            $input['job_industry'] = $category->name;

            $job = $employer->jobs()->create(HelperSupport::camel_to_snake($input));
        }catch(Exception $ex){
            Log::error('Error @ CreateJobAction: ' . $ex->getMessage());
            return null;
        }

        return $job;
    }
}
