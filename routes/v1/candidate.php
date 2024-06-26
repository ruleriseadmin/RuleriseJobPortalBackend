<?php

use App\Http\Controllers\Domain\Candidate\Auth\ForgotPasswordController;
use App\Http\Controllers\Domain\Candidate\Auth\LoginController;
use App\Http\Controllers\Domain\Candidate\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function(){
    Route::post('register', [RegisterController::class, 'store']);
    Route::post('login', [LoginController::class, 'store']);
    Route::post('forgot-password/{email}', [ForgotPasswordController::class, 'sendResetPasswordLink']);
});
