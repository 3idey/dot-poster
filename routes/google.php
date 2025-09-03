<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Auth\GoogleSigninController;

Route::get('/auth/google', [GoogleSigninController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleSigninController::class, 'handleGoogleCallback'])->name('google.callback');


