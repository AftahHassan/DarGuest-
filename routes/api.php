<?php

use Illuminate\Support\Facades\Route;

Route::get('/user', function (Illuminate\Http\Request $request) {
    return $request->user();
})->middleware('auth:sanctum');