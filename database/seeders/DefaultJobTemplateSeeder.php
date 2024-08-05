<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Actions\Domain\Employer\Template\JobNotificationTemplate\ProcessDefaultNotificationTemplateAction;
use App\Models\Domain\Employer\Employer;

class DefaultJobTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employers = Employer::all();

        foreach($employers as $employer){
            if ( (bool) $employer->jobNotificationTemplate ) return;
            (new ProcessDefaultNotificationTemplateAction)->execute($employer);
        }
    }
}
