<?php

namespace App\Actions\Domain\Admin\WebsiteCrm;

use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\Domain\Shared\WebsiteCustomization;

class AddNewContactAction
{
    public function execute(array $inputs)
    {
        try{
            WebsiteCustomization::create([
                'type' => WebsiteCustomization::TYPES['contact'],
                'name' => $inputs['title'],
                'value' => $inputs['link'],
            ]);
            return true;
        }catch(Exception $ex){
            Log::error("Error @ AddNewContactAction: " . $ex->getMessage());
            return false;
        }
    }
}
