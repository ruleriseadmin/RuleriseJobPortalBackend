<?php

namespace App\Models\Domain\Employer\Job;

use App\Models\Domain\Candidate\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CandidateJobPool extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'employer_id',
        'name',
        'candidate_ids',
    ];

    protected $casts = [
        'candidate_ids' => 'array',
    ];

    public function getCandidates()
    {
        return User::findMany($this->candidate_ids);
    }
}
