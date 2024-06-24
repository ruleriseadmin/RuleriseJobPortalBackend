<?php

namespace App\Supports;

class RoleSupport
{
    public static function getRoles()
    {
        return [
            'super_admin' => 'super_admin',
        ];
    }
}
