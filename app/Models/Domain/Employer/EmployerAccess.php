<?php

namespace App\Models\Domain\Employer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

#This pivot is used to specify which employer account a user has access to and the applicable role.
class EmployerAccess extends Pivot
{
    use HasFactory;
    use SoftDeletes;
    use HasRoles;

    protected $table = 'employer_accesses';

    protected $guard_name = ['employer'];

    protected $guarded = [];

    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    public function employerUser()
    {
        return $this->belongsTo(EmployerUser::class);
    }
}
