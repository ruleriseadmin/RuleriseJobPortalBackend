<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('employer')->group(function(){
    include('v1/employer.php');
});

Route::prefix('candidate')->group(function(){
    include('v1/candidate.php');
});
