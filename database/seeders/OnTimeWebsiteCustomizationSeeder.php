<?php

namespace Database\Seeders;

use App\Models\Domain\Shared\WebsiteCustomization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OnTimeWebsiteCustomizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customizations = WebsiteCustomization::TYPES;

        foreach($customizations as $customization){
            $trait = str($customization)->camel()->value;
            collect(WebsiteCustomization::$trait())->map(fn($name) => WebsiteCustomization::create([
                'name' => $name,
                'type' => $customization,
            ]));
        }
    }
}
