<?php

namespace App\Models\Domain\Candidate;

use App\Models\User as ModelsUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'dob',
        'gender',
        'profile_summary',
        'job_title',
    ];

    public function qualification(): HasOne
    {
        return $this->hasOne(CandidateQualification::class);
    }

    public function workExperiences(): HasMany
    {
        return $this->hasMany(CandidateWorkExperience::class);
    }

    public function educationHistories(): HasMany
    {
        return $this->hasMany(CandidateEducationHistory::class);
    }

    public function languages(): HasMany
    {
        return $this->hasMany(CandidateLanguage::class);
    }

    public function portfolio(): HasOne
    {
        return $this->hasOne(CandidatePortfolio::class);
    }

    public function credentials(): HasMany
    {
        return $this->hasMany(CandidateCredential::class);
    }
}
