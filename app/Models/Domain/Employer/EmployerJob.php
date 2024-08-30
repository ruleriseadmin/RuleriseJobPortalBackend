<?php

namespace App\Models\Domain\Employer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Domain\Employer\Job\EmployerJobViewCount;
use App\Models\Scopes\Domain\Employer\EmployerActiveScope;
use App\Models\Domain\Candidate\Job\CandidateJobApplication;

class EmployerJob extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'employer_id',
        'category_id',
        'title',
        'summary',
        'description',
        'job_type',
        'employment_type',
        'job_industry',
        'job_level',
        'location',
        'years_experience',
        'salary',
        'easy_apply',
        'email_apply',
        'required_skills',
        'active',
        'number_vacancy',
        'application_expiry',
        'language_required',
        'email_to_apply',
        'career_level',
    ];

    protected $casts = [
        'required_skills' => 'array',
        'active' => 'boolean',
        'easy_apply' => 'boolean',
        'email_apply' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new EmployerActiveScope);
    }

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class);
    }

    public function applicants(): HasMany
    {
        return $this->hasMany(CandidateJobApplication::class, 'job_id', 'id');
    }

    public function jobViewCounts(): HasMany
    {
        return $this->hasMany(EmployerJobViewCount::class);
    }

    public static function whereUuid(string $uuid)
    {
        return self::query()->where('uuid', $uuid)->first();
    }
}
