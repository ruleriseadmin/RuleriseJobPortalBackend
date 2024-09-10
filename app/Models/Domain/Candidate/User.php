<?php

namespace App\Models\Domain\Candidate;

use App\Models\User as ModelsUser;
use App\Traits\Domain\Shared\HasShadowBanTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Domain\Candidate\Job\CandidateSavedJob;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Domain\Candidate\Job\CandidateJobApplication;
use App\Models\Domain\Shared\ReportedJob;

class User extends ModelsUser
{
    use HasFactory;
    use SoftDeletes;
    use HasShadowBanTrait;

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
        'profile_picture_url',
        'active',
        'email_verified',
        'email_verified_token',
        'email_verified_at',
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

    public function savedJobs(): HasOne
    {
        return $this->hasOne(CandidateSavedJob::class);
    }

    public function jobApplications(): HasMany
    {
        return $this->hasMany(CandidateJobApplication::class);
    }

    public function cvs(): HasMany
    {
        return $this->hasMany(CVDocument::class);
    }

    public function reportedJobs(): HasMany
    {
        return $this->hasMany(ReportedJob::class);
    }

    public static function whereUuid(string $uuid)
    {
        return self::query()->where('uuid', $uuid)->first();
    }

    public static function whereEmail(string $email)
    {
        return self::query()->where('email', $email)->first();
    }
}
