<?php

namespace App\Http\Controllers\Domain\Admin\WebsiteCustomization;

use App\Supports\ApiReturnResponse;
use App\Models\Domain\Shared\WebsiteCustomization;
use App\Http\Controllers\Domain\Admin\BaseController;
use App\Actions\Domain\Admin\WebsiteCrm\UploadImageAction;
use App\Actions\Domain\Admin\WebsiteCrm\AddNewContactAction;
use App\Actions\Domain\Admin\WebsiteCrm\SetCustomizationAction;
use App\Http\Resources\Domain\Admin\WebsiteCustomizationResource;
use App\Http\Requests\Domain\Admin\WebsiteCustomization\AddNewContactRequest;
use App\Http\Requests\Domain\Admin\WebsiteCustomization\StoreWebsiteCustomizationRequest;
use App\Http\Requests\Domain\Admin\WebsiteCustomization\UploadImageWebsiteCustomizationRequest;

class WebsiteCustomizationsController extends BaseController
{
    public function index(string $type)
    {
        if ( ! collect(WebsiteCustomization::TYPES)->contains($type) ) return ApiReturnResponse::notFound('Type not found');

        $sections = WebsiteCustomization::whereAllByType($type);

        return ApiReturnResponse::success(new WebsiteCustomizationResource( [
            'type' => $type,
            'sections' => $sections,
        ]));
    }

    public function store(StoreWebsiteCustomizationRequest $request)
    {
        $websiteCustomization = (new SetCustomizationAction)
            ->execute($request->input('type'), $request->input('sections'));

        return $websiteCustomization ? ApiReturnResponse::success() : ApiReturnResponse::failed();
    }

    public function addNewContact(AddNewContactRequest $request)
    {
        return (new AddNewContactAction)->execute($request->input())
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }

    public function uploadImage(UploadImageWebsiteCustomizationRequest $request)
    {
        $url = (new UploadImageAction)->execute($request->input());
        return $url ? ApiReturnResponse::success(['url' => $url]) : ApiReturnResponse::failed();
    }
}
