<?php

use App\Http\Controllers\Domain\FrontPage\FrontPagesController;
use App\Http\Controllers\Domain\FrontPage\JobsController;
use Illuminate\Support\Facades\Route;

Route::get('front-page', [FrontPagesController::class, 'index']);

Route::get('search-jobs', [JobsController::class, 'searchJobs']);

Route::get('latest-jobs', [JobsController::class, 'latestJobs']);
