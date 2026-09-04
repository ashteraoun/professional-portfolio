<?php

use App\Http\Controllers\Api\BlogApiController;
use App\Http\Controllers\Api\ContactApiController;
use App\Http\Controllers\Api\ProjectApiController;
use App\Http\Controllers\Api\SearchApiController;
use App\Http\Controllers\Api\ServiceApiController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:api')->group(function () {
    Route::get('/projects', [ProjectApiController::class, 'index']);
    Route::get('/projects/{slug}', [ProjectApiController::class, 'show']);
    Route::get('/services', [ServiceApiController::class, 'index']);
    Route::get('/services/{slug}', [ServiceApiController::class, 'show']);
    Route::get('/blog', [BlogApiController::class, 'index']);
    Route::get('/blog/{slug}', [BlogApiController::class, 'show']);
    Route::get('/search', [SearchApiController::class, 'index']);
    Route::post('/contact', [ContactApiController::class, 'store'])->middleware('throttle:contact');
});
