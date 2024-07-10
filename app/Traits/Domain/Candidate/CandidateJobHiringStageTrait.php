<?php

namespace App\Traits\Domain\Candidate;

trait CandidateJobHiringStageTrait
{
    public function setStatus(string $status)
    {
        $statuses = collect($this->hiring_stage ?? [])
            ->merge($this->getHiringStageUpdateAttributes($status));

        $this->update([
            'hiring_stage' => [$statuses],
        ]);

        $this->refresh();
    }

    public function status()
    {
        $statuses = collect($this->hiring_stage)->last();

        return $statuses['status'] ?? null;
    }

    protected function getHiringStageUpdateAttributes(string $status): array
    {
        return [
            'status' => $status,
            'created_at' => now(),
        ];
    }
}
