<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/websites', [WebsiteController::class, 'store']);
Route::post('/posts', [PostController::class, 'store']);
Route::post('/subscriptions', [SubscriptionController::class, 'store']);
