<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest')
    ->name('register');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest')
    ->name('login');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.store');

Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::get('/profile', [ProfileController::class, 'showProfile'])
    ->middleware(['auth:sanctum'])
    ->name('profile');

Route::put('/profile', [ProfileController::class, 'updateProfile'])
    ->middleware(['auth:sanctum'])
    ->name('profile.update');

Route::get('/lawyer_profile', [ProfileController::class, 'showLawyerProfile'])
    ->middleware(['auth:sanctum'])
    ->name('lawyer_profile');

Route::put('/lawyer_profile', [ProfileController::class, 'updateLawyerProfile'])
    ->middleware(['auth:sanctum'])
    ->name('lawyer_profile.update');

Route::get('/firm_profile', [ProfileController::class, 'showFirmProfile'])
    ->middleware(['auth:sanctum'])
    ->name('firm_profile');

Route::put('/firm_profile', [ProfileController::class, 'updateFirmProfile'])
    ->middleware(['auth:sanctum'])
    ->name('firm_profile.update');
