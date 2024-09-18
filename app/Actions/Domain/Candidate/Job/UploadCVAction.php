<?php

namespace App\Actions\Domain\Candidate\Job;

use App\Models\Domain\Candidate\CVDocument;
use File;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UploadCVAction
{
    public function execute($inputs): ?CVDocument
    {
        $user = auth()->user();

        try{
            // if (  $user->cv ){
            //     //delete old image
            //     Storage::delete("public/{$user->profile_picture_url}");
            // }

            $url = $this->uploadImage($inputs, $user);

            $cvDocument = $user->cvs()->create([
                'uuid' => str()->uuid(),
                'cv_document_url' => $url,
            ]);

            // $user->cv
            //     ? $user->cvs->update(['cv_document_url' => $url])
            //     : $user->cvs()->create([
            //         'uuid' => str()->uuid(),
            //         'cv_document_url' => $url,
            //     ]);
        }catch(Exception $ex){
            Log::error("Error @ UploadCVAction: " . $ex->getMessage());
            return null;
        }

        return $cvDocument;
    }

    private function uploadImage($imageData, $user): string
    {
        $count = $user->cvs->count();

        $fileName = "{$imageData['documentName']}.{$imageData['documentExtension']}";

        Storage::exists("public/cv")
            ? null
            : Storage::createDirectory("public/cv");

        $imagePath = Storage::path("public/cv/$fileName");

        File::put($imagePath, base64_decode($imageData['documentInBase64']));

        return "cv/$fileName";
    }
}
