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

    protected $guarded = [];

    public function qualification(): HasOne
    {
        return $this->hasOne(CandidateQualification::class);
    }
}
