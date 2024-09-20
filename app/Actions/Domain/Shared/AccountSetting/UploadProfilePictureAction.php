<?php

namespace App\Actions\Domain\Shared\AccountSetting;

use File;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UploadProfilePictureAction
{
    public function execute($inputs): bool
    {
        $user = auth()->user();

        $domain = str(class_basename($user))->kebab()->value();

        try{
            if (  $user->profile_picture_url ){
                //delete old image
                Storage::delete("public/{$user->profile_picture_url}");
            }

            $url = $this->uploadImage($inputs, $user, $domain);

            $user->update(['profile_picture_url' => $url]);
        }catch(Exception $ex){
            Log::error("Error @ UploadProfilePictureAction: " . $ex->getMessage());
            return false;
        }

        return true;
    }

    private function uploadImage($imageData, $user, $domain)
    {
        $fileName = "{$user->email}-profile-picture.{$imageData['imageExtension']}";

        Storage::exists("public/profile-pictures/$domain")
            ? null
            : Storage::createDirectory("public/profile-pictures/$domain");

        $imagePath = Storage::path("public/profile-pictures/$domain/$fileName");

        File::put($imagePath, base64_decode($imageData['imageInBase64']));

        return "profile-pictures/$domain/$fileName";
    }
}
