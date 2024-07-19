<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Domain\Employer\EmployersController;
use App\Http\Controllers\Domain\Employer\Auth\LoginController;
use App\Http\Controllers\Domain\Employer\Auth\RegisterController;
use App\Http\Controllers\Domain\Employer\Job\EmployerJobsController;
use App\Http\Controllers\Domain\Employer\Job\JobApplicantController;
use App\Http\Controllers\Domain\Employer\Auth\ForgotPasswordController;
use App\Http\Controllers\Domain\Employer\Candidate\CandidatesController;
use App\Http\Controllers\Domain\Employer\Job\CandidateJobPoolsController;

Route::prefix('auth')->group(function(){
    Route::post('register', [RegisterController::class, 'store']);
    Route::post('login', [LoginController::class, 'store']);
    Route::post('forgot-password/{email}', [ForgotPasswordController::class, 'sendResetPasswordLink']);
});


#authenticated routes
Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::prefix('job')->group(function(){
        Route::get('/', [EmployerJobsController::class, 'index']);
        Route::post('/', [EmployerJobsController::class, 'store']);
        Route::get('{uuid}', [EmployerJobsController::class, 'show']);//changeHiringStage
        Route::post('update', [EmployerJobsController::class, 'update']);
        Route::post('{uuid}/delete', [EmployerJobsController::class, 'delete']);
        Route::get('{uuid}/filterApplicantsByJob', [JobApplicantController::class, 'filterApplicantsByJob']);
        Route::post('applicants/update-hiring-stage', [JobApplicantController::class, 'changeHiringStage']);
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
    });

    Route::prefix('profile')->group(function(){
        Route::get('/', [EmployersController::class, 'getProfile']);
        Route::post('/', [EmployersController::class, 'updateProfile']);
        Route::post('delete-account', [EmployersController::class, 'deleteAccount']);
    });

    Route::prefix('profile')->group(function(){

    });
});
