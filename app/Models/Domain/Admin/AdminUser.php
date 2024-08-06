<?php

namespace App\Models\Domain\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminUser extends User
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
}
