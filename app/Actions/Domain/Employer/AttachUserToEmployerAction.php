<?php

namespace App\Actions\Domain\Employer;

use App\Models\Domain\Employer\Employer;
use App\Models\Domain\Employer\EmployerUser;
use App\Supports\HelperSupport;
use Exception;

class AttachUserToEmployerAction
{
    public function execute(Employer $employer, EmployerUser $user, array $inputs, string $role = 'super_admin')
    {
        $attributes = HelperSupport::camel_to_snake(collect($inputs)->only([
            'positionTitle',
            'firstName',
            'lastName'
        ])->toArray());

        $attributes['uuid'] = str()->uuid();

        try{
            $employer->users()->attach($user->id, $attributes);

            $user->getCurrentEmployerAccess($employer->id)->assignRole($role);
        }catch (Exception $e){
            throw new Exception("Error @ AttachUserToEmployerAction: {$e->getMessage()}");
        };
    }
}
