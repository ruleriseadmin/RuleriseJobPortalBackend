<?php

namespace App\Http\Resources\Domain\FrontPage\Employer;

use App\Traits\Domain\Shared\PaginationTrait;
use Illuminate\Http\Request;
use App\Supports\HelperSupport;
use App\Models\Domain\Employer\Employer;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployerFilterResource extends JsonResource
{
    use PaginationTrait;

    private int $perPage = 10;

    public function toArray(Request $request): array
    {
        $employers = Employer::where('active', true)->orderByDesc('created_at')->get();//->paginate($this->perPage);

        return $this->returnResponse($employers);
    }

    private function returnResponse($paginatedEmployers)
    {
        $employers = collect($paginatedEmployers)
                    ->map(function($employer){
                    //$job['createdAt'] = $job->created_at->toDateTimeString();

                    $employer['totalOpenJobs'] = $employer->openJobs()->count();

                    $employer['logoUrl'] = $employer->logo_url ? asset("storage/$employer->logo_url") : null;

                    $employer = HelperSupport::snake_to_camel(collect($employer)->except([
                        'id',
                        'created_at',
                        'updated_at',
                        'deleted_at',
                        'active',
                        'logo_url',
                    ])->toArray());

             return $employer;
            })->filter()->values();
         return $this->paginateFromCollection($employers, 12);

         return [
            'employers' => $employers,
            'page' => $paginatedEmployers->currentPage(),
            'nextPage' =>  $paginatedEmployers->currentPage() + ($paginatedEmployers->hasMorePages() ? 1 : 0),
            'hasMorePages' => $paginatedEmployers->hasMorePages(),
            'totalEmployers' => $paginatedEmployers->total(),
         ];
    }
}
