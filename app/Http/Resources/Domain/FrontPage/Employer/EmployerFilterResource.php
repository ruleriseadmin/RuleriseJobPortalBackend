<?php

namespace App\Http\Resources\Domain\FrontPage\Employer;

use Illuminate\Http\Request;
use App\Supports\HelperSupport;
use App\Models\Domain\Employer\Employer;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployerFilterResource extends JsonResource
{
    private int $perPage = 10;

    public function toArray(Request $request): array
    {
        $employers = Employer::where('active', true)->orderByDesc('created_at')->paginate($this->perPage);

        return $this->returnResponse($employers);
    }

    private function returnResponse($paginatedEmployers)
    {
        $employers = collect($paginatedEmployers->items())
                    ->map(function($employer){
                    //$job['createdAt'] = $job->created_at->toDateTimeString();

                    $employer['logo'] = null;

                    $employer['totalOpenJobs'] = $employer->openJobs()->count();

                    $employer = HelperSupport::snake_to_camel(collect($employer)->except([
                        'id',
                        'created_at',
                        'updated_at',
                        'deleted_at',
                        'active',
                    ])->toArray());

             return $employer;
            })->filter()->values();

         return [
            'employers' => $employers,
            'page' => $paginatedEmployers->currentPage(),
            'nextPage' =>  $paginatedEmployers->currentPage() + ($paginatedEmployers->hasMorePages() ? 1 : 0),
            'hasMorePages' => $paginatedEmployers->hasMorePages(),
            'totalEmployers' => $paginatedEmployers->total(),
         ];
    }
}
