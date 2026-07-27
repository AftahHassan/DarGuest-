<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PropertyController;
use App\Http\Controllers\Api\PropertyImageController;
use App\Http\Controllers\Api\PropertyInfoController;
use App\Http\Controllers\Api\RecommendationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ConversationController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\ReservationController;


Route::post('/register',[AuthController::class, 'register']);
Route::post('/login',[AuthController::class,'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('properties', PropertyController::class)->names('api.properties');
    Route::post('properties/{property}/images', [PropertyImageController::class, 'store']);
    Route::delete('property-images/{propertyImage}', [PropertyImageController::class, 'destroy']);
    Route::get('properties/{property}/info', [PropertyInfoController::class, 'show']);
    Route::put('properties/{property}/info', [PropertyInfoController::class, 'update']);

    Route::get('properties/{property}/recommendations', [RecommendationController::class, 'index']);
    Route::post('properties/{property}/recommendations', [RecommendationController::class, 'store']);
    Route::put('recommendations/{recommendation}', [RecommendationController::class, 'update']);
    Route::delete('recommendations/{recommendation}', [RecommendationController::class, 'destroy']);

    Route::apiResource('reservations', ReservationController::class)
    ->except(['destroy'])
    ->names('api.reservations');
    Route::patch('reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('api.reservations.cancel');

    Route::get('conversations', [ConversationController::class, 'index'])->name('api.conversations.index');
    Route::get('conversations/{conversation}', [ConversationController::class, 'show'])->name('api.conversations.show');
    Route::get('conversations/{conversation}/messages', [MessageController::class, 'index'])->name('api.conversations.messages.index');
    Route::post('conversations/{conversation}/messages', [MessageController::class, 'store'])->name('api.conversations.messages.store');

});