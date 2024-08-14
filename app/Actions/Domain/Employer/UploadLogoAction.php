<?php

namespace App\Actions\Domain\Employer;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Domain\Employer\Employer;
use File;

class UploadLogoAction
{
    public function execute(Employer $employer, array $inputs): bool
    {
        try{
            if (  $employer->logo_url ){
                //delete old image
                Storage::delete("public/{$employer->logo_url}");
            }

            $url = $this->uploadImage($inputs, $employer);

            $employer->update(['logo_url' => $url]);
        }catch(Exception $ex){
            Log::error("Error @ UploadLogoAction: " . $ex->getMessage());
            throw new Exception('Error @ UploadLogoAction: ' . $ex->getMessage());
        }

        return true;
    }

    private function uploadImage($imageData, $employer)
    {
        $fileName = "{$employer->uuid}-company-logo.{$imageData['imageExtension']}";

        Storage::exists("public/company-logos")
            ? null
            : Storage::createDirectory("public/company-logos");

        $imagePath = Storage::path("public/company-logos/$fileName");

        File::put($imagePath, base64_decode($imageData['imageInBase64']));

        return "company-logos/$fileName";
    }
}
