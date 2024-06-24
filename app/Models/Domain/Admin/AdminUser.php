<?php

namespace App\Models\Domain\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class AdminUser extends User
{
    use HasFactory;
    use SoftDeletes;
    use HasRoles;

    protected $guarded = [];
}
