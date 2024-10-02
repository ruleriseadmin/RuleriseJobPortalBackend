<?php

namespace App\Actions\Domain\Admin\WebsiteCrm;

use App\Models\Domain\Shared\WebsiteCustomization;
use Illuminate\Support\Facades\Storage;
use File;
use Exception;
use Illuminate\Support\Facades\Log;

class UploadImageAction
{
    public function execute(array $inputs): string|null
    {
        $customization = WebsiteCustomization::getImagesByType($inputs['type']);

        $images = collect($customization?->meta ?? []);

        try{
            $imageBox = $images->where('image_box', $inputs['imageBox'])->first();

            if ( $imageBox ){
                //delete old image;
                Storage::delete("public/{$imageBox['url']}");
            }

            $url = $this->uploadImage($inputs, $inputs['type'], $inputs['imageBox']);

            $images = $images->where('image_box', '!=', $inputs['imageBox']);

            $images = $images->merge([
                [
                    'image_box' => $inputs['imageBox'],
                    'url' => $url
                ]
            ]);


            $customization->update(['meta' => $images]);

            return asset("storage/{$url}");
        }catch(Exception $ex){
            Log::error('Error @ UploadImageAction: ' . $ex->getMessage());
            return null;
        }
    }

    private function uploadImage($imageData, $type, $count)
    {
        $fileName = "{$type}-{$count}.{$imageData['imageExtension']}";

        Storage::exists("public/images")
            ? null
            : Storage::createDirectory("public/images");

        $imagePath = Storage::path("public/images/$fileName");

        File::put($imagePath, base64_decode($imageData['imageInBase64']));

        return "images/$fileName";
    }
}
