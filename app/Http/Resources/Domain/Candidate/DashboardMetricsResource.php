<?php

namespace App\Http\Resources\Domain\Candidate;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardMetricsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $jobAppliedCountLast30Days = $this->jobApplications()->whereDate('created_at', '>=', now()->subDays(30))->count();

        $profileViewCountLast30Days = $this->profileViewCounts()->whereDate('created_at', '>=', now()->subDays(30))->get()->sum('view_count');

        return [
            'jobAppliedCountLast30Days' => $jobAppliedCountLast30Days,
            'profileViewCountLast30Days' => $profileViewCountLast30Days,
        ];
    }
}
