<?php

namespace App\Models\Domain\Employer;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployerUser extends User
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function employers()
    {
        return $this->belongsToMany(Employer::class, 'employer_accesses')
            ->withPivot(['position_title', 'first_name', 'last_name'])
            ->using(EmployerAccess::class);
    }

    public function getCurrentEmployerAccess(string $currentEmployerId) : ?EmployerAccess
    {
        return $this->employerAccess()->where('employer_id', $currentEmployerId)->first();
    }

    public function employerAccess(): HasMany
    {
        return $this->hasMany(EmployerAccess::class);
    }

    public static function whereEmail(string $email)
    {
        return self::query()->where('email', $email)->first();
    }
}
