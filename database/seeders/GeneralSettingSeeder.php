<?php

namespace Database\Seeders;

use App\Models\Domain\Admin\GeneralSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GeneralSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $generalSettings = [
            [
                'name' => 'default_currency',
                'value' => 'CAD',
            ],
            [
                'name' => 'candidate_delete_account',
                'value' => false,
            ],
            [
                'name' => 'employer_delete_account',
                'value' => false,
            ],
            [
                'name' => 'email_notification',
                'value' => false,
            ],
            [
                'name' => 'email_verification',
                'value' => false,
            ],
        ];

        collect($generalSettings)->map(fn($setting) => GeneralSetting::create($setting));
    }
}
