<?php

use App\Http\Controllers\Domain\Candidate\Auth\ForgotPasswordController;
use App\Http\Controllers\Domain\Candidate\Auth\LoginController;
use App\Http\Controllers\Domain\Candidate\Auth\RegisterController;
use App\Http\Controllers\Domain\Candidate\CandidatesController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function(){
    Route::post('register', [RegisterController::class, 'store']);
    Route::post('login', [LoginController::class, 'store']);
    Route::post('forgot-password/{email}', [ForgotPasswordController::class, 'sendResetPasswordLink']);
});

#authenticated routes
Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::get('profile', [CandidatesController::class, 'getProfile']);
    Route::post('updateProfile', [CandidatesController::class, 'updateProfile']);
    Route::prefix('profile')->group(function(){

    });
});
