<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Domain\Employer\EmployersController;
use App\Http\Controllers\Domain\Employer\Auth\LoginController;
use App\Http\Controllers\Domain\Employer\DashboardsController;
use App\Http\Controllers\Domain\Employer\Users\UsersController;
use App\Http\Controllers\Domain\Employer\Auth\RegisterController;
use App\Http\Controllers\Domain\Employer\MetaInformationController;
use App\Http\Controllers\Domain\Employer\Job\EmployerJobsController;
use App\Http\Controllers\Domain\Employer\Job\JobApplicantController;
use App\Http\Controllers\Domain\Employer\Plan\SubscriptionsController;
use App\Http\Controllers\Domain\Employer\Auth\ForgotPasswordController;
use App\Http\Controllers\Domain\Employer\Candidate\CandidatesController;
use App\Http\Controllers\Domain\Employer\Job\CandidateJobPoolsController;
use App\Http\Controllers\Domain\Employer\Plan\SubscriptionPaymentController;
use App\Http\Controllers\Domain\Shared\AccountSetting\ChangePasswordController;
use App\Http\Controllers\Domain\Employer\Auth\AccountEmailVerificationsController;
use App\Http\Controllers\Domain\Shared\AccountSetting\UserAccountSettingsController;
use App\Http\Controllers\Domain\Employer\Template\JobNotificationTemplatesController;

Route::prefix('auth')->group(function(){
    Route::post('register', [RegisterController::class, 'store']);
    Route::post('resendEmailVerification/{email}', [AccountEmailVerificationsController::class, 'resendEmailVerification']);
    Route::post('verifyEmail', [AccountEmailVerificationsController::class, 'verifyEmail']);
    Route::post('login', [LoginController::class, 'store']);
    Route::post('forgot-password/{email}', [ForgotPasswordController::class, 'sendResetPasswordLink']);
    Route::post('verify-forgot-password', [ForgotPasswordController::class, 'verifyResetPasswordLink']);
    Route::post('reset-password', [ForgotPasswordController::class, 'resetPassword']);
});


#authenticated routes
Route::group(['middleware' => ['auth:sanctum', 'user.ensureEmailIsVerified']], function(){
    Route::get('dashboard', [DashboardsController::class, 'index']);

    Route::get('jobCategory', [MetaInformationController::class, 'getJobCategory']);

    Route::prefix('job')->group(function(){
        Route::get('/', [EmployerJobsController::class, 'index']);
        Route::post('/', [EmployerJobsController::class, 'store']);
        Route::get('{uuid}', [EmployerJobsController::class, 'show']);
        Route::post('update', [EmployerJobsController::class, 'update']);
        Route::post('{uuid}/delete', [EmployerJobsController::class, 'delete']);
        Route::get('{uuid}/filterApplicantsByJob', [JobApplicantController::class, 'filterApplicantsByJob']);
        Route::post('applicants/update-hiring-stage', [JobApplicantController::class, 'changeHiringStage']);
        Route::post('{uuid}/setOpenClose', [EmployerJobsController::class, 'setOpenClose']);
        Route::post('{uuid}/publishJob', [EmployerJobsController::class, 'publishJob']);

        //application uuid
        Route::get('{uuid}/view-application', [JobApplicantController::class, 'viewApplication']);
    });



    Route::prefix('candidate-pool')->group(function(){
        Route::get('/', [CandidateJobPoolsController::class, 'index']);
        Route::post('/', [CandidateJobPoolsController::class, 'store']);
        Route::get('{uuid}/view-candidate', [CandidateJobPoolsController::class, 'viewCandidate']);
        Route::post('attach-candidate', [CandidateJobPoolsController::class, 'attachCandidatePool']);
    });

    Route::prefix('candidate')->group(function(){
        Route::get('/', [CandidatesController::class, 'index']);
        Route::get('{uuid}', [CandidatesController::class, 'show']);
        Route::post('application/change-hiring-stage', [CandidatesController::class, 'changeHiringStage']);
    });

    Route::prefix('profile')->group(function(){
        Route::get('/', [EmployersController::class, 'getProfile']);
        Route::post('/', [EmployersController::class, 'updateProfile']);
        Route::post('upload-logo', [EmployersController::class, 'uploadLogo']);
        Route::post('delete-account', [EmployersController::class, 'deleteAccount']);
        Route::post('change-password', [ChangePasswordController::class, 'store']);
        Route::post('upload-profile-picture', [UserAccountSettingsController::class, 'uploadProfilePicture']);
    });

    Route::prefix('cv-packages')->group(function(){
        Route::get('/', [SubscriptionPaymentController::class, 'subscriptionList']);
        Route::post('{uuid}/subscribe', [SubscriptionPaymentController::class, 'createPaymentLink']);
        Route::get('subscription-detail', [SubscriptionsController::class, 'subscriptionInformation']);
        Route::post('update-download-usage', [SubscriptionsController::class, 'updateCVDownloadUsage']);
        Route::post('verifySubscription', [SubscriptionPaymentController::class, 'verifySubscription']);
    });

    //Route::post('candidate-search', []);

    Route::prefix('job-notification-template')->group(function(){
        Route::post('/', [JobNotificationTemplatesController::class, 'updateTemplate']);
        Route::get('/', [JobNotificationTemplatesController::class, 'index']);
    });

    Route::prefix( 'users')->group(function(){
            Route::get('/', [UsersController::class, 'index']);
            Route::get('{uuid}', [UsersController::class, 'show']);
            Route::post('/', [UsersController::class, 'store']);
            Route::post('update', [UsersController::class, 'update']);
            Route::post('{uuid}/delete', [UsersController::class, 'delete']);
    });

    Route::prefix('profile')->group(function(){

    });
});
