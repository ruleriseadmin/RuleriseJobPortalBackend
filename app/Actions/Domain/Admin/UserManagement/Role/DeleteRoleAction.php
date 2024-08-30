<?php

namespace App\Actions\Domain\Admin\UserManagement\Role;

use App\Models\Domain\Admin\AdminUser;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class DeleteRoleAction
{
    public function execute(Role $role) : bool
    {
        if ( $role->name == 'super_admin' ) return true;

        DB::beginTransaction();
        try{
            //get all users with role
            $users = AdminUser::role($role->name)->get();

            //remove the role from user
            $users->map(fn($user) => $user->removeRole($role->name));

            //delete role
            $role->delete();

            DB::commit();

            return true;
        }catch(Exception $ex){
            DB::rollBack();
            Log::error("Error deleting role: " . $ex->getMessage());
            return false;
        }
    }
}
