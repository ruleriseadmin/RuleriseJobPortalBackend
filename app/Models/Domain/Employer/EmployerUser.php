<?php

namespace App\Models\Domain\Employer;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployerUser extends User
{
    use HasFactory;
    use SoftDeletes;
    
    protected $guarded = [];
}
