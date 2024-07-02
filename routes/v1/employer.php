<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Domain\Employer\Auth\LoginController;
use App\Http\Controllers\Domain\Employer\EmployerJobsController;
use App\Http\Controllers\Domain\Employer\Auth\RegisterController;
use App\Http\Controllers\Domain\Employer\Auth\ForgotPasswordController;

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
        Route::post('update', [EmployerJobsController::class, 'update']);
    });

    Route::prefix('profile')->group(function(){

    });
});
