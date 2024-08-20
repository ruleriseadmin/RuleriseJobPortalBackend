<?php

namespace App\Actions\Domain\Candidate\Job;

use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\Domain\Candidate\CVDocument;
use Illuminate\Support\Facades\Storage;

class DeleteCVAction
{
    public function execute(CVDocument $cVDocument): bool
    {
        try{
            Storage::delete("public/$cVDocument->cv_document_url");
            $action = $cVDocument->delete();
        }catch(Exception $ex){
            Log::error("Error @ DeleteCVAction: " . $ex->getMessage());
            return false;
        }

        return $action;
    }
}
