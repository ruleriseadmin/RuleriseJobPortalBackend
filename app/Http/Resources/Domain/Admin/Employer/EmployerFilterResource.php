<?php

namespace App\Http\Resources\Domain\Admin\Employer;

use Illuminate\Http\Request;
use App\Supports\HelperSupport;
use App\Models\Domain\Employer\Employer;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployerFilterResource extends JsonResource
{
    private int $perPage = 10;

    private $employers;

    public function toArray(Request $request): array
    {
        $call = match($this->filterBy ?? ''){
            'all' => 'allEmployers',
            default => 'allEmployers',
        };

        $this->$call();

        $employers = $this->employers;

        return [
            'totalEmployers' => $employers->total(),
            'totalActiveEmployers' => 0,
            'totalInactiveEmployers' => 0,
            'totalBlacklistedEmployers' => 0,
            'employers' => $this->employerResponse(),
        ];
    }

    private function allEmployers()
    {
        $this->employers = Employer::query()->orderByDesc('created_at')->paginate($this->perPage);
    }

    private function employerResponse()
    {
        $paginatedEmployers = $this->employers;

        $employers = collect($paginatedEmployers->items())->map(function ($employer) {
            return HelperSupport::snake_to_camel([
                'uuid' => $employer->uuid,
                'company_name' => $employer->company_name,
                'email' => $employer->users()->first()->email, // adjust when user are multiple
                'created_at' =>$employer->created_at->toDateTimeString(),
                'jobs' => $employer->jobs->count(),
                'status' => 'active', //@todo adjust employer status
            ]);
        });

        return [
            'items' => $employers,
            'page' => $paginatedEmployers->currentPage(),
            'nextPage' =>  $paginatedEmployers->currentPage() + ($paginatedEmployers->hasMorePages() ? 1 : 0),
            'hasMorePages' => $paginatedEmployers->hasMorePages(),
        ];
    }
}
