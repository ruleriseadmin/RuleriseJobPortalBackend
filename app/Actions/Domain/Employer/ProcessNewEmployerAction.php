<?php

namespace App\Actions\Domain\Employer;

use App\Actions\Domain\Employer\Template\JobNotificationTemplate\ProcessDefaultNotificationTemplateAction;
use App\Models\Domain\Employer\Employer;
use App\Models\Domain\Employer\EmployerUser;
use App\Supports\HelperSupport;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ProcessNewEmployerAction
{
    public function execute(array $inputs) : ? EmployerUser
    {
        $attributes = HelperSupport::camel_to_snake($inputs);

        DB::beginTransaction();
        try {
            //create new employer
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

            $employer = Employer::create($employerAttributes);

            //create new employer user
            $employerUser = EmployerUser::create([
                'uuid' => str()->uuid(),
                'email' => $inputs['email'],
                'password' => Hash::make($inputs['password']),
            ]);

            //create new employer access
            (new AttachUserToEmployerAction)->execute($employer, $employerUser, $inputs);

            //create default job notification template
            (new ProcessDefaultNotificationTemplateAction)->execute($employer);

            //upload company logo
            (new UploadLogoAction)->execute($employer, [
                'imageExtension' => $inputs['logo']['imageExtension'],
                'imageInBase64' => $inputs['logo']['imageInBase64'],
            ]);
            DB::commit();
        }catch(Exception $e) {
            DB::rollBack();
            Log::error("Error @ ProcessNewEmployerAction: " . $e->getMessage());
            return null;
        }

        return $employerUser;
    }
}
