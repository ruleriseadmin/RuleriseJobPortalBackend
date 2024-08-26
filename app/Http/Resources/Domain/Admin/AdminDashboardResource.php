<?php

namespace App\Http\Resources\Domain\Admin;

use Illuminate\Http\Request;
use App\Models\Domain\Candidate\User;
use App\Models\Domain\Employer\Employer;
use App\Models\Domain\Employer\EmployerJob;
use App\Models\Domain\Shared\Job\JobCategories;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminDashboardResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'totalJobCategory' => JobCategories::all()->count(),
            'totalCandidates' => User::all()->count(),
            'totalEmployers' => Employer::all()->count(),
            'totalJobs' => EmployerJob::all()->count(),
            'paymentTransactions' => [],
        ];
    }
}
