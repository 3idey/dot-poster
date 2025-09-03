<?php

use App\Http\Controllers\Auth\GoogleSigninController;
use Illuminate\Support\Facades\Route;

Route::get('/auth/google', [GoogleSigninController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleSigninController::class, 'handleGoogleCallback'])->name('google.callback');
