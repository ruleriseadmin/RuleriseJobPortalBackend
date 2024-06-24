<?php

namespace App\Models\Domain\Employer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

#This model is used to specify which employer account a user has access to and the applicable role.
class EmployerAccess extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasRoles;

    protected $guarded = [];
}
