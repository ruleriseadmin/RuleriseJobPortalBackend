<?php

use App\Http\Controllers\Domain\FrontPage\FrontPagesController;
use Illuminate\Support\Facades\Route;

Route::get('front-page', [FrontPagesController::class, 'index']);
