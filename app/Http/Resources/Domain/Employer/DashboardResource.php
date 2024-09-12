<?php

namespace App\Http\Resources\Domain\Employer;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Domain\Candidate\Job\CandidateJobApplication;

class DashboardResource extends JsonResource
{
    protected $jobs;

    public function toArray(Request $request): array
    {
        $dateFrom = Carbon::parse($this->filterBy['dateFrom'] ?? Carbon::now()->startOfMonth())->format('Y-m-d');

        $dateTo = Carbon::parse($this->filterBy['dateTo'] ?? Carbon::now()->endOfMonth())->format('Y-m-d');

        $jobs = $this->jobs()
            ->whereBetween('created_at', ["$dateFrom 00:00:00", "$dateTo 23:59:59.999999"])
            ->get();

        $this->jobs = $this->jobViewCounts()
            ->whereBetween('created_at', ["$dateFrom 00:00:00", "$dateTo 23:59:59.999999"])
            ->get();

        $applications = CandidateJobApplication::whereIn('job_id', $jobs->pluck('id'))
            ->whereDate('created_at', '>=', Carbon::now()->subDays(3))
            ->get(); //adjust

        $filterOverview = match($this->filterBy['filterOverview'] ?? 'week') {
            'week' => ['D', 'oW'],
            'month' => ['M', 'M'],
            'year' => ['Y', 'M'],
            default => ['D', 'oW'],
        };

        return [
            'openJobs' => $jobs->filter(fn($job) => $job->active)->count(),
            'messagedReceived' => 0,
            'candidatesApplied' => $applications->count(),
            'stats' => $this->getStats($filterOverview[0]),
            'extraStats' => $this->getExtraStats($filterOverview[1]),
        ];
    }

    private function getStats(string $filterOverview)
    {
        $jobs = collect([]);

        //Group jobViewCounts
        $grouped = $this->jobs->groupBy(fn($jobViewCount) => $jobViewCount->created_at->format($filterOverview));

        // Calculate sums for both view_count and apply_count
        $viewCountSums = $grouped->map(fn($jobViewCounts) => $jobViewCounts->sum('view_count'));

        $applyCountSums = $grouped->map(fn($jobViewCounts) => $jobViewCounts->sum('apply_count'));

        // Merge the results into the $jobs collection
        foreach ($viewCountSums as $day => $viewCountSum) {
            $jobs[$day] = collect([
                'view_count' => ceil(($jobs->get($day)['view_count'] ?? 0) + $viewCountSum),
                'apply_count' => ceil(($jobs->get($day)['apply_count'] ?? 0) + $applyCountSums[$day]),
            ]);
        }

        return $jobs;
    }

    private function getExtraStats(string $filterOverview)
    {
        $grouped = $this->jobs->groupBy(fn($jobViewCount) => $jobViewCount->created_at->format($filterOverview));

        // Calculate sums for both view_count and apply_count
        $viewCountSums = $grouped->map(fn($jobViewCounts) => $jobViewCounts->sum('view_count'));

        $applyCountSums = $grouped->map(fn($jobViewCounts) => $jobViewCounts->sum('apply_count'));

        // Get the current week and previous week
        $weeks = $viewCountSums->keys();
        $currentWeek = $weeks->last(); // Assuming current week is the last key
        $previousWeek = $weeks->slice(-2, 1)->first(); // Previous week is the second-to-last key

        $currentViewCount = $viewCountSums[$currentWeek] ?? 0;
        $previousViewCount = $viewCountSums[$previousWeek] ?? 0;
        $currentApplyCount = $applyCountSums[$currentWeek] ?? 0;
        $previousApplyCount = $applyCountSums[$previousWeek] ?? 0;

        $viewCountChange = $previousViewCount > 0
            ? (($currentViewCount - $previousViewCount) / $previousViewCount) * 100
            : 0;

        $applyCountChange = $previousApplyCount > 0
            ? (($currentApplyCount - $previousApplyCount) / $previousApplyCount) * 100
            : 0;

        // Determine if increase or decrease
        $viewCountChangeDirection = $viewCountChange > 0 ? 'increase' : ($viewCountChange < 0 ? 'decrease' : 'no change');
        $applyCountChangeDirection = $applyCountChange > 0 ? 'increase' : ($applyCountChange < 0 ? 'decrease' : 'no change');

        return [
            'jobView' => [
                'total' => ceil($currentViewCount),
                'percentage' => ceil($viewCountChange),
                'value_change' =>  $viewCountChangeDirection,
            ],
            'jobApply' => [
                'total' => ceil($currentApplyCount),
                'percentage' => ceil($applyCountChange),
                'value_change' => $applyCountChangeDirection,
            ],
        ];
    }
}
