<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Domain\FrontPage\JobsController;
use App\Http\Controllers\Domain\FrontPage\EmployersController;
use App\Http\Controllers\Domain\FrontPage\CandidatesController;
use App\Http\Controllers\Domain\FrontPage\FrontPagesController;
use App\Http\Controllers\Domain\FrontPage\MetaInformationController;

Route::get('front-page', [FrontPagesController::class, 'index']);

Route::get('search-jobs', [JobsController::class, 'searchJobs']);

Route::get('latest-jobs', [JobsController::class, 'latestJobs']);

Route::get('job-categories', [MetaInformationController::class, 'getJobCategory']);

Route::prefix('employers')->group(function(){
    Route::get('/', [EmployersController::class, 'index']);
    Route::get('{uuid}', [EmployersController::class, 'show']);
});

Route::get('candidate-profile/{uuid}', [CandidatesController::class, 'show']);

Route::prefix('profile')->group(function(){

});
