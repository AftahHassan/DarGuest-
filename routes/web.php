<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\PropertyController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {

// Route::get('/dashboard', function () {
//         return auth()->user()->isOwner()
//             ? view('dashboard.owner')
//             : view('dashboard.guest');
//     })->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('properties', PropertyController::class);
    Route::post('properties/{property}/images', [PropertyController::class, 'uploadImages'])->name('properties.images.store');
    Route::delete('property-images/{propertyImage}', [PropertyController::class, 'deleteImage'])->name('properties.images.destroy');
    Route::put('properties/{property}/info', [PropertyController::class, 'updateInfo'])->name('properties.info.update');
    Route::post('properties/{property}/recommendations', [PropertyController::class, 'storeRecommendation'])->name('properties.recommendations.store');
    Route::delete('recommendations/{recommendation}', [PropertyController::class, 'destroyRecommendation'])->name('properties.recommendations.destroy');
    

});

require __DIR__.'/auth.php';
