<?php

namespace App\Models\Domain\Candidate;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateProfileViewCount extends Model
{
    use HasFactory;

    protected $fillable = [
        'view_count',
    ];
}
