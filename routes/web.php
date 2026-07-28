<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\PropertyController;
use App\Http\Controllers\Web\ConversationController;
use App\Http\Controllers\Web\ReservationController;
use App\Http\Controllers\Web\NotificationController;


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

    Route::get('reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::post('reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('reservations/{reservation}', [ReservationController::class, 'show'])->name('reservations.show');
    Route::patch('reservations/{reservation}/status', [ReservationController::class, 'updateStatus'])->name('reservations.status');
    Route::patch('reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');

    Route::get('conversations', [ConversationController::class, 'index'])->name('conversations.index');
    Route::get('conversations/{conversation}', [ConversationController::class, 'show'])->name('conversations.show');
    Route::post('conversations/{conversation}/messages', [ConversationController::class, 'storeMessage'])->name('conversations.messages.store');

    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::match(['get', 'post'], 'notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::match(['get', 'post'], 'notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
        

});

require __DIR__.'/auth.php';
