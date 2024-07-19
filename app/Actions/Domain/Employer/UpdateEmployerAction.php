<?php

namespace App\Actions\Domain\Employer;

use Exception;
use App\Supports\HelperSupport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Domain\Employer\Employer;
use App\Models\Domain\Employer\EmployerUser;

class UpdateEmployerAction
{
    public function execute(Employer $employer, EmployerUser $employerUser, array $inputs): bool
    {
        $attributes = HelperSupport::camel_to_snake($inputs);
        DB::beginTransaction();
        try{
            $employerAttributes = collect($attributes)
                ->only([
                    'company_name',
                    'state_city',
                    'number_of_employees',
                    'benefit_offered',
                    'profile_summary',
                    'phone_number',
                    'website',
                ])
                ->merge([
                    'uuid' => str()->uuid(),
                    'email' => $inputs['officialEmail'],
                    'founded_at' => $inputs['companyFounded'],
                    'industry' => $inputs['companyIndustry'],
                ])->toArray();

            $employer->update($employerAttributes);

            $attributes = HelperSupport::camel_to_snake(collect($inputs)->only([
                'positionTitle',
                'firstName',
                'lastName'
            ])->toArray());

            $employerUser->employerAccess()->first()->update($attributes);

            DB::commit();
        }catch(Exception $ex){
            DB::rollBack();
            Log::error("Error @ UpdateEmployerAction: " . $ex->getMessage());
            return false;
        }

        $employerUser->refresh();

        $employer->refresh();

        return true;
    }
}
