<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Domain\Admin\Auth\LoginController;
use App\Http\Controllers\Domain\Admin\Candidate\CandidatesController;
use App\Http\Controllers\Domain\Admin\SubscriptionPlan\SubscriptionPlansController;


Route::prefix('auth')->group(function(){
    Route::post('login', [LoginController::class, 'store']);
});

#authenticated routes
Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::prefix('candidate')->group(function(){
        Route::get('/', [CandidatesController::class, 'index']);
        Route::get('{uuid}', [CandidatesController::class, 'show']);
    });

    Route::prefix('plan')->group(function(){
        Route::get('/', [SubscriptionPlansController::class, 'index']);
        Route::post('/', [SubscriptionPlansController::class, 'store']);
        Route::get('{uuid}', [SubscriptionPlansController::class, 'show']);
        Route::post('update', [SubscriptionPlansController::class, 'update']);
        Route::post('delete', [SubscriptionPlansController::class, 'destroy']);
        Route::post('setActive', [SubscriptionPlansController::class, 'setActive']);
    });
});

Route::prefix('profile')->group(function(){

});
