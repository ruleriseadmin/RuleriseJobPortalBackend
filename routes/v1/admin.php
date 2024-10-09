<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Domain\Admin\DashboardController;
use App\Http\Controllers\Domain\Admin\Auth\LoginController;
use App\Http\Controllers\Domain\Admin\Job\JobCategoriesController;
use App\Http\Controllers\Domain\Admin\Employer\EmployersController;
use App\Http\Controllers\Domain\Admin\Candidate\CandidatesController;
use App\Http\Controllers\Domain\Admin\UserManagement\Rolescontroller;
use App\Http\Controllers\Domain\Admin\UserManagement\UsersController;
use App\Http\Controllers\Domain\Admin\GeneralSetting\GeneralSettingsController;
use App\Http\Controllers\Domain\Admin\SubscriptionPlan\SubscriptionPlansController;
use App\Http\Controllers\Domain\Admin\WebsiteCustomization\WebsiteCustomizationsController;
use App\Http\Controllers\Domain\Shared\AccountSetting\ChangePasswordController;

Route::prefix('auth')->group(function(){
    Route::post('login', [LoginController::class, 'store']);
});

#authenticated routes
Route::group(['middleware' => ['auth:sanctum']], function(){

    Route::get('dashboard-overview', [DashboardController::class, 'index']);

    Route::post('change-password', [ChangePasswordController::class, 'store']);

    Route::prefix('candidate')->group(function(){
        Route::get('/', [CandidatesController::class, 'index']);
        Route::get('{uuid}', [CandidatesController::class, 'show']);
        Route::post('{uuid}/delete', [CandidatesController::class, 'delete']);
        Route::post('{uuid}/moderateAccountStatus', [CandidatesController::class, 'moderateAccountStatus']);
        Route::post('{uuid}/setShadowBan', [CandidatesController::class, 'setShadowBan']);
    });

    Route::prefix('employer')->group(function(){
        Route::get('/', [EmployersController::class, 'index']);
        Route::get('{uuid}', [EmployersController::class, 'show']);
        Route::post('{uuid}/delete', [EmployersController::class, 'delete']);
        Route::post('{uuid}/moderateAccountStatus', [EmployersController::class, 'moderateAccountStatus']);
        Route::post('{uuid}/setShadowBan', [EmployersController::class, 'setShadowBan']);
    });

    Route::prefix('plan')->group(function(){
        Route::get('/', [SubscriptionPlansController::class, 'index']);
        Route::post('/', [SubscriptionPlansController::class, 'store']);
        Route::get('{uuid}', [SubscriptionPlansController::class, 'show']);
        Route::post('update', [SubscriptionPlansController::class, 'update']);
        Route::post('{uuid}/delete', [SubscriptionPlansController::class, 'destroy']);
        Route::post('setActive', [SubscriptionPlansController::class, 'setActive']);
    });

    Route::prefix('job-category')->group(function(){
        Route::get('/', [JobCategoriesController::class, 'index']);
        Route::post('/', [JobCategoriesController::class, 'store']);
        Route::get('{uuid}', [JobCategoriesController::class, 'show']);
        Route::post('update', [JobCategoriesController::class, 'update']);
        Route::post('{uuid}/delete', [JobCategoriesController::class, 'delete']);
        Route::post('{uuid}/setActive', [JobCategoriesController::class, 'setActive']);
    });

    Route::prefix('website-customization')->group(function(){
        Route::post('/', [WebsiteCustomizationsController::class, 'store']);
        Route::get('{type}', [WebsiteCustomizationsController::class, 'index']);
        Route::post('createNewContact', [WebsiteCustomizationsController::class, 'addNewContact']);
        Route::post('uploadImage', [WebsiteCustomizationsController::class, 'uploadImage']);
    });

    Route::prefix('general-setting')->group(function(){
        Route::get('/', [GeneralSettingsController::class, 'index']);
        Route::post('/', [GeneralSettingsController::class, 'store']);
    });

    Route::prefix('user-management')->group(function(){
        Route::prefix('role')->group(function(){
            Route::get('/', [Rolescontroller::class, 'index']);
            Route::get('{roleName}', [Rolescontroller::class, 'show']);
            Route::post('/', [Rolescontroller::class, 'store']);
            Route::post('update', [Rolescontroller::class, 'update']);
            Route::post('{roleName}/delete', [Rolescontroller::class, 'delete']);
        });

        Route::prefix('user')->group(function(){
            Route::get('/', [UsersController::class, 'index']);
            Route::get('{uuid}', [UsersController::class, 'show']);
            Route::post('/', [UsersController::class, 'store']);
            Route::post('update', [UsersController::class, 'update']);
            Route::post('{uuid}/delete', [UsersController::class, 'delete']);
        });
    });
});

Route::prefix('profile')->group(function(){

});
