<?php

use App\Http\Controllers\Domain\Employer\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function(){
    Route::post('register', [RegisterController::class, 'store']);
});
