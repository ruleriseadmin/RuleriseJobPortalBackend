<?php

namespace App\Http\Resources\Domain\FrontPage;

use App\Models\Domain\Employer\Employer;
use App\Models\Domain\Employer\EmployerJob;
use App\Supports\HelperSupport;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FrontPageResource extends JsonResource
{
    public function toArray(Request $request): array
    {

        $employers = Employer::all()
            ->filter(fn($employer) => $employer->openJobs->count() > 0)
            ->take(8)
            ->map(fn($employer) => [
                'name' => $employer->company_name,
                'location' => $employer->state_city,
                'jobs' => $employer->openJobs->count(),
        ])->toArray();

        $jobs = EmployerJob::all()->filter(fn($job) => $job->active && $job->employer)->sortByDesc('created_at')->take(6);

        return [
            'latestJobs' => JobResource::collection($jobs),
            'companies' => HelperSupport::snake_to_camel($employers),
            'categories' => [],
        ];
    }


}
