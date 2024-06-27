<?php

namespace App\Models\Domain\Candidate;

use App\Models\User as ModelsUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends ModelsUser
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'first_name',
        'last_name',
        'email',
        'password',
        'mobile_number',
        'mobile_country_code',
        'nationality',
        'location_province',
    ];

    public function qualification(): HasOne
    {
        return $this->hasOne(CandidateQualification::class);
    }
}
