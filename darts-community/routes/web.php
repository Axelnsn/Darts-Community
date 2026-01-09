<?php

use App\Http\Controllers\PlayerProfileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilePhotoController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('pages.home'))->name('home');

// Legal pages (public)
Route::get('/privacy-policy', fn() => view('pages.privacy-policy'))->name('privacy-policy');
Route::get('/terms', fn() => view('pages.terms'))->name('terms');

Route::get('/dashboard', function () {
    return redirect()->route('player.profile.edit');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Breeze profile routes (email/account management)
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Player profile routes (player info)
    Route::get('/player/profile/edit', [PlayerProfileController::class, 'edit'])->name('player.profile.edit');
    Route::put('/player/profile', [PlayerProfileController::class, 'update'])->name('player.profile.update');
    Route::get('/player/profile', [PlayerProfileController::class, 'show'])->name('player.profile.show');

    // Player profile photo routes
    Route::post('/player/profile/photo', [ProfilePhotoController::class, 'store'])->name('player.profile.photo.store');
    Route::delete('/player/profile/photo/{type}', [ProfilePhotoController::class, 'destroy'])->name('player.profile.photo.destroy');

    // Settings routes
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings/email', [SettingsController::class, 'updateEmail'])->name('settings.email.update');
    Route::put('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password.update');
    Route::get('/settings/export', [SettingsController::class, 'exportData'])->name('settings.export')->middleware('throttle:5,1440'); // 5 exports per day
    Route::delete('/settings/account', [SettingsController::class, 'destroy'])->name('settings.destroy');
});

require __DIR__.'/auth.php';
