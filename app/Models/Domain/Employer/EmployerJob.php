<?php

namespace App\Models\Domain\Employer;

use App\Models\Domain\Candidate\Job\CandidateJobApplication;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployerJob extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'employer_id',
        'title',
        'summary',
        'description',
        'job_type',
        'employment_type',
        'job_industry',
        'location',
        'years_experience',
        'salary',
        'easy_apply',
        'email_apply',
        'required_skills',
        'active',
    ];

    protected $casts = [
        'required_skills' => 'array',
        'active' => 'boolean',
        'easy_apply' => 'boolean',
        'email_apply' => 'boolean',
    ];

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class);
    }

    public function applicants(): HasMany
    {
        return $this->hasMany(CandidateJobApplication::class, 'job_id', 'id');
    }

    public static function whereUuid(string $uuid)
    {
        return self::query()->where('uuid', $uuid)->first();
    }
}
