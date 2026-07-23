<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PropertyController;
use App\Http\Controllers\Api\PropertyImageController;
use App\Http\Controllers\Api\PropertyInfoController;
use App\Http\Controllers\Api\RecommendationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/register',[AuthController::class, 'register']);
Route::post('/login',[AuthController::class,'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('properties',PropertyController::class);
    Route::post('properties/{property}/images', [PropertyImageController::class, 'store']);
    Route::delete('property-images/{propertyImage}', [PropertyImageController::class, 'destroy']);
    Route::get('properties/{property}/info', [PropertyInfoController::class, 'show']);
    Route::put('properties/{property}/info', [PropertyInfoController::class, 'update']);

    Route::get('properties/{property}/recommendations', [RecommendationController::class, 'index']);
    Route::post('properties/{property}/recommendations', [RecommendationController::class, 'store']);
    Route::put('recommendations/{recommendation}', [RecommendationController::class, 'update']);
    Route::delete('recommendations/{recommendation}', [RecommendationController::class, 'destroy']);

});