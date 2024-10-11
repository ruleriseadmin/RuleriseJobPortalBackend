<?php

namespace App\Actions\Domain\Admin\UserManagement\User;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\Domain\Admin\AdminUser;
use Spatie\Permission\Models\Role;

class UpdateUserAction
{
    public function execute(AdminUser $user, array $inputs)
    {
        $mainSystemAdmin = AdminUser::first();

        DB::beginTransaction();
        try{
            $user->update([
                'first_name' => $inputs['firstName'],
                'last_name' => $inputs['lastName'],
                'email' => $inputs['email'],
                'password' => $inputs['password'] ? Hash::make($inputs['password']) : $user->password,
            ]);

            if($user->id != $mainSystemAdmin->id){
                $user->assignRole($inputs['role']);
            }

            $permissions = [];//Role::whereName($inputs['role'])->first()->permissions->pluck('name');

            //$input['permissions'] ??

            $user->syncPermissions( $permissions ?? []);
            // if ( collect($inputs)->has('permissions') ) {
            //     $user->syncPermissions($inputs['permissions']);
            // }

            DB::commit();

            return true;
        }catch(Exception $ex){
            DB::rollBack();
            Log::error("Error @ UpdateUserAction : " . $ex->getMessage());
            return false;
        }
    }
}
