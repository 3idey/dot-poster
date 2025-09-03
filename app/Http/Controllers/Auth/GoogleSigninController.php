<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleSigninController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            if (! request()->has('code')) {
                return redirect()->route('login.create')->withErrors(['msg' => 'Google login failed, try again.']);
            }

            $GoogleUser = Socialite::driver('google')->stateless()->user();

            if (! $GoogleUser || ! $GoogleUser->email) {
                return redirect()->route('login.create')->withErrors(['msg' => 'Unable to retrieve user information from Google.']);
            }

            $existingUser = User::where('email', $GoogleUser->email)->first();
            if ($existingUser) {
                // Update existing user's Google info if they don't have it
                if (! $existingUser->google_id) {
                    $existingUser->update([
                        'google_id' => $GoogleUser->id,
                        'google_token' => $GoogleUser->token,
                        'google_refresh_token' => $GoogleUser->refreshToken,
                        'avatar' => $GoogleUser->avatar ?: $existingUser->avatar,
                    ]);
                }
                Auth::login($existingUser);

                return redirect()->route('home');
            }

            $newUser = User::create([
                'name' => $GoogleUser->name ?: 'Google User',
                'email' => $GoogleUser->email,
                'google_token' => $GoogleUser->token,
                'google_refresh_token' => $GoogleUser->refreshToken,
                'google_id' => $GoogleUser->id,
                'avatar' => $GoogleUser->avatar,
                'password' => bcrypt(Str::random(16)),
            ]);

            Auth::login($newUser);

            return redirect()->route('home');

        } catch (\Exception $e) {
            \Log::error('Google OAuth Error: '.$e->getMessage());

            return redirect()->route('login.create')->withErrors(['msg' => 'Google authentication failed. Please try again.']);
        }
    }
}
