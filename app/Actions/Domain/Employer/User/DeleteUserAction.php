<?php

namespace App\Actions\Domain\Employer\User;

use App\Models\Domain\Admin\AdminUser;
use App\Models\Domain\Employer\Employer;
use App\Models\Domain\Employer\EmployerUser;

class DeleteUserAction
{
    public function execute(Employer $employer, EmployerUser $user)
    {
        return $user->getCurrentEmployerAccess($employer->id)->delete();
    }
}
