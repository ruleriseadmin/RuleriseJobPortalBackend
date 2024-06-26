<?php

use App\Http\Controllers\Domain\Candidate\AccountSettingsController;
use App\Http\Controllers\Domain\Candidate\Auth\ForgotPasswordController;
use App\Http\Controllers\Domain\Candidate\Auth\LoginController;
use App\Http\Controllers\Domain\Candidate\Auth\RegisterController;
use App\Http\Controllers\Domain\Candidate\CandidatesController;
use App\Http\Controllers\Domain\Candidate\Data\CandidateLanguagesController;
use App\Http\Controllers\Domain\Candidate\Data\CredentialsController;
use App\Http\Controllers\Domain\Candidate\Data\EducationHistoriesController;
use App\Http\Controllers\Domain\Candidate\Data\WorkExperiencesController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function(){
    Route::post('register', [RegisterController::class, 'store']);
    Route::post('login', [LoginController::class, 'store']);
    Route::post('forgot-password/{email}', [ForgotPasswordController::class, 'sendResetPasswordLink']);
});

#authenticated routes
Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::get('profile', [CandidatesController::class, 'getProfile']);
    Route::post('update-profile', [CandidatesController::class, 'updateProfile']);
    Route::get('account-setting', [AccountSettingsController::class, 'index']);
    Route::post('update-account-setting', [AccountSettingsController::class, 'updateAccountSetting']);
    Route::post('delete-account', [AccountSettingsController::class, 'deleteAccount']);

    Route::prefix('work-experience')->group(function(){
        Route::post('/', [WorkExperiencesController::class, 'store']);
        Route::post('update', [WorkExperiencesController::class, 'update']);
        Route::post('{uuid}/delete', [WorkExperiencesController::class, 'delete']);
    });

    Route::prefix('education-history')->group(function(){
        Route::post('/', [EducationHistoriesController::class, 'store']);
        Route::post('update', [EducationHistoriesController::class, 'update']);
        Route::post('{uuid}/delete', [EducationHistoriesController::class, 'delete']);
    });

    Route::prefix('credential')->group(function(){
        Route::post('/', [CredentialsController::class, 'store']);
        Route::post('update', [CredentialsController::class, 'update']);
        Route::post('{uuid}/delete', [CredentialsController::class, 'delete']);
    });

    Route::prefix('language')->group(function(){
        Route::post('/', [CandidateLanguagesController::class, 'store']);
        Route::post('update', [CandidateLanguagesController::class, 'update']);
        Route::post('{uuid}/delete', [CandidateLanguagesController::class, 'delete']);
    });

    Route::prefix('profile')->group(function(){

    });
});
