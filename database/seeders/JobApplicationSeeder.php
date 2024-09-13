<?php

namespace Database\Seeders;

use App\Models\Domain\Candidate\Job\CandidateJobApplication;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        dd(CandidateJobApplication::all()[48]);
    }
}
