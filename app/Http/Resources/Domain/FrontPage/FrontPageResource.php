<?php

namespace App\Http\Resources\Domain\FrontPage;

use Illuminate\Http\Request;
use App\Supports\HelperSupport;
use App\Models\Domain\Employer\Employer;
use App\Models\Domain\Employer\EmployerJob;
use App\Models\Domain\Shared\Job\JobCategories;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Domain\Admin\Job\CategoryResource;

class FrontPageResource extends JsonResource
{
    public function toArray(Request $request): array
    {

        $employers = Employer::all()
            ->filter(fn($employer) => $employer->openJobs->count() > 0 && $employer->active)
            ->take(8)
            ->map(fn($employer) => [
                'name' => $employer->company_name,
                'uuid' => $employer->uuid,
                'location' => $employer->state_city,
                'openJobs' => $employer->openJobs->count(),
                'logoUrl' => $employer->logo_url ? asset("storage/$employer->logo_url") : null,
        ])->toArray();

        $jobs = EmployerJob::all()->filter(fn($job) => $job->status == 'open' && $job->employer)->sortByDesc('created_at')->take(6);

        return [
            'latestJobs' => JobResource::collection($jobs),
            'companies' => HelperSupport::snake_to_camel($employers),
            'categories' => CategoryResource::collection(JobCategories::all()),
        ];
    }


}
