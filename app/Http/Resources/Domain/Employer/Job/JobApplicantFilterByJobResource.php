<?php

namespace App\Http\Resources\Domain\Employer\Job;

use App\Models\Domain\Candidate\Job\CandidateJobApplication;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use App\Supports\HelperSupport;

class JobApplicantFilterByJobResource extends JsonResource
{
    private int $perPage = 4;

    protected $rejectedApplications;

    protected $shortlisted;

    protected $offerSent;

    protected $unsorted;

    public function toArray(Request $request): array
    {
        $application = $this->job->applicants;

        $this->rejectedApplications =collect($this->job->applicants)
            ->filter(fn($application) => $application->status() === CandidateJobApplication::STATUSES['rejected'])
            ->map(fn($application) => $application->id);

        $this->shortlisted =collect($this->job->applicants)
            ->filter(fn($application) => $application->status() === CandidateJobApplication::STATUSES['shortlisted'])
            ->map(fn($application) => $application->id);

        $this->offerSent =collect($this->job->applicants)
            ->filter(fn($application) => $application->status() === CandidateJobApplication::STATUSES['offer_sent'])
            ->map(fn($application) => $application->id);

        $this->unsorted =collect($this->job->applicants)
            ->filter(fn($application) => $application->status() === CandidateJobApplication::STATUSES['unsorted'])
            ->map(fn($application) => $application->id);

        $call = match($this->filterBy ?? ''){
            'rejected' => 'applicantsByRejected',
            'offer_sent' => 'applicantsByOfferSent',
            'shortlisted' => 'applicantsByShortlisted',
            'unsorted' => 'applicantsByUnsorted',
            default => 'applicantsByAll',
        };

        return [
            'totalApplications' => $application->count(),
            'totalRejectedApplications' => $this->rejectedApplications->count(),
            'totalShortlistedApplications' => $this->shortlisted->count(),
            'totalOfferSentApplications' => $this->offerSent->count(),
            'totalUnsortedApplications' => $this->unsorted->count(),
            'applicants' => $this->applicantResponse($this->$call()),
        ];
    }

    public function applicantsByAll()
    {
        return $this->job->applicants()->orderByDesc('created_at')->paginate($this->perPage);
    }

    public function applicantsByUnsorted()
    {
        return CandidateJobApplication::whereIn('id', $this->unsorted)->orderByDesc('created_at')->paginate($this->perPage);
    }

    public function applicantsByShortlisted()
    {
        return CandidateJobApplication::whereIn('id', $this->shortlisted)->orderByDesc('created_at')->paginate($this->perPage);
    }

    public function applicantsByOfferSent()
    {
        return CandidateJobApplication::whereIn('id', $this->offerSent)->orderByDesc('created_at')->paginate($this->perPage);
    }

    public function applicantsByRejected()
    {
        return CandidateJobApplication::whereIn('id', $this->rejectedApplications)->orderByDesc('created_at')->paginate($this->perPage);
    }

    public function applicantResponse($paginatedApplicants)
    {
        $applicants = collect($paginatedApplicants->items())
            ->map(function($application){
                $applicant =  $application->applicant;
                $application['status'] = $application->status();
                $application['applied_at'] = $application->created_at;
                $application['cvUrl'] = $application->cv ?  asset("storage/{$application->cv->cv_document_url}") : null;
                $application['applicantInformation'] = [
                    'fullName' => $applicant->getFullNameAttribute(),
                    'uuid' => $applicant->uuid,
                    'jobTitle' => $applicant->job_title,
                    'location' => $applicant->location_province,
                    'workExperience' => [
                        'total' => $applicant->workExperiences->count(),
                        'data' => ! $applicant->workExperiences()->first() ? []: [
                            'roleTitle' => $applicant->workExperiences()->first()->role_title,
                            'companyName' => $applicant->workExperiences()->first()->company_name,
                            'startDate' => $applicant->workExperiences()->first()->start_date,
                            'endDate' => $applicant->workExperiences()->first()->end_date,
                        ],
                    ],
                    'educationHistory' => [
                        'total' => $applicant->educationHistories->count(),
                        'data' => ! $applicant->educationHistories()->first() ? []: [
                            'institutionName' => $applicant->educationHistories()->first()->institute_name,
                            'courseName' => $applicant->educationHistories()->first()->course_name,
                            'startDate' => $applicant->educationHistories()->first()->start_date,
                            'endDate' => $applicant->educationHistories()->first()->end_date,
                        ],
                    ],
                ];
                return HelperSupport::snake_to_camel(collect($application)->only([
                    'status',
                    'applied_via',
                    'cvUrl',
                    'applicantInformation',
                    'applied_at'
                ])->toArray());
            });

        return [
            'items' => $applicants,
            'page' => $paginatedApplicants->currentPage(),
            'nextPage' =>  $paginatedApplicants->currentPage() + ($paginatedApplicants->hasMorePages() ? 1 : 0),
            'hasMorePages' => $paginatedApplicants->hasMorePages(),
        ];
    }
}
