<?php

namespace App\Actions\Domain\Admin\WebsiteCrm;

use App\Models\Domain\Shared\WebsiteCustomization;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SetCustomizationAction
{
    public function execute(string $type, array $inputs)
    {
        $customizations = WebsiteCustomization::whereAllByType($type);

        DB::beginTransaction();
        try{
            foreach($inputs as $item){
                $individual = $customizations->where('name', $item['name'])->first();

                if ( ! $individual ) continue;

                if ($item['name'] == 'images') return $this->handleImages($item);

                $individual->update($item);
            }
            DB::commit();
            return $customizations;
        }catch(Exception $ex){
            DB::rollBack();
            Log::error("Error @ SetCustomizationAction: " . $ex->getMessage());
            return null;
        }
    }

    private function handleImages(array $inputs)
    {}
}
