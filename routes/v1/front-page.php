<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Domain\FrontPage\JobsController;
use App\Http\Controllers\Domain\FrontPage\EmployersController;
use App\Http\Controllers\Domain\FrontPage\FrontPagesController;

Route::get('front-page', [FrontPagesController::class, 'index']);

Route::get('search-jobs', [JobsController::class, 'searchJobs']);

Route::get('latest-jobs', [JobsController::class, 'latestJobs']);

Route::prefix('employers')->group(function(){
    Route::get('/', [EmployersController::class, 'index']);
    Route::get('{uuid}', [EmployersController::class, 'show']);
});

Route::prefix('profile')->group(function(){

});
